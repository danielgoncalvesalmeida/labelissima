<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Library to use HTML2PDF PDF generation library
 */

require_once(APPPATH."third_party/html2pdf/html2pdf.class.php");

class Cihtml2pdf {
    var $html2pdf;
    var $CI;
    
    public function __construct($config = array())
    {
		log_message('debug', "Html2Pdf Class Initialized");
        
        $this->CI =& get_instance();
    }

    public function start()
    {
        $this->html2pdf = new HTML2PDF('P','A4','fr');
    }

    public function loadHtml($html)
    {
        $this->html2pdf->writeHTML($html);
    }

    public function renderToFile($filename)
    {
        $this->html2pdf->output($filename);
    }

    public function renderToOutput()
    {
        return $this->html2pdf->output();
    }
    
}

/* End of file Dompdf.php */