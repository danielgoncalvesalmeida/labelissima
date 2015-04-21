<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Library to use DOMPDF PDF generation library
 */

require_once(APPPATH."third_party/dompdf/dompdf_config.inc.php");

class Cidompdf {
    var $dpdf;
    var $CI;
    
    public function __construct($config = array())
    {
		log_message('debug', "Dompdf Class Initialized");
        
        $this->CI =& get_instance();
        
        //$this->dpdf = new DOMPDF();
    }

    public function start()
    {
        $this->dpdf = new DOMPDF();
        $mydfp = new DOMPDF();
        ddd($mydfp);
    }

    public function loadHtml($html)
    {
        $this->dpdf->load_html($html);
    }

    public function renderToFile($filename)
    {
        $this->dpdf->stream($filename);
    }

    public function renderToOutput()
    {
        return $this->dpdf->output();
    }
    
}

/* End of file Dompdf.php */