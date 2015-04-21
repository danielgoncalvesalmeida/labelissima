<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
        
        $this->load->model('profiles_model');
        
        $this->addJs(array('admin_profiles.js',true));
    }

	public function index()
	{
        if(!_cr('admin')) return warning_noaccess();
        
        // Handle pagination if provided
        $this->p = $this->input->get_post('p',true);
        $this->n = $this->input->get_post('n',true);
        
        (empty($this->p) ? $this->p = 1 : '' );
        (empty($this->n) ? $this->n = $this->config->item('results_per_page_default') : '' );
        $dview['p'] = $this->p;
        
		$this->setTitle('Profiles - '.$this->config->item('appname'));
        
        $dview['profiles'] = $this->profiles_model->getProfiles($this->p, $this->n);
        
		$this->display('profiles_list',$dview);
	}
    
    public function add()
    {
        if(!_cr('admin','c')) return warning_noaccess();
        
        $this->setTitle('Ajouter un profile - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edname','nom','trim|required|callback_checkvalidprofilename|xss_clean');
        
        $dview = array();
        if ($this->form_validation->run())
        {
            // Save data
            $data = array(
                'id_domain' => (int)getUserDomain(), 
                'name' => ucfirst($this->input->post('edname')),
                'date_add' => date('Y-m-d H:i:s'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->insert('right_profile',$data);
            $id = $this->db->insert_id();
            $this->profiles_model->initProfile((int)$id);
            $dview['id_right_profile'] = $id;
            $dview['flash_success'] = 'Nouveau profile ajouté avec succès';
        }
        
		$this->display('profiles_add',$dview);
    }
    
    
    public function edit($id_right_profile)
    {
        if(!_cr('admin','e')) return warning_noaccess();
        
        $this->setTitle('Editer un profile - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edname','nom','trim|required|callback_checkvalidprofilename['.$id_right_profile.']|xss_clean');
                
        if ($this->form_validation->run())
        {
            // Update data
            $data = array(
                'name' => ucfirst($this->input->post('edname')),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_right_profile',$id_right_profile);
            $this->db->where('id_domain',(int)getUserDomain());
            $this->db->update('right_profile',$data);
            $dview['flash_success'] = 'Modifications enregistrées avec succès';
        }
        
        $dview['profile'] = $this->profiles_model->getProfile($id_right_profile);
		$this->display('profiles_edit',$dview);
    }
    
    public function delete($id)
    {
        if(!_cr('admin','d')) return warning_noaccess();
        
        // First check if there are users that are active and linked
        if($users = (int)$this->profiles_model->countUsers($id) > 0)
        {
            $this->setTitle('Profiles - '.$this->config->item('appname'));
            $dview['flash_error'] = 'Impossible de supprimer le profile tant que des utilisateurs sont liés au même.<br />Actuellement '.$users.' sont liés !';
            $dview['profiles'] = $this->profiles_model->getProfiles();
            $this->display('profiles_list',$dview);
        }
        else
        {
            $this->profiles_model->delete((int)$id);
            redirect('admin/profiles');
        }
    }
    
    public function permissions($id_right_profile)
    {
        if(!_cr('admin','e')) return warning_noaccess();
        
        if(!(int)$id_right_profile)
            die();
        
        // Insure this profile has all the rights mapped in table right_assign
        $this->profiles_model->syncRightNames((int)$id_right_profile);
        
        $this->setTitle('Editer les permissions du profile - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('submitPermissionsSave','required');
        
        if ($this->form_validation->run())
        {
            
            $view = $this->input->post('view');
            $create = $this->input->post('create');
            $edit = $this->input->post('edit');
            $delete = $this->input->post('delete');
            
            $this->profiles_model->resetProfileRightAssign((int)$id_right_profile);
            
            if(is_array($view))
                foreach ($view as $key => $value)
                {
                    $data = array('view' => true, 'date_upd' => date('Y-m-d H:i:s'));
                    $this->db->where('id_right_assign',(int)$key);
                    $this->db->where('id_right_profile',(int)$id_right_profile);
                    $this->db->where('id_domain',(int)getUserDomain());
                    $this->db->update('right_assign',$data);
                }
            
            if(is_array($create))
                foreach ($create as $key => $value)
                {
                    $data = array('create' => true, 'date_upd' => date('Y-m-d H:i:s'));
                    $this->db->where('id_right_assign',(int)$key);
                    $this->db->where('id_right_profile',(int)$id_right_profile);
                    $this->db->where('id_domain',(int)getUserDomain());
                    $this->db->update('right_assign',$data);
                }
                
            if(is_array($edit))
                foreach ($edit as $key => $value)
                {
                    $data = array('edit' => true, 'date_upd' => date('Y-m-d H:i:s'));
                    $this->db->where('id_right_assign',(int)$key);
                    $this->db->where('id_right_profile',(int)$id_right_profile);
                    $this->db->where('id_domain',(int)getUserDomain());
                    $this->db->update('right_assign',$data);
                }
                
            if(is_array($delete))
                foreach ($delete as $key => $value)
                {
                    $data = array('delete' => true, 'date_upd' => date('Y-m-d H:i:s'));
                    $this->db->where('id_right_assign',(int)$key);
                    $this->db->where('id_right_profile',(int)$id_right_profile);
                    $this->db->where('id_domain',(int)getUserDomain());
                    $this->db->update('right_assign',$data);
                }
                
            $dview['flash_success'] = 'Modifications enregistrées avec succès';
        }
        
        $dview['profile'] = $this->profiles_model->getProfile((int)$id_right_profile);
        $dview['permissions'] = $this->profiles_model->getPermissions((int)$id_right_profile);
		$this->display('profiles_permissions',$dview);
    }


    public function ajax()
    {
        if(!$this->input->is_ajax_request())
            die();
        
        $type = $this->input->get_post('type',true);
        
        // Check if the provided profile name exists
        if($type == 1)
        {
            $name = $this->input->get_post('name',true);
            $id_exclude = $this->input->get_post('exclude',true);
            $id_exclude = (!empty($id_exclude)? $id_exclude : null);
            if($this->profiles_model->profileExists($name, $id_exclude))
                echo json_encode (true);
            else
                echo json_encode (false);
        }
    }
    
    /*
     *  Form validation callback
     */
    public function checkvalidprofilename($str, $exclude = null)
    {
        if($this->profiles_model->profileExists($str, $exclude))
        {
            $this->form_validation->set_message('checkvalidprofilename','Le nom "'.$str.'" est déjà attribué ! Veuillez indiquer un autre.');
            return false;
        }
        else
            return true;
    }

}

