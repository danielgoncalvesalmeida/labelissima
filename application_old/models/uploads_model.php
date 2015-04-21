<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploads_model extends My_Model {

	function __construct()
	{
		parent::__construct();
	}
    
    
    /*
     * Handle file uploads (images) like children pictures etc
     * $formfield = name of the file input in the form
     */
    public function imgUpload($formfield, $purpose = 0, $id = null, $name = null, $width = 161, $height = 161, $ratio = true)
	{
		$result['errors']	= null;
        $result['tag'] = null;
        
        // Init config
        $config = array(); 
     
        /*
        * Picture for children
        */
        if($purpose == 0)
        {
            $config['allowed_types'] = 'jpg|jpeg'; 
            $imgDir = $this->config->item('imgdir_children_secure');
            $config['upload_path'] = $imgDir;   
            $max_pict_size = $this->config->item('picture_children_max_size');
            $config['max_size'] = (!empty($max_pict_size) ? $max_pict_size : 0);
            $config['encrypt_name'] = true;
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
        }
        
        /*
        * Picture for trustees
        */
        if($purpose == 1)
        {
            $config['allowed_types'] = 'jpg|jpeg|png|pdf'; 
            $imgDir = $this->config->item('imgdir_trustees_secure');
            $config['upload_path'] = $imgDir;   
            $max_pict_size = $this->config->item('picture_trustees_max_size');
            $config['max_size'] = (!empty($max_pict_size) ? $max_pict_size : 0);
            $config['encrypt_name'] = true;
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
        }
        
        // The name is it specified?
        if(!empty($name)){
            $config['file_name'] = $name; 
            $config['overwrite'] = true; 
        }

		$this->load->library('upload', $config);
        // $formfield = The name of the file input in the form
		if($this->upload->do_upload($formfield))
		{
			$upload_data = $this->upload->data();
            $result['upload_data'] = $upload_data;
            /*
             * Picture for children
             */
            if($purpose == 0)
            {
                // Resize the original picture
                $id = (!empty($id) ? (int)$id : 'no_id');
                $uploadfullpath = $upload_data['full_path'];
                $imgname = $id.'_original.jpg';
                $this->load->library('image_lib');
    			$config['image_library'] = 'gd2';
    			$config['source_image'] = $uploadfullpath;
    			$config['new_image']	= $imgDir.$imgname;
    			$config['maintain_ratio'] = $ratio;
    			$config['width'] = 1200;
    			$config['height'] = 1200;
     			$this->image_lib->initialize($config);
    			$this->image_lib->resize();
    			$this->image_lib->clear();
                
                /*
                 *  Get the size of the resized original and create a crop
                 */
                $config['source_image'] = $imgDir.$imgname;
                $config['new_image']	= $imgDir.$id.'_large.jpg';
                $this->image_lib->initialize($config);
                // Calculate the crop frame
                $x_axis = 0;
                $y_axis = 0;                
                if ($this->image_lib->orig_width >= $this->image_lib->orig_height){
                    $x_axis = round(($this->image_lib->orig_width - $this->image_lib->orig_height) / 2); 
                    $config['width'] = $this->image_lib->orig_height;
                    $config['height'] = $this->image_lib->orig_height;
                } else {
                    $y_axis = round(($this->image_lib->orig_height - $this->image_lib->orig_width) / 2);
                    $config['width'] = $this->image_lib->orig_width;
                    $config['height'] = $this->image_lib->orig_width;
                }
                // Crop the original image
                $config['maintain_ratio'] = false;
                $config['x_axis'] = $x_axis;
                $config['y_axis'] = $y_axis;
                $this->image_lib->initialize($config);
    			$this->image_lib->crop();
                $this->image_lib->clear();
                
    			/*
                 * Create the medium size image (from large cropped one)
                 */
    			$config['image_library'] = 'gd2';
    			$config['source_image'] = $imgDir.$id.'_large.jpg';
    			$config['new_image']	= $imgDir.$id.'_medium.jpg';
    			$config['maintain_ratio'] = $ratio;
    			$config['width'] = 400;
    			$config['height'] = 400;
    			$this->image_lib->initialize($config); 
    			$this->image_lib->resize();
    			$this->image_lib->clear();

    			//
                // Create the thumbnail (from cropped one)
                //
    			$config['image_library'] = 'gd2';
    			$config['source_image'] = $imgDir.$id.'_medium.jpg';
    			$config['new_image']	= $imgDir.$id.'_mini.jpg';
    			$config['maintain_ratio'] = $ratio;
    			$config['width'] = 140;
    			$config['height'] = 140;
    			$this->image_lib->initialize($config); 	
    			$this->image_lib->resize();	
    			$this->image_lib->clear();
                
                // Delete the uploaded file
                @unlink($uploadfullpath);
                // Delete the intermediary "original" file
                @unlink($imgDir.$id.'_original.jpg');
                // Return a specific tag for filename
                $result['tag'] = genTag($id.$imgname);
                                
            }
            
            
            /*
             * Picture for trustees
             */
            if($purpose == 1)
            {
                // Resize the original picture
                $id = (!empty($id) ? (int)$id : 'no_id');
                $uploadfullpath = $upload_data['full_path'];
                $imgname = $id.'_original.jpg';
                $this->load->library('image_lib');
    			$config['image_library'] = 'gd2';
    			$config['source_image'] = $uploadfullpath;
    			$config['new_image']	= $imgDir.$imgname;
    			$config['maintain_ratio'] = $ratio;
    			$config['width'] = 1200;
    			$config['height'] = 1200;
     			$this->image_lib->initialize($config);
    			$this->image_lib->resize();
    			$this->image_lib->clear();
                
                /*
                 *  Get the size of the resized original and create a crop
                 */
                $config['source_image'] = $imgDir.$imgname;
                $config['new_image']	= $imgDir.$id.'_large.jpg';
                $this->image_lib->initialize($config);
                // Calculate the crop frame
                $x_axis = 0;
                $y_axis = 0;                
                if ($this->image_lib->orig_width >= $this->image_lib->orig_height){
                    $x_axis = round(($this->image_lib->orig_width - $this->image_lib->orig_height) / 2); 
                    $config['width'] = $this->image_lib->orig_height;
                    $config['height'] = $this->image_lib->orig_height;
                } else {
                    $y_axis = round(($this->image_lib->orig_height - $this->image_lib->orig_width) / 2);
                    $config['width'] = $this->image_lib->orig_width;
                    $config['height'] = $this->image_lib->orig_width;
                }
                // Crop the original image
                $config['maintain_ratio'] = false;
                $config['x_axis'] = $x_axis;
                $config['y_axis'] = $y_axis;
                $this->image_lib->initialize($config);
    			$this->image_lib->crop();
                $this->image_lib->clear();
                
    			/*
                 * Create the medium size image (from large cropped one)
                 */
    			$config['image_library'] = 'gd2';
    			$config['source_image'] = $imgDir.$id.'_large.jpg';
    			$config['new_image']	= $imgDir.$id.'_medium.jpg';
    			$config['maintain_ratio'] = $ratio;
    			$config['width'] = 400;
    			$config['height'] = 400;
    			$this->image_lib->initialize($config); 
    			$this->image_lib->resize();
    			$this->image_lib->clear();

    			//
                // Create the thumbnail (from cropped one)
                //
    			$config['image_library'] = 'gd2';
    			$config['source_image'] = $imgDir.$id.'_medium.jpg';
    			$config['new_image']	= $imgDir.$id.'_mini.jpg';
    			$config['maintain_ratio'] = $ratio;
    			$config['width'] = 140;
    			$config['height'] = 140;
    			$this->image_lib->initialize($config); 	
    			$this->image_lib->resize();	
    			$this->image_lib->clear();
                
                // Delete the uploaded file
                @unlink($uploadfullpath);
                // Delete the intermediary "original" file
                @unlink($imgDir.$id.'_original.jpg');
                // Return a specific tag for filename
                $result['tag'] = genTag($id.$imgname);
                                
            }
            
            $result['uploaded_file'] = $uploadfullpath;
		}
        $result['errors'] = $this->upload->display_errors();
        
        return $result;
	}
    
    
    /*
     * Handle file uploads (images or other files) like children documents etc
     * $formfield = name of the file input in the form
     */
    public function fileUpload($formfield, $purpose = 0, $id = null, $name = null)
	{
       
        $result['errors'] = null;
        $result['tag'] = null;
        
        // Init config
        $config = array(); 
     
        /*
        * Document for child
        */
        if($purpose == 0)
        {
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx'; 
            $uploaddir = $this->config->item('docsdir_childdocuments_secure');
            $config['upload_path'] = $uploaddir;   
            $max_upload_size = $this->config->item('childdocuments_max_size');
            $config['max_size'] = (!empty($max_upload_size) ? $max_upload_size : 0);
            $config['encrypt_name'] = false;
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
        }
        
        // Assign specific name if provided
        if($name)
            $config['file_name'] = $name;
        
        $this->load->library('upload', $config);
        
        // $formfield = The name of the file input in the form
		if($this->upload->do_upload($formfield))
		{
			$upload_data = $this->upload->data();
            $result['upload_data'] = $upload_data;
            if($upload_data['file_ext'] == '.pdf')
                $result['mime_type'] = 'application/pdf';
            else
                $result['mime_type'] = $upload_data['file_type'];
        }
        else
            $result['errors'] = $this->upload->display_errors();
        
        return $result;
    }
    
    
}

/* End of file groups_model.php */