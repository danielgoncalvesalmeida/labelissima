<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends My_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
    public function __construct()
    {
        parent::__construct();
        $this->addJs('test.js');
        $this->addJs(array('test2.js',TRUE));
        $this->addJs('http://jquery.com/jquery.js',TRUE);
        
        $this->addCss('test.css');
        $this->addCss(array('test2.css',TRUE));
        $this->addCss(array('test3.css',TRUE));
    }
    
	public function index()
	{
		//var_dump($_SERVER);
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */