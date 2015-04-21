<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parents extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
        
        $this->load->model('parents_model');
        
        $this->addJs(array('admin_parents.js',true));
    }
    
    public function index()
	{
        // Check rights
        if(!_cr('parents', 'v'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        // Handle pagination if provided
        $this->p = $this->input->get_post('p',true);
        $this->n = $this->input->get_post('n',true);
        
        (empty($this->p) ? $this->p = 1 : '' );
        (empty($this->n) ? $this->n = $this->config->item('results_per_page_default') : '' );
        $dview['p'] = $this->p;
        
		$this->setTitle('Parents - '.$this->config->item('appname'));
        
        $dview['parents'] = $this->parents_model->getParents($this->p, $this->n);
        $dview['parents_count'] = $this->parents_model->getParentsCount();
        
		$this->display('parents_list',$dview);
    }
    
    public function add()
    {
        // Check rights
        if(!_cr('parents', 'c'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        $this->setTitle('Ajouter un parent - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edlastname','nom','trim|required|xss_clean');
        $this->form_validation->set_rules('edfirstname','prénom','trim|required|xss_clean');
        $this->form_validation->set_rules('edsocialid','matricule sociale','trim|alpha_dash|required|xss_clean|callback_checksocialidnotexists');
        $this->form_validation->set_rules('edemail','email','trim|valid_email|xss_clean|callback_checkemailnotexists');
        $this->form_validation->set_rules('edmobile','téléphone mobile','trim|xss_clean');
        $this->form_validation->set_rules('edphonehome','téléphone domicile','trim|xss_clean');
        $this->form_validation->set_rules('edphonework','téléphone lieu de travail','trim|xss_clean');
        $this->form_validation->set_rules('edaddress','adresse domicile','trim|xss_clean');
        $this->form_validation->set_rules('edcity','localité','trim|xss_clean');
        $this->form_validation->set_rules('edcode','code postal','trim|xss_clean');
        $this->form_validation->set_rules('edcountry','pays','required|alpha|exact_length[2]');
        $this->form_validation->set_rules('edsite','site par défaut','required|integer');
                
        if ($this->form_validation->run())
        {
            // Save data
            $data = array(
                'id_site_default' => $this->input->post('edsite'), 
                'id_domain' => $this->session->userdata('id_domain'),
                
                'firstname' => ucwords($this->input->post('edfirstname')), 
                'lastname' => ucwords($this->input->post('edlastname')), 
                'socialid' => strtoupper($this->input->post('edsocialid')),
                'socialid_srch' => my_searchString($this->input->post('edsocialid')),
                'email' => strtolower($this->input->post('edemail')),
                'mobile' => $this->input->post('edmobile'), 
                'phone_home' => $this->input->post('edphonehome'), 
                'phone_work' => $this->input->post('edphonework'), 
                'address' => $this->input->post('edaddress'), 
                'city' => ucwords($this->input->post('edcity')), 
                'code' => $this->input->post('edcode'), 
                'country_iso' => $this->input->post('edcountry'), 
                'tag' => genTag(),
                'date_add' => date('Y-m-d H:i:s'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->insert('parent',$data);
            $dview['id_parent'] = $this->db->insert_id();
            $dview['flash_success'] = 'Nouveau parent ajouté avec succès';
        }
        
        $this->load->model('groups_model');
        $dview['sites'] = $this->groups_model->getSites();
		$this->display('parents_add',$dview);
    }
    
    public function edit($id_parent)
    {
        // Check rights
        if(!_cr('parents', 'e'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        $this->setTitle('Editer le parent - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('edlastname','nom','trim|required|xss_clean');
        $this->form_validation->set_rules('edfirstname','prénom','trim|required|xss_clean');
        $this->form_validation->set_rules('edsocialid','matricule sociale','trim|alpha_dash|required|xss_clean');
        $this->form_validation->set_rules('edemail','email','trim|valid_email|xss_clean');
        $this->form_validation->set_rules('edmobile','téléphone mobile','trim|xss_clean');
        $this->form_validation->set_rules('edphonehome','téléphone domicile','trim|xss_clean');
        $this->form_validation->set_rules('edphonework','téléphone lieu de travail','trim|xss_clean');
        $this->form_validation->set_rules('edaddress','adresse domicile','trim|xss_clean');
        $this->form_validation->set_rules('edcity','localité','trim|xss_clean');
        $this->form_validation->set_rules('edcode','code postal','trim|xss_clean');
        $this->form_validation->set_rules('edcountry','pays','required|alpha|exact_length[2]');
        $this->form_validation->set_rules('edcountry','langue parlée','trim|xss_clean');
        $this->form_validation->set_rules('edsite','site par défaut','required|integer');
                
        if ($this->form_validation->run())
        {
            // Save data
            $data = array(
                'id_site_default' => $this->input->post('edsite'), 
                'firstname' => ucwords($this->input->post('edfirstname')), 
                'lastname' => ucwords($this->input->post('edlastname')), 
                'socialid' => strtoupper($this->input->post('edsocialid')),
                'socialid_srch' => my_searchString($this->input->post('edsocialid')),
                'email' => strtolower($this->input->post('edemail')),
                'mobile' => $this->input->post('edmobile'), 
                'phone_home' => $this->input->post('edphonehome'), 
                'phone_work' => $this->input->post('edphonework'), 
                'address' => $this->input->post('edaddress'), 
                'city' => ucwords($this->input->post('edcity')), 
                'code' => $this->input->post('edcode'), 
                'country_iso' => $this->input->post('edcountry'), 
                'language' => $this->input->post('edlanguage'), 
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_parent',$id_parent);
            $this->db->update('parent',$data);
            $dview['flash_success'] = 'Modifications enregistrées avec succès';
        }
        
        $dview['parent'] = $this->parents_model->getParent($id_parent);
        $this->load->model('groups_model');
        $dview['sites'] = $this->groups_model->getSites();
		$this->display('parents_edit',$dview);
    }
    
    public function view($id)
    {
        // Check rights
        if(!_cr('parents', 'v'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $dview['parent'] = $this->parents_model->getParent((int)$id);
        $dview['active_children'] = $this->parents_model->getActiveChildren((int)$id);
        //ddd($dview);
        $this->display('parents_view',$dview);
    }
    
    public function delete($id)
    {
        // Check rights
        if(!_cr('parents', 'd'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        $this->parents_model->delete((int)$id);
        redirect('admin/parents');
    }
    
    
    public function ajax()
    {
        if(!$this->input->is_ajax_request())
            die();
        
        $type = $this->input->get_post('type',true);
        
        // Check if the provided socialid exists
        if($type == 1)
        {
            $value = $this->input->get_post('value',true);
            $id_exclude = $this->input->get_post('exclude',true);
            $id_exclude = (!empty($id_exclude)? $id_exclude : null);
            if($this->parents_model->socialidExists($value, $id_exclude))
                echo json_encode (true);
            else
                echo json_encode (false);
        }
        
        
        // Check if the provided email exists
        if($type == 2)
        {
            $value = $this->input->get_post('value',true);
            $id_exclude = $this->input->get_post('exclude',true);
            $id_exclude = (!empty($id_exclude)? $id_exclude : null);
            if($this->parents_model->emailExists($value, $id_exclude))
                echo json_encode (true);
            else
                echo json_encode (false);
        }
    }
    
    /*
     * Form validation callback -> socialid
     */
    public function checksocialidnotexists($value, $id_exclude = null)
    {
        if($this->parents_model->socialidExists($value, $id_exclude))
        {
            $this->form_validation->set_message('checksocialidnotexists', 'Numéro déjà attribué');   
            return false;
        }
        else
            return true;
    }
    
    /*
     * Form validation callback -> email
     */
    public function checkemailnotexists($value, $id_exclude = null)
    {
        if($this->parents_model->emailExists($value, $id_exclude))
        {
            $this->form_validation->set_message('checkemailnotexists', 'Email déjà attribué');   
            return false;
        }
        else
            return true;
    }
    
}