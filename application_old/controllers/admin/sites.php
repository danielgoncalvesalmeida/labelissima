<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
        
        $this->load->model('sites_model');
        
        $this->addJs(array('admin_sites.js',true));
    }

	public function index()
	{
        // Handle pagination if provided
        $this->p = $this->input->get_post('p',true);
        $this->n = $this->input->get_post('n',true);
        
        (empty($this->p) ? $this->p = 1 : '' );
        (empty($this->n) ? $this->n = $this->config->item('results_per_page_default') : '' );
        $dview['p'] = $this->p;
        
		$this->setTitle('Sites - '.$this->config->item('appname'));
        
        $dview['sites'] = $this->sites_model->getSites($this->p, $this->n);
        
		$this->display('sites_list',$dview);
	}
    
    public function add()
    {
        $this->setTitle('Ajouter un site - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edname','nom','trim|required|xss_clean');
                
        if ($this->form_validation->run())
        {
            $position = $this->sites_model->getMaxPosition();
            // Save data
            $data = array(
                'id_domain' => (int)getUserDomain(), 
                'name' => ucfirst($this->input->post('edname')),
                'tag' => genTag(),
                'order' => $position + 1,
                'date_add' => date('Y-m-d H:i:s'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->insert('site',$data);
            $dview['id_site'] = $this->db->insert_id();
            $dview['flash_success'] = 'Nouveau site ajouté avec succès';
        }
        
        $dview['sites'] = $this->sites_model->getSites();
		$this->display('sites_add',$dview);
    }
    
    
    public function edit($id_site)
    {
        $this->setTitle('Editer un site - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edname','nom','trim|required|xss_clean');
        $this->form_validation->set_rules('edenabled','activé','required|integer');
                
        if ($this->form_validation->run())
        {
            // Update data
            $data = array(
                'name' => ucfirst($this->input->post('edname')), 
                'enabled' => $this->input->post('edenabled'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_site',$id_site);
            $this->db->update('site',$data);
            $dview['flash_success'] = 'Modifications enregistrées avec succès';
        }
        
        $dview['site'] = $this->sites_model->getSite($id_site);
		$this->display('sites_edit',$dview);
    }
    
    public function delete($id)
    {
        $this->sites_model->delete((int)$id);
        redirect('admin/sites');
    }
    
    /*
     * Swap position : id_current becomes position of id_swao
     * @current id
     * @next id
     */
    public function swap($id_current, $id_swap)
    {
        $this->sites_model->swapPosition((int)$id_current, (int)$id_swap);
        $this->index();
    }
    
    public function ajax()
    {
        if(!$this->input->is_ajax_request())
            die();
        
        $type = $this->input->get_post('type',true);
        
        // Check if the provided site name exists
        if($type == 1)
        {
            $name = $this->input->get_post('name',true);
            if($this->sites_model->siteExists($name))
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

