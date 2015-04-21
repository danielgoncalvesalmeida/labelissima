<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Dinokid - 2014
 * 
 * Looks for restricted access images to return them to browser
 * 
 */

class Viewfile extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
    }
    
    public function index($id)
	{
        $this->document($id);
	}
    
    /*
     * Check if the user has access to the child and return the document if it
     * exists.
     */
    public function document($id)
	{
        $this->load->model('children_model');
        $doc = $this->children_model->getChildDocument((int)$id);
 
        // File doesn't exist anymore on disk or the document is not in the user domain
        if(!$doc)
            return false;
        $docsDir = $this->config->item('docsdir_childdocuments_secure');

        if(file_exists($docsDir.$doc->filename_local))
        {
            $this->load->helper('download');
            $data = file_get_contents($docsDir.$doc->filename_local);
            force_download($doc->filename_download, $data);
          
           
            /*
            header('Pragma: public');  // required
            header('Expires: 0');  // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Cache-Control: private', false);
            header('Content-Type: application/pdf');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($docsDir.$doc->filename_local)) . ' GMT');
            header('Content-disposition: attachment; filename=' . $doc->filename_local);
            header("Content-Transfer-Encoding:  binary");
            header('Content-Length: ' . filesize($docsDir.$doc->filename_local)); // provide file size
            header('Connection: close');
             * /
            
            
            header('Content-Transfer-Encoding: binary');
            header('Content-Type: '.$doc->mime);
            header('Content-Length: '.filesize($docsDir.$doc->filename_local));
            header('Content-Disposition: attachment; filename="'.utf8_decode($doc->filename_download).'"');
            readfile('C:\0-Sites\Dinokid\dinokiddev\uploads\child_docs/'.$doc->filename_local);
            exit;
             * 
             */
            
        }
	}
    
    /*
     * Check if the user has access to the child and return the document as image if it
     * exists.
     */
    public function document_img($id)
	{
        $this->load->model('children_model');
        $doc = $this->children_model->getChildDocument((int)$id);

        // File doesn't exist anymore on disk or the document is not in the user domain
        if(!$doc)
            return false;
        $docsDir = $this->config->item('docsdir_childdocuments_secure');

        if(file_exists($docsDir.$doc->filename_local))
        {
            $fp = fopen($docsDir.$doc->filename_local, 'rb');
            header("Content-Type: image/jpg");
            header("Content-Length: " . filesize($docsDir.$doc->filename_local));
            fpassthru($fp);
        }
	}
    
    
    
}