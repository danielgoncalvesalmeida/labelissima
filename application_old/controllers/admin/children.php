<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Children extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
        
        $this->load->model('children_model');
      
        $this->addJs(array('admin_children.js',true));
        $this->load->library('Myconfig');
    }
    
    public function index()
	{
        // Check rights
        if(!_cr('children', 'v'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        // Handle pagination if provided
        $this->p = $this->input->get_post('p',true);
        $this->n = $this->input->get_post('n',true);
        
        (empty($this->p) ? $this->p = 1 : '' );
        (empty($this->n) ? $this->n = $this->config->item('results_per_page_default') : '' );
        $dview['p'] = $this->p;
        
		$this->setTitle('Enfants - '.$this->config->item('appname'));
        
        $dview['children'] = $this->children_model->getChildren($this->p, $this->n, 'firstname, lastname');
        $dview['children_count'] = $this->children_model->getChildrenCount();
        
		$this->display('children_list',$dview);
	}
    
    public function add()
    {
        // Check rights
        if(!_cr('children', 'e'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        $this->setTitle('Ajouter un enfant - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edlastname','nom','trim|required|xss_clean');
        $this->form_validation->set_rules('edfirstname','prénom','trim|required|xss_clean');
        $this->form_validation->set_rules('edsocialid','matricule sociale','trim|required|callback_checkvalidsocialid|xss_clean');
        $this->form_validation->set_rules('edgender','sexe','integer|required|xss_clean');
        $this->form_validation->set_rules('edbirthdate','date de naissance','required|callback_checkvaliddate|xss_clean');
        $this->form_validation->set_rules('edcitizenship','nationalité','trim|xss_clean');
        $this->form_validation->set_rules('edgroup','groupe','integer|required|callback_checkvalidgroup|xss_clean');
                
        if ($this->form_validation->run())
        {
            // Save data
            $data = array(
                'id_site' => 1, // Temporarly
                'id_group' => $this->input->post('edgroup'), 
                'id_domain' => $this->session->userdata('id_domain'),
                'firstname' => ucwords($this->input->post('edfirstname')), 
                'lastname' => ucwords($this->input->post('edlastname')), 
                'socialid' => $this->input->post('edsocialid'),
                'socialid_srch' => my_searchString($this->input->post('edsocialid')),
                'birthdate' => $this->input->post('edbirthdate'), 
                'gender' => $this->input->post('edgender'),
                'citizenship' => $this->input->post('edcitizenship'),
                'tag' => genTag(),
                'date_add' => date('Y-m-d H:i:s'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->insert('child',$data);
            $dview['id_child'] = $this->db->insert_id();
            $dview['flash_success'] = 'Nouveau enfant ajouté avec succès';
        }
        
        $this->load->model('groups_model');
        $dview['groups'] = $this->groups_model->getGroups();
		$this->display('children_add',$dview);
    }
    
    public function edit($id_child)
    {
        // Check rights
        if(!_cr('children', 'e'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $this->setTitle('Editer l\'enfant - '.$this->config->item('appname'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // Edit the child data
        if($this->input->post('submitAdd'))
        {
            $this->form_validation->set_rules('edlastname','nom','trim|required|xss_clean');
            $this->form_validation->set_rules('edfirstname','prénom','trim|required|xss_clean');
            $this->form_validation->set_rules('edsocialid','matricule sociale','trim|required|callback_checkvalidsocialid['.$id_child.']|xss_clean');
            $this->form_validation->set_rules('edgender','sexe','integer|required|xss_clean');
            $this->form_validation->set_rules('edbirthdate','date de naissance','required|callback_checkvaliddate|xss_clean');
            $this->form_validation->set_rules('edgroup','groupe','integer|required|callback_checkvalidgroup|xss_clean');
            $this->form_validation->set_rules('edparent1','parent 1','integer|xss_clean');
            $this->form_validation->set_rules('edparent2','parent 2','integer|xss_clean');
            $this->form_validation->set_rules('edcitizenship','nationalité','trim|xss_clean');

            // Info tab
            $this->form_validation->set_rules('edinstructions','Instructions','trim|xss_clean');
            $this->form_validation->set_rules('eddisease','Maladies et alergies','trim|xss_clean');
            $this->form_validation->set_rules('edprohibited_food','Prohibitions alimentaires','trim|xss_clean');
            $this->form_validation->set_rules('edreligious_notice','Notice religieuse et culte','trim|xss_clean');

            // Authorisations tab
            $this->form_validation->set_rules('edpicture_capture','Prise photo','integer|xss_clean');
            $this->form_validation->set_rules('edpicture_public','Publier photo','integer|xss_clean');
            $this->form_validation->set_rules('edparents_drugs_allowed','Médicaments des parents autorisé','integer|xss_clean');
            $this->form_validation->set_rules('eddrugs_list','Liste des médicaments des parents','trim|xss_clean');

            // Pickup persons tab
            $this->form_validation->set_rules('edemergency_persons','Personnes en cas d\'urgence','trim|xss_clean');

            if ($this->form_validation->run() && $this->security_model->isChildInDomain((int)$id_child))
            {
                $_parent1 = $this->input->post('edparent1');
                $_parent2 = $this->input->post('edparent2');
                // Save data
                $data = array(
                    'id_group' => $this->input->post('edgroup'), 
                    'firstname' => ucwords($this->input->post('edfirstname')), 
                    'lastname' => ucwords($this->input->post('edlastname')), 
                    'socialid' => $this->input->post('edsocialid'),
                    'socialid_srch' => my_searchString($this->input->post('edsocialid')),
                    'birthdate' => $this->input->post('edbirthdate'), 
                    'gender' => $this->input->post('edgender'),
                    'id_parent_1' => (!empty($_parent1) ? $_parent1 : 0),
                    'id_parent_2' => (!empty($_parent2) ? $_parent2 : 0),
                    'citizenship' => $this->input->post('edcitizenship'),
                    'instructions' => $this->input->post('edinstructions'),
                    'disease' => $this->input->post('eddisease'),
                    'prohibited_food' => $this->input->post('edprohibited_food'),
                    'religious_notice' => $this->input->post('edreligious_notice'),
                    'picture_capture' => ($this->input->post('edpicture_capture') == 1 ? 1 : 0),
                    'picture_public' => ($this->input->post('edpicture_public') == 1 ? 1 : 0),
                    'parents_drugs_allowed' => ($this->input->post('edparents_drugs_allowed') == 1 ? 1 : 0),
                    'drugs_list' => $this->input->post('eddrugs_list'),
                    'emergency_persons' => $this->input->post('edemergency_persons'),
                    'date_upd' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_child',$id_child);
                $this->db->update('child',$data);
                $dview['flash_success'] = 'Modifications enregistrées avec succès';

                // Check if there is a picture upload
                $field = 'edpictureprofile';
                if(isset($_FILES[$field]) && isset($_FILES[$field]['name']) && !empty($_FILES[$field]['name']))
                {
                    $this->load->model('uploads_model');
                    $result = $this->uploads_model->imgUpload('edpictureprofile',0,(int)$id_child);
                    if(empty($result['errors']))
                    {
                        $this->db->where('id_child',$id_child);
                        $this->db->update('child',array('profile_picture_tag' => $result['tag']));
                    }
                    else
                    {
                        $dview['flash_error'] = $result['errors'];
                    }
                }
            }
        } // End of child edit data
        
        // Add trustees
        if($this->input->post('submitAddTrustee'))
        {
            $this->form_validation->set_rules('edtrustname','nom','trim|required|xss_clean');
            $this->form_validation->set_rules('edmobilephone','téléphone portable','trim|xss_clean');
            $this->form_validation->set_rules('edphone','téléphone portable','trim|xss_clean');
            
            if ($this->form_validation->run() && $this->security_model->isChildInDomain((int)$id_child))
            {
                $mphone = $this->input->post('edmobilephone');
                $phone = $this->input->post('edphone');
                
                // Save data
                $data = array(
                    'id_child' => (int)$id_child, 
                    'id_domain' => (int)getUserDomain(),
                    'name' => ucwords($this->input->post('edtrustname')), 
                    'mobile_phone' => (!empty($mphone)? $mphone : NULL ), 
                    'phone' => (!empty($phone)? $phone : NULL ),
                    'tag' => genTag(),
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s')
                );
                $this->db->insert('child_trustee',$data);
                $id_trustee = $this->db->insert_id();
                $dview['flash_success'] = 'Une nouvelle personne autorisée fut ajoutée avec succès';
                
                $field = 'edtrustpicture';
                // Check if there is a picture upload
                if(isset($_FILES[$field]) && isset($_FILES[$field]['name']) && !empty($_FILES[$field]['name']))
                {
                    $this->load->model('uploads_model');
                    $result = $this->uploads_model->imgUpload('edtrustpicture',1,(int)$id_trustee);
                    if(empty($result['errors']))
                    {
                        $this->db->where('id_child_trustee',(int)$id_trustee);
                        $this->db->update('child_trustee',array('picture_tag' => $result['tag']));
                    }
                    else
                    {
                        $dview['flash_error'] = $result['errors'];
                    }
                }
            }
        }
        
        // Add documents
        if($this->input->post('submitAddDocument'))
        {
            $this->form_validation->set_rules('eddocname','nom','trim|required|xss_clean');
            $this->form_validation->set_rules('eddocdescription','description','trim|xss_clean');
            
            if ($this->form_validation->run() && $this->security_model->isChildInDomain((int)$id_child))
            {
                // Check if there is a file upload
                $this->load->model('uploads_model');
                $filename = $id_child.'_'.genTag($id_child);
                $result = $this->uploads_model->fileUpload('eddocfile', 0, (int)$id_child, $filename);
                
                if(empty($result['errors']))
                {
                    $tag = genTag($id_child);
                    // Save data
                    $data = array(
                        'id_child' => (int)$id_child, 
                        'id_domain' => (int)getUserDomain(),
                        'docname' => $this->input->post('eddocname'), 
                        'description' => $this->input->post('eddocdescription'), 
                        'mime' => $result['mime_type'],
                        'tag' => $tag,
                        'filename_local' => (isset($result['upload_data']['file_ext']) ? $filename.$result['upload_data']['file_ext'] : $filename),
                        'filename_download' => (isset($result['upload_data']['file_ext']) ? $tag.$result['upload_data']['file_ext'] : $tag ),
                        'date_add' => date('Y-m-d H:i:s'),
                        'date_upd' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('child_document',$data);
                    $id_child_document = $this->db->insert_id();
                    $dview['flash_success'] = 'Le document fut ajoutée avec succès';
                }
                else
                {
                    $dview['flash_error'] = $result['errors'];
                }
            }
        }
        
        $dview['child'] = $this->children_model->getChild((int)$id_child);
        $dview['hasprofilepicture'] = ($this->children_model->getProfilePicture((int)$id_child)? true : false);
        $dview['trustees'] = $this->children_model->getTrustees((int)$id_child);
        $dview['documents'] = $this->children_model->getDocuments((int)$id_child);
        $this->load->model('groups_model');
        $dview['groups'] = $this->groups_model->getGroups();
		$this->display('children_edit',$dview);
    }
    
    public function view($id)
    {
        // Check rights
        if(!_cr('children', 'v'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $dview['link_back'] = getLinkBack();
        $dview['child'] = $this->children_model->getChild((int)$id);
        $dview['parents'] = $this->children_model->getParents((int)$id);
        $dview['trustees'] = $this->children_model->getTrustees((int)$id);
        $dview['documents'] = $this->children_model->getDocuments((int)$id);

        $this->display('children_view',$dview);
    }
    
    
    
    public function delete($id)
    {
        // Check rights
        if(!_cr('children', 'd'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $this->children_model->delete((int)$id);
        redirect('admin/children');
    }
    
    /**
     * Edit a given trustee
     * @id = id_child_trustee
     */
    public function edittrustee($id)
    {
        // Check rights
        if(!_cr('children', 'e'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $this->setTitle('Editer la personne autorisée - '.$this->config->item('appname'));
        $this->load->helper('form');
        
        
        // Edit the trustee
        if($this->input->post('submitAdd'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id','id','required|xss_clean');
            $this->form_validation->set_rules('id_child','id_child','required|xss_clean');
            $this->form_validation->set_rules('edname','nom','trim|required|xss_clean');
            $this->form_validation->set_rules('edmobilephone','téléphone portable','trim|xss_clean');
            $this->form_validation->set_rules('edphone','téléphone portable','trim|xss_clean');
            
            $id = (int)$this->input->post('id');
            $id_child = (int)$this->input->post('id_child');
            if ($this->form_validation->run()
                    && $this->security_model->isTrusteeInDomain((int)$id) 
                    && $this->security_model->isChildInDomain((int)$id_child)
                )
            {
                $mphone = $this->input->post('edmobilephone');
                $phone = $this->input->post('edphone');
                
                // Save data
                $data = array(
                    'name' => ucwords($this->input->post('edname')), 
                    'mobile_phone' => (!empty($mphone)? $mphone : NULL ), 
                    'phone' => (!empty($phone)? $phone : NULL ),
                    'date_upd' => date('Y-m-d H:i:s'),
                );
                $this->db->where('id_child_trustee',(int)$this->input->post('id'));
                $this->db->where('id_child',(int)$this->input->post('id_child'));
                $this->db->where('id_domain',(int)getUserDomain());
                $this->db->update('child_trustee',$data);
                $dview['flash_success'] = 'Modifications enregistrées avec succès';
                
                $field = 'edpictureprofile';
                // Check if there is a picture upload
                if(isset($_FILES[$field]) && isset($_FILES[$field]['name']) && !empty($_FILES[$field]['name']))
                {
                    $this->load->model('uploads_model');
                    $result = $this->uploads_model->imgUpload('edpictureprofile',1,(int)$id);
                    if(empty($result['errors']))
                    {
                        $this->db->where('id_child_trustee',(int)$this->input->post('id'));
                        $this->db->where('id_child',(int)$this->input->post('id_child'));
                        $this->db->where('id_domain',(int)getUserDomain());
                        $this->db->update('child_trustee',array('picture_tag' => $result['tag']));
                    }
                    else
                    {
                        $dview['flash_error'] = $result['errors'];
                    }
                }
            }
        }
        
        $dview['trustee'] = $this->children_model->getTrustee((int)$id);
        $dview['hasprofilepicture'] = ($this->children_model->getTrusteeProfilePicture((int)$id)? true : false);
        $this->display('children_edittrustee',$dview);
    }
    
    /*
     * Delete a trustee
     */
    public function deletetrustee($id, $id_child = null)
    {
        // Check rights
        if(!_cr('children', 'e'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $this->children_model->deleteTrustee((int)$id);
        if (empty($id_child))
            redirect('admin/children/');
        else 
            redirect('admin/children/edit/'.(int)$id_child);
    }
    
    
    /**
     * Edit a given document
     * @id = id_child_document
     */
    public function editdocument($id)
    {
        // Check rights
        if(!_cr('children', 'e'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $this->setTitle('Editer le document - '.$this->config->item('appname'));
        $this->load->helper('form');
        
        
        // Edit the document
        if($this->input->post('submitAdd'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id','id','required|xss_clean');
            $this->form_validation->set_rules('id_child','id_child','required|xss_clean');
            $this->form_validation->set_rules('edname','libellé','trim|required|xss_clean');
            $this->form_validation->set_rules('eddescription','description du document','trim|xss_clean');
            
            $id = (int)$this->input->post('id');
            $id_child = (int)$this->input->post('id_child');
            if ($this->form_validation->run()
                    && $this->security_model->isDocumentInDomain((int)$id) 
                    && $this->security_model->isChildInDomain((int)$id_child)
                )
            {
                $description = $this->input->post('eddescription');
                
                // Save data
                $data = array(
                    'docname' => ucwords($this->input->post('edname')), 
                    'description' => (!empty($description)? $description : NULL ),
                    'date_upd' => date('Y-m-d H:i:s'),
                );
                $this->db->where('id_child_document',(int)$this->input->post('id'));
                $this->db->where('id_child',(int)$this->input->post('id_child'));
                $this->db->where('id_domain',(int)getUserDomain());
                $this->db->update('child_document',$data);
                $dview['flash_success'] = 'Modifications enregistrées avec succès';
                
                $field = 'edpictureprofile';
                // Check if there is a picture upload
                if(isset($_FILES[$field]) && isset($_FILES[$field]['name']) && !empty($_FILES[$field]['name']))
                {
                    $this->load->model('uploads_model');
                    $result = $this->uploads_model->imgUpload('edpictureprofile',1,(int)$id);
                    if(empty($result['errors']))
                    {
                        $this->db->where('id_child_trustee',(int)$this->input->post('id'));
                        $this->db->where('id_child',(int)$this->input->post('id_child'));
                        $this->db->where('id_domain',(int)getUserDomain());
                        $this->db->update('child_trustee',array('picture_tag' => $result['tag']));
                    }
                    else
                    {
                        $dview['flash_error'] = $result['errors'];
                    }
                }
            }
        }
        
        $dview['document'] = $this->children_model->getDocument((int)$id);
        $dview['hasprofilepicture'] = ($this->children_model->getTrusteeProfilePicture((int)$id)? true : false);
        
        $this->display('children_editdocument',$dview);
    }
    
    /*
     * Delete a child document
     */
    public function deletedocument($id, $id_child = null)
    {
        // Check rights
        if(!_cr('children', 'd'))
        {
            $this->display('warning-noaccess');
            return false;
        }
        
        $this->children_model->deleteChildDocument((int)$id);
        if (empty($id_child))
            redirect('admin/children/');
        else 
            redirect('admin/children/edit/'.(int)$id_child);
    }
    
    /*
     *  Multipurpose AJAX call : Purpose is based on type
     */
    public function ajax()
    {
        if(!$this->input->is_ajax_request())
            die();
        
        $type = $this->input->get_post('type',true);
        
        /*
         *  Check if the provided socialid exists
         */
        if($type == 1)
        {
            $name = $this->input->get_post('value',true);
            $id_exclude = $this->input->get_post('exclude',true);
            $id_exclude = (!empty($id_exclude)? $id_exclude : null);
            if($this->children_model->socialidExists($name, $id_exclude))
                echo json_encode (true);
            else
                echo json_encode (false);
        }
        
        /*
         * Check if the provided birthdate is correct
         * Returns true if correct date
         */
        if($type == 2)
        {
            $birthdate = $this->input->get_post('value',true);
            $_tmp = explode('-', $birthdate);
            // Not a valid date
            if(count($_tmp) != 3){
                echo json_encode (false);
                return false;
            }
            
            if(checkdate($_tmp[1], $_tmp[2], $_tmp[0]))
                echo json_encode (true);
            else
                echo json_encode (false);
        }
        
        /*
         * Delete the profile picture of the child
         */
        if($type == 3)
        {
            $id = $this->input->get_post('value',true);
            $imgDir = $this->config->item('imgdir_children_secure');
            $fnames = array('_large.jpg', '_medium.jpg', '_mini.jpg', '_original.jpg');
            if($this->security_model->isChildInDomain((int)$id))
            {
                foreach ($fnames as $f)
                    @unlink($imgDir.$id.$f);
                echo json_encode (true);
            }
            
        }
        
        /*
         * Delete the profile picture of the child trustee
         */
        if($type == 4)
        {
            $id = $this->input->get_post('value',true);
            $imgDir = $this->config->item('imgdir_trustees_secure');
            $fnames = array('_large.jpg', '_medium.jpg', '_mini.jpg', '_original.jpg');
            if($this->security_model->isTrusteeInDomain((int)$id))
            {
                foreach ($fnames as $f)
                    @unlink($imgDir.$id.$f);
                echo json_encode (true);
            }
            
        }
    }
    
    
    public function viewjournal($id, $date = null)
    {
        $this->addCss('timeline.css');
        if($this->input->get('backgroup'))
        {
            $id_group = $this->input->get('backgroup');
            $dview['link_back'] = 'admin/desktop/viewgroup/'.(int)$id_group;
        }
            
        if(!$date)
            $date = new Datetime(date('Y-m-d'));
        else 
            $date = new Datetime($date);
        
        $dview['link_back'] = getLinkBack();
        
        $this->load->model('calendar_model');
        $dview['nav'] = $this->calendar_model->getWeekDaysBasedNavigation(date_format($date, 'Y-m-d'),5);
        
        $child = $this->children_model->getChild((int)$id);
        
        $this->setTitle('Journal de '.$child->firstname.' '.$child->lastname);
        
        $dview['child'] = $child;
        $dview['hasprofilepicture'] = ($this->children_model->getProfilePicture((int)$id)? true : false);
        
        //$date = new Datetime(date('Y-m-d H:i:s'));
        $journal = $this->children_model->getChildJournal($id, $date);
        $dview['date_journal'] = $date;
        $dview['journal'] = $journal;

        $this->display('children_viewjournal',$dview);
    }
    
    /*
     * Page for checkin
     * $id => id_child
     */
    public function checkin($id)
    {
        $this->addJs(array('admin_checkin.js',true));
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // Handle save event
        if($this->input->post('save'))
        {
            $errors = array();
            
            if($this->input->get_post('usenow'))
                $datetime = date('Y-m-d H:i');
            else
            {
                $hour = (int)$this->input->get_post('hour');
                $minute = (int)$this->input->get_post('minute');
                if(!($hour >= 0 && $hour < 24 && $minute >= 0 && $minute <= 59))
                    $erros[] = "L'indication horaire n'est pas valide";
                else
                    $datetime = date('Y-m-d ').$hour.':'.$minute;
            }
            
            $id_child = $this->input->get_post('id', true);
            $this->load->model('security_model');
            if(!$this->security_model->isChildInDomain((int)$id_child))
                $erros[] = "L'enfant n'est pas valide";
            
            // Get the pickup (parents/trustees)
            $pickup_param = false;
            $pickup = $this->input->get_post('pickup');
           
            if(!empty($pickup))
            {
                $ap = explode('_', $pickup);
                if(isset($ap[0]) && $ap[0] == 'p' && isset($ap[1]) && !empty($ap[1]))
                    $pickup_param = array('p' => $ap[1]);
                if(isset($ap[0]) && $ap[0] == 't' && isset($ap[1]) && !empty($ap[1]))
                    $pickup_param = array('t' => $ap[1]);   
            }

            // Avoid empty string for datetime
            if(empty($datetime))
                $erros[] = "L'indication horaire n'est pas valide";

            if(count($errors) == 0)
            {
                // Check for valid datetime
                try {
                    $t_check = new DateTime($datetime);
                } catch (Exception $e){
                    $erros[] = "L'indication horaire n'est pas valide";
                }
                
                $result = $this->children_model->setCheckin((int)$id_child, $datetime, $pickup_param);

                if(isset($result['checkin_overlap']))
                    $errors[] = "L'heure indiquée est en conflit avec un autre temps de présence du jour !";
                elseif(isset($result['event']))
                    $errors[] = "Opération non éxecutée. Cet enfant est actuellement déjà entré !";
                elseif($result)
                    $dview['success'] = true;
                else
                    $dview['success'] = false;
                if(count($errors) > 0)
                    $dview['errors'] = $errors;
            }
            else
                $dview['errors'] = $errors;
        }   
            
            
        
        $dview['child'] = $this->children_model->getChild((int)$id);
        $dview['parents'] = $this->children_model->getParents((int)$id);
        $dview['trustees'] = $this->children_model->getTrustees((int)$id);
        $dview['documents'] = $this->children_model->getDocuments((int)$id);
     //ddd($dview);
        $this->display('children_checkin',$dview);
    }
    
    /*
     * Page for checkout
     * $id => id_child
     */
    public function checkout($id)
    {
        $this->addJs(array('admin_checkin.js',true));
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // Handle save event
        if($this->input->post('save'))
        {
            $errors = array();
            
            if($this->input->get_post('usenow'))
                $datetime = date('Y-m-d H:i');
            else
            {
                $hour = (int)$this->input->get_post('hour');
                $minute = (int)$this->input->get_post('minute');
                if(!($hour >= 0 && $hour < 24 && $minute >= 0 && $minute <= 59))
                    $erros[] = "L'indication horaire n'est pas valide";
                else
                    $datetime = date('Y-m-d ').$hour.':'.$minute;
            }
            
            $id_child = $this->input->get_post('id', true);
            $this->load->model('security_model');
            if(!$this->security_model->isChildInDomain((int)$id_child))
                $erros[] = "L'enfant n'est pas valide";
            
            // Get the pickup (parents/trustees)
            $pickup_param = false;
            $pickup = $this->input->get_post('pickup');
           
            if(!empty($pickup))
            {
                $ap = explode('_', $pickup);
                if(isset($ap[0]) && $ap[0] == 'p' && isset($ap[1]) && !empty($ap[1]))
                    $pickup_param = array('p' => $ap[1]);
                if(isset($ap[0]) && $ap[0] == 't' && isset($ap[1]) && !empty($ap[1]))
                    $pickup_param = array('t' => $ap[1]);   
            }

            // Avoid empty string for datetime
            if(empty($datetime))
                $erros[] = "L'indication horaire n'est pas valide";

            if(count($errors) == 0)
            {
                // Check for valid datetime
                try {
                    $t_check = new DateTime($datetime);
                } catch (Exception $e){
                    $erros[] = "L'indication horaire n'est pas valide";
                }
                
                $result = $this->children_model->setCheckout((int)$id_child, $datetime, $pickup_param);

                if(isset($result['checkin_overlap']))
                    $errors[] = "L'heure indiquée est en conflit avec un autre temps de présence du jour !";
                elseif(isset($result['event']))
                    $errors[] = "Opération non éxecutée. Cet enfant est actuellement déjà entré !";
                elseif($result)
                    $dview['success'] = true;
                else
                    $dview['success'] = false;
                if(count($errors) > 0)
                    $dview['errors'] = $errors;
            }
            else
                $dview['errors'] = $errors;
        }   
            
            
        
        $dview['child'] = $this->children_model->getChild((int)$id);
        $dview['parents'] = $this->children_model->getParents((int)$id);
        $dview['trustees'] = $this->children_model->getTrustees((int)$id);
        $dview['documents'] = $this->children_model->getDocuments((int)$id);
     //ddd($dview);
        $this->display('children_checkout',$dview);
    }
    
    /*
     * Event dialog
     * $id => id_child
     */
    public function addevent($id)
    {
        $this->addJs(array('admin_addevent.js',true));
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $errors = array();
        
        // Intercept domain violations
        $this->load->model('security_model');
        if(!$this->security_model->isChildInDomain((int)$id))
            $erros[] = "L'enfant n'est pas valide";

        // Handle save event
        if($this->input->post('save') && count($errors) == 0)
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id','id','required|xss_clean');
            $this->form_validation->set_rules('id_child_event_type','id_child_event_type','integer');
            $this->form_validation->set_rules('memo','memo','trim|xss_clean');
            $this->form_validation->set_rules('id_smiley','smiley','integer');

            if ($this->form_validation->run())
            {
                $this->load->model('children_model');
                $id_child_event_type = (int)$this->input->post('id_child_event_type');
                $id_smiley = (int)$this->input->post('id_smiley');
                
                // Save data
                $data = array(
                    'id_domain' => getUserDomain(), 
                    'id_group' => $this->children_model->getChildGroup((int)$id),
                    'id_child' => (int)$id,
                    'id_user_start' => getUserId(),
                    'id_type' => (!empty($id_child_event_type)? $id_child_event_type : 0 ),
                    'memo' => $this->input->post('memo'),
                    'id_smiley' => (!empty($id_smiley)? $id_smiley : 0 ),
                    'datetime_start' => date('Y-m-d H:i:s'),
                    'tag' => md5(getUserId().date('Y-m-d H:i:s').getUserDomain().$id.$id_child_event_type),
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s'),
                );
                
                $this->db->insert('child_event', $data);
                $dview['success'] = true;
            }
            
            
        }
        
        if(count($errors) > 0)
            $dview['errors'] = $errors;
        $dview['child'] = $this->children_model->getChild((int)$id);
        $dview['event_types'] = $this->children_model->getEventTypes($exclude = array(1,2,6));
        $dview['emoticons'] = $this->children_model->getEventEmoticons();
        
        //ddd($dview);
        $this->display('children_addevent',$dview);
    }
    
    /*
     * Load the modal box for check in and out
     */
    public function ajaxcheckinout()
    { 
        if(!$this->input->is_ajax_request())
            die();
        
        // Identify operation
        $type = $this->input->get_post('type',true);
        
        $this->load->helper('form');
  
        // Load checkin form
        if($type == 1)
        {
            $id_child = $type = $this->input->get_post('id',true);
            
            // Is it a checkin
            $requestIsCheckin = $this->input->get_post('checkin',true);
            // Is it a checkin
            $requestIsCheckout = $this->input->get_post('checkout',true);
            
            // Check the current checkin status of child
            $status = $this->children_model->getCheckinStatus_verbose((int)$id_child);
            
            $error = false;
            // This child is performing a "check in"
            if ($status['status'] == 1 && $requestIsCheckin)
                $error = 1;
            $dview['error'] = $error;
    
            // Consider only if the child has checkedin and discard any other status
            $dview['isCheckedin'] = ((int)$status['status'] == 1 ? true : false);
            // Contains the current uncompleted checkin
            $dview['current_checkin'] = $status['event'];
            // Contains any previously completed checkin during the day
            $dview['checkins'] = $this->children_model->getCheckinsCompleted((int)$id_child);
            // Information about the child
            $dview['child'] = $this->children_model->getChild($id_child);
            echo $this->load->view('admin/children_modal_checkinout', $dview, true);
        }
        
        // Save checkin
        if($type == 2)
        {    
            if($this->input->get_post('usenow'))
                $datetime = date('Y-m-d H:i');
            else
                $datetime = $this->input->get_post('edcheckindatetime', true);
            $id_child = $this->input->get_post('id', true);

            // Avoid empty string for datetime
            if(empty($datetime))
            {
                echo json_encode(array('error' => '0'));
                die();
            }
             
            // Check for valid datetime
            try {
                $t_check = new DateTime($datetime);
            } catch (Exception $e){
                echo json_encode(array('error' => '0'));
                die();
            }
            
            $result = $this->children_model->setCheckin($id_child, $datetime);
            
            if(isset($result['checkin_overlap']))
                echo json_encode(array('error' => '101'));
            elseif(isset($result['event']))
                echo json_encode(array('error' => '100', 'event' => $result['event']));
            elseif($result)
                echo json_encode(true);
            else
                echo json_encode(false);
        }
        
        // Save checkout
        if($type == 3)
        {
            if($this->input->get_post('usenow'))
                $datetime = date('Y-m-d H:i');
            else
                $datetime = $this->input->get_post('edcheckoutdatetime', true);
            $id_child = $this->input->get_post('id', true);
            // Avoid empty string for datetime
            if(empty($datetime))
            {
                echo json_encode(array('error' => '0'));
                die();
            }
             
            // Check for valid datetime
            try {
                $t_check = new DateTime($datetime);
            } catch (Exception $e){
                echo json_encode(array('error' => '0'));
                die();
            }
            $result = $this->children_model->setCheckout($id_child, $datetime, 2);
            if(isset($result['checkout_overlap']))
                echo json_encode(array('error' => '101'));
            elseif(isset($result['error']))
                echo json_encode(array('error' => $result['error']));
            else
                echo json_encode(true);
        }
    }
    
    
    /*
     * Load the modal box for add event
     */
    public function ajaxevent()
    { 
        if(!$this->input->is_ajax_request())
            die();
        
        // Identify operation
        $type = $this->input->get_post('type',true);
        
        $this->load->helper('form');
  
        // Load checkin form
        if($type == 1)
        {
            $id_child = $type = $this->input->get_post('id',true);
            $dview['child'] = $this->children_model->getChild($id_child);
            $dview['event_types'] = $this->children_model->getEventTypes($exclude = array(1,2,6));
            $dview['emoticons'] = $this->children_model->getEventEmoticons();
            echo $this->load->view('admin/children_modal_addevent', $dview, true);
            die();
        }
        
        // Save the event
        if($type == 2)
        {
            $id_child = $this->input->get_post('id',true);
         
            if(!$this->security_model->isChildInDomain((int)$id_child))
            {
                echo json_encode(FALSE);
                die();
            }
            
            $description = $this->input->get_post('description',true);
            $id_type = $this->input->get_post('id_type',true);
            $id_smiley = $this->input->get_post('id_smiley',true);
            
            if(!is_numeric($id_type)) $id_type = 6;
            
            if(!is_numeric($id_smiley)) $id_smiley = 0;
            
            $id_group_of_child = $this->children_model->getChildGroup((int)$id_child);
            
            // Save data
            $data = array(
                'id_child' => $id_child, 
                'id_domain' => getUserDomain(),
                'id_group' => (int)$id_group_of_child,
                'id_type' => $id_type, 
                'id_smiley' => $id_smiley,
                'id_user_start' => getUserId(),
                'datetime_start' => date('Y-m-d H:i:s'),
                'memo' => trim($description),
                'tag' => genTag(),
                'date_add' => date('Y-m-d H:i:s'),
                'date_upd' => date('Y-m-d H:i:s')
            );
            $this->db->insert('child_event',$data);
            echo json_encode(true);
            die();
        }
    }
    
    /*
     *  Load the form for parent selection
     */
    public function ajaxselectparent()
    { 
        if(!$this->input->is_ajax_request())
            die();
        
        $position = $this->input->get_post('position',true);
        
        $id_domain = $this->session->userdata('id_domain');
        $this->load->model('parents_model');
        $parents = $this->parents_model->getParents();
        $dview['position'] = (empty($position) ? 1 : $position);
        $dview['parents'] = $parents;
        echo $this->load->view('admin/children_modal_selectparent', $dview, true);
        die();
        
    }
    
    
    
    /*
     *  Form validation callback
     */
    public function checkvaliddate($str)
    {
        $_tmp = explode('-', $str);
        // Not a valid date
        if(count($_tmp) != 3 || empty($_tmp[2]))
        {
            $this->form_validation->set_message('checkvaliddate', 'Date non valide');
            return false;
        }

        if(checkdate($_tmp[1], $_tmp[2], $_tmp[0]))
            return true;
        else {
            $this->form_validation->set_message('checkvaliddate', 'Date non valide');
            return false;
        }       
    }
    
    /*
     *  Form validation callback
     */
    public function checkvalidsocialid($str, $exclude = null)
    {
        if($this->children_model->socialidExists($str, $exclude))
        {
            $this->form_validation->set_message('checkvalidsocialid','Le numéro social est déjà attribué ! Veuillez indiquer un autre.');
            return false;
        }
        else
            return true;
    }
    
    
    /*
     *  Form validation callback - Check if the group belongs to the correct domain
     */
    public function checkvalidgroup($id_group)
    {
        $this->load->model('groups_model');
        if($this->groups_model->checkGroupIsValid((int)$id_group))
            return true;
        else {
            $this->form_validation->set_message('checkvalidgroup', 'Group non valid');
            return false;
        }       
    }
    
}