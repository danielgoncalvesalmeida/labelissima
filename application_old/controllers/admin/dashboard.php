<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
    }

	public function index()
	{
		$this->setTitle('Tableau de bord - '.$this->config->item('appname'));
        $data = array();
        
		$this->display('dashboard',$data);
	}

}


/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */