<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//
// Library that gives functionalities to perfromance increase using multiple 
// urls to download images
//

class Mymedia {
    var $servers = array();
    var $_needle = null;
    
    public function __construct($config = array())
    {
		log_message('debug', "Mymedia Class Initialized");
    }
    
    public function initialize($config = array())
    {
        if (count($config) > 0)
		{
			$this->servers = $config;
            $this->_needle = (count($this->servers) > 0 ? 0 : null);
		}
		else
		{
			$this->_needle = null;
		}
    }
    
    public function setImgTag($filename,$alt = null, $title = null, $width = null, $height = null)
    {
        if(isset($this->_needle)){
            $tag = '<img src="'.$this->servers[$this->_needle].$filename.'"'
                .(isset($width) ? ' width="'.(int)$width.'"' : '' )
                .(isset($height) ? ' height="'.(int)$height.'"' : '' )
                .(isset($alt) ? ' alt="'.$alt.'"' : '' )
                .(isset($title) ? ' title="'.$title.'"' : '' )
                ." >";
       
            if ($this->_needle < count($this->servers)-1 ){
                $this->_needle = $this->_needle + 1;
            } else {
                $this->_needle = 0;
            }
           return $tag;
        } else {
            $tag = '<img src="'.base_url().$filename.'"'
                .(isset($width) ? ' width="'.(int)$width.'"' : '' )
                .(isset($height) ? ' height="'.(int)$height.'"' : '' )
                .(isset($alt) ? ' alt="'.$alt.'"' : '' )
                .(isset($title) ? ' title="'.$title.'"' : '' )
                ." >";
            return $tag;
        }
    }
    
    
    
    
}

/* End of file Mymedia.php */