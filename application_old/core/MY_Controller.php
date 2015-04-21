<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    public $meta = array();
    public $icon = '';
    public $icon_shortcut = '';
    public $layout = '';
    public $_js = array();
    public $_css = array();
    public $https = false;
    
    public function __construct()
    {
        parent::__construct(); 

        // Force HTTPS if required
        if($this->config->item('use_https') && $this->https && strpos(current_url(),'https://') === FALSE)
            redirect(sbase_url().$this->uri->uri_string());

        var_dump($_SERVER['REQUEST_URI']);
        
        $this->setTitle('');
        $this->setDescription('');

        if($this->layout == 'front')
        {
          //$this->addCss('styles.css');
        }
        
    }
    
    /*
     * Check if the user has the necessary rights for this zone
     */
    public function isZone($name = '')
    {
        if(!($this->session->userdata('id_user') > 0 && $this->session->userdata('zone') === $name) )
            redirect('login');
    }
    
    /*
     * Add JS files to the header
     * @param filename 
     */
    public function addJs($js, $fullurl = false)
    {
        // simple filename provided
        if(!is_array($js)){
            if($fullurl)
                $this->_js[] = $js;
            else
                $this->_js[] = base_url().$this->config->item('assets_path').'js/'.$js; 
            
            return TRUE;
        }
        
        // Param is array : Try to use the first media server
        $server1 = $this->config->item('media_servers');
        $_base_url = (isset($server1[0]) ? $server1[0] : base_url());
        $this->_js[] =  $_base_url.$this->config->item('assets_path').'js/'.$js[0];
        return TRUE;
    }
    
    
    /*
     * Add CSS files to the header
     * @param filename 
     */
    public function addCss($css, $fullurl = false)
    {
        // simple filename provided
        if(!is_array($css)){
            if($fullurl)
                $this->_css[] = $css;
            else
                $this->_css[] = base_url().$this->config->item('assets_path').'css/'.$css;
            
            return TRUE;
        }
        
        // Param is array : Try to use the first media server
        $server1 = $this->config->item('media_servers');
        $_base_url = (isset($server1[0]) ? $server1[0] : base_url());
        $this->_css[] =  $_base_url.$this->config->item('assets_path').'css/'.$css[0];
        return TRUE;
    }
    
    /*
     * Set the title of the page
     */
    public function setTitle($str)
    {
        $this->meta['title'] = $str;
    }
    
    /*
     * Set the meta description of the page
     */
    public function setDescription($str)
    {
        $this->meta['description'] = $str;
    }    
    
    /*
     * Show the content based on the layout
     */
    public function display($view, $data = array())
	{
		//global data
		$globalData = array(
			'meta' => $this->meta,
			'css' => $this->_css,
			'js' => $this->_js,
			'page_name' => $this->router->{'class'}.'-'.$this->router->method,
			'output' => $this->load->view($this->layout.'/'.$view, $data, TRUE)
		);
		$this->load->view('layouts/'.$this->layout, $globalData);
	}
    
    
    
    
// End of class
}