<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
        
        $this->load->model('groups_model');
        
        $this->addJs(array('admin_groups.js',true));
    }

	public function index()
	{
        // Handle pagination if provided
        $this->p = $this->input->get_post('p',true);
        $this->n = $this->input->get_post('n',true);
        
        (empty($this->p) ? $this->p = 1 : '' );
        (empty($this->n) ? $this->n = $this->config->item('results_per_page_default') : '' );
        $dview['p'] = $this->p;
        
		$this->setTitle('Groupes - '.$this->config->item('appname'));
        
        $dview['groups'] = $this->groups_model->getGroups($this->p, $this->n);
        
		$this->display('groups_list',$dview);
	}
    
    public function add()
    {
        $this->setTitle('Ajouter un group - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edname','nom','trim|required|xss_clean');
        $this->form_validation->set_rules('edsite','site','required|integer|callback_checkSiteId');
                
        if ($this->form_validation->run())
        {
            $position = $this->groups_model->getMaxPosition();
            // Save data
            $data = array(
                'id_domain' => (int)getUserDomain(), 
                'name' => ucfirst($this->input->post('edname')), 
                'id_site' => $this->input->post('edsite'),
                'tag' => genTag(),
                'order' => $position + 1,
                'date_add' => date('Y-m-d H:i:s'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->insert('child_group',$data);
            $dview['id_group'] = $this->db->insert_id();
            $dview['flash_success'] = 'Nouveau group ajouté avec succès';
        }
        
        $dview['sites'] = $this->groups_model->getSites();
		$this->display('groups_add',$dview);
    }
    
    
    public function edit($id_child_group)
    {
        $this->setTitle('Editer un group - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edname','nom','trim|required|xss_clean');
        $this->form_validation->set_rules('edsite','site','required|integer|callback_checkSiteId');
        $this->form_validation->set_rules('edenabled','activé','required|integer');
                
        if ($this->form_validation->run())
        {
            // Update data
            $data = array(
                'name' => ucfirst($this->input->post('edname')), 
                'id_site' => $this->input->post('edsite'),
                'enabled' => $this->input->post('edenabled'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_child_group',$id_child_group);
            $this->db->update('child_group',$data);
            $dview['flash_success'] = 'Modifications enregistrées avec succès';
        }
        
        $dview['group'] = $this->groups_model->getGroup($id_child_group);
        $dview['sites'] = $this->groups_model->getSites();
		$this->display('groups_edit',$dview);
    }
    
    public function delete($id)
    {
        $this->groups_model->delete((int)$id);
        redirect('admin/groups');
    }
    
    /*
     * Swap position : id_current becomes position of id_swao
     * @current id
     * @next id
     */
    public function swap($id_current, $id_swap)
    {
        $this->groups_model->swapPosition((int)$id_current, (int)$id_swap);
        $this->index();
    }
    
    /**
     * Displays the group journal with all kids
     * 
     * @param type $id
     * @param type $date
     */
    public function viewjournal($id, $date = null)
    {
        if($this->input->get('backgroup'))
        {
            $id_group = $this->input->get('backgroup');
            $dview['link_back'] = 'admin/desktop/viewgroup/'.(int)$id;
        }
            
        if(!$date)
            $date = new Datetime(date('Y-m-d'));
        else 
            $date = new Datetime($date);
        
        $this->load->model('calendar_model');
        $dview['nav'] = $this->calendar_model->getWeekDaysBasedNavigation(date_format($date, 'Y-m-d'),5);
        
        $group = $this->groups_model->getGroup((int)$id);
        
        $this->setTitle('Journal du groupe  '.$group->name);
        
        // Get the children (array) with a subarray ['events'] containing the journal for each child
        $journal = $this->groups_model->getGroupJournal($id, $date); 
   
        $dview['group'] = $group;
        $dview['date_journal'] = $date;
        $dview['journal'] = $journal;
//ddd($dview);
        $this->display('groups_viewjournal',$dview);
    }
    
    
    public function ajax()
    {
        if(!$this->input->is_ajax_request())
            die();
        
        $type = $this->input->get_post('type',true);
        
        // Check if the provided group name exists
        if($type == 1)
        {
            $name = $this->input->get_post('name',true);
            if($this->groups_model->groupExists($name))
                echo json_encode (true);
            else
                echo json_encode (false);
        }
    }
    
    /*
     * Callback function for form validation
     */
    public function checkSiteId($id)
    {
        $this->load->model('sites_model');
        if ($this->sites_model->checkSiteIsValid($id))
            return true;
        else
        {
            $this->form_validation->set_message('checkSiteId','Le %s indiqué n\'existe pas ! Veuillez choisir un autre.');
            return false;
        }
    }

}

