<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Library to load domain wide configuration
 */

class Myconfig {
    var $CI;
    
    private $params = array(
        'CHILD_LASTNAME_UPPERCASE'  => 1,    // Force the lastname to uppercase
        'CHILD_NAME_DISPLAY'        => 1,    // 1: Show firstname 2: Show lastname
        'PARENT_LASTNAME_UPPERCASE'  => 1,    // Force the lastname to uppercase
        'PARENT_NAME_DISPLAY'        => 1,    // 1: Show firstname 2: Show lastname
    );
    
    public function __construct()
    {
		log_message('debug', "Myconfig Class Initialized");
        
        $this->CI =& get_instance();
        
        // The rights
        $sql = "SELECT * 
        FROM ".$this->CI->db->dbprefix('configuration')." c
        WHERE c.`id_domain` = ".(int)getUserDomain();
        $rights = $this->CI->db->query($sql)->result_array();
        
        foreach ($rights as $value)
            $this->params[$value['name']] = $value['value'];
    }
    
    
    public function getConfig($name, $default = null)
    {
        // Check if there is any valid $name
        // If default is not set other than NULL return false
        if(empty($name))
        {
           if(!is_null($default)) 
               return $default;
           else
               return $false;
        }
        
        // Look for the parameter
        if(isset($this->params[$name]))
            return $this->params[$name];
        else
        {
            if(!is_null($default)) 
               return $default;
           else
               return false;
        } 
    }
    
}

