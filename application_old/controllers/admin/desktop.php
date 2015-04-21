<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desktop extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'admin';
        $this->isZone('app');
        $this->login_model->refresh();
        
        $this->load->model('groups_model');
        
        $this->addJs(array('admin_desktop.js',true));
    }
    
    public function index()
	{
		$this->setTitle('Accueil - '.$this->config->item('appname'));
        
        $dview['groups'] = $this->groups_model->getGroupsWithTodaysTotals();
        $this->display('desktop_start',$dview);
    }
    
    /*
     * Open the group with the children displayed
     */
    public function viewGroup($id)
    {
        $dview = array();
        
        // Detect view mode
        $viewmode = $this->input->get('viewmode');
        if(empty($viewmode))
            $viewmode = 4; // Show all kids
        $dview['viewmode'] = $viewmode;
        
        // Detect filter
        $filter = (int)$this->input->get('f');
        switch ($filter) {
            case '0':
                $this->session->set_userdata(array('desktop_filter' => 0));
                break;

            default:
                break;
        }
        
        $this->setTitle('Groupe - '.$this->config->item('appname')); 
        $this->load->model('children_model');

        $group = $this->groups_model->getGroup((int)$id);
        $dview['group'] = $group;
        
        $children_all = $this->groups_model->getGroupChildren((int)$id);
        $children_checkedin = $this->groups_model->getGroup_childrenCheckedin((int)$id);
        $children_checkedout = $this->groups_model->getGroup_childrenCheckedout((int)$id);
        $children_notices = $this->groups_model->getGroup_noticesTotals((int)$id);
        
        // Find the children that haven't checked in neither checked out
        $children_unchecked = $children_all;
        
        // Remove children with checkin from unchecked children
        foreach ($children_checkedin as $key => $value) 
            foreach($children_all as $key2 => $value2)
                if($value2->id_child == $value->id_child)
                {
                    unset($children_unchecked[$key2]);
                    break;
                }
        
        // Remove children with n+1 checkin for today from unchecked children
        // This avoids showing children with n+1 checkin in children as "checkedin"
        // also in "checkedout" as this view is the CURRENT status of the children
        foreach ($children_checkedin as $key => $value) 
            foreach($children_checkedout as $key2 => $value2)
                if($value2->id_child == $value->id_child)
                {
                    unset($children_checkedout[$key2]);
                    break;
                } 
                
        // Remove children with checkout from unchecked children
        foreach ($children_checkedin as $key => $value) 
            foreach($children_all as $key2 => $value2)
                if($value2->id_child == $value->id_child)
                {
                    unset($children_unchecked[$key2]);
                    break;
                }

        // Add events status to $children_all
        $children_all_events = array();
        foreach ($children_all as $key_c_all => $c_all)
        {
            // Set the "checkins"
            foreach ($children_checkedin as $c_in)
                if($c_all->id_child == $c_in->id_child )
                    $children_all_events[$c_all->id_child]['checkin_status_now'] = array('status' => 1, 'datetime_start' => $c_in->datetime_start);
            // Set the "checkouts"
            foreach ($children_checkedout as $c_out)
                if($c_all->id_child == $c_out->id_child )
                    $children_all_events[$c_all->id_child]['checkin_status_now'] = array('status' => 2, 'datetime_end' => $c_out->datetime_end);
        }

        $dview['children_notices'] = $children_notices;
        $dview['children_all_events'] = $children_all_events;
        $dview['children'] = $children_all;
        $dview['children_checkedin'] = $children_checkedin;
        $dview['children_checkedout'] = $children_checkedout;
        $dview['children_unchecked'] = $children_unchecked;
 
        $this->display('desktop_group_manage',$dview);
    }
    
}