<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends My_Controller {
    
    public function __construct()
    {
        $this->layout = 'front';
        parent::__construct();
    }
    
	public function index()
	{
		$this->setTitle('Restaurant | La belissima');
        $dview = array();
        $this->display('home',$dview);
    }
}

