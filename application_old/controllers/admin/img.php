<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Dinokid - 2014
 * 
 * Looks for restricted access images to return them to browser
 * 
 */

class Img extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
    }
    
    public function index()
	{
        $this->child();
	}
    
    /*
     * Check if the user has access to this child and load child picture if
     * one available. If no picture available load the generic based on the 
     * child gender
     */
    public function child_mini($id)
	{
        $_use_jpeg = true;
        //$id = (int)$this->input->get('id',true);

        $name = $id . '_mini.jpg';
        $imgDir = $this->config->item('imgdir_children_secure');

        if(file_exists($imgDir.$name) && $this->security_model->isChildInDomain((int)$id))
        {
            $fp = fopen($imgDir.$name, 'rb');
        }
        else
        {
            $_use_jpeg = false;
            $imgDir = $this->config->item('imgdir_children_secure');
            $this->load->model('children_model');
            if($this->children_model->getGender((int)$id) == 1)
                $name = 'kid_picture_boy_black.png';
            else
                $name = 'kid_picture_girl_black.png';
            $fp = fopen($imgDir.$name, 'rb');
        }
        
        if($_use_jpeg)
            header("Content-Type: image/jpg");
        else
            header("Content-Type: image/png");
        header("Content-Length: " . filesize($imgDir.$name));

        fpassthru($fp);
	}
    
    /*
     * Check if the user has access to this trustee and load trustee picture if
     * one available.
     */
    public function trustee($id)
	{
        $_use_jpeg = true;
        //$id = (int)$this->input->get('id',true);

        $name = $id . '_mini.jpg';
        $imgDir = $this->config->item('imgdir_trustees_secure');

        if(file_exists($imgDir.$name) && $this->security_model->isTrusteeInDomain((int)$id))
        {
            $fp = fopen($imgDir.$name, 'rb');
            $fp;
        }
        else
        {
            $_use_jpeg = false;
            $imgDir = $this->config->item('assets_img_path');
            $name = 'person_black.png';
            $fp = fopen($imgDir.$name, 'rb');
        }
        
        if($_use_jpeg)
            header("Content-Type: image/jpg");
        else
            header("Content-Type: image/png");
        header("Content-Length: " . filesize($imgDir.$name));

        fpassthru($fp);
	}
    
}