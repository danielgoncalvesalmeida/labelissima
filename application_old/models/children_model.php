<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Children_model extends My_Model {

	function __construct()
	{
		parent::__construct();
        $this->table = 'child';
        $this->primaryKey = 'id_child';
	}
    
    /*
     * Get a given child that is not deleted
     * includes domain_name, site_name
     */
    public function getChild($id)
    {
        $sql = "SELECT c.*, s.name AS site_name, d.name AS domain_name,
                p1.id_parent as p1_id_parent, p1.firstname as p1_firstname, p1.lastname as p1_lastname,
                p2.id_parent as p2_id_parent, p2.firstname as p2_firstname, p2.lastname as p2_lastname
            FROM ".$this->db->dbprefix('child')." c
            LEFT JOIN ".$this->db->dbprefix('site')." s ON c.`id_site` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON s.`id_domain` = d.`id_domain`
            LEFT JOIN ".$this->db->dbprefix('parent')." p1 ON c.`id_parent_1` = p1.`id_parent`
            LEFT JOIN ".$this->db->dbprefix('parent')." p2 ON c.`id_parent_2` = p2.`id_parent`
            WHERE c.`deleted` = 0 
            AND c.`id_child` = ?
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }
    
    /*
     * Get all children that are not deleted
     * includes domain_name, site_name
     */
    public function getChildren($p = null, $n = null, $orderby = null)
    {
        $p = (is_numeric($p) ? $p - 1 : null);
        
        $sql = "SELECT c.*, s.name AS site_name, d.name AS domain_name, cg.name as group_name,
                p1.id_parent as p1_id_parent, p1.firstname as p1_firstname, p1.lastname as p1_lastname,
                p2.id_parent as p2_id_parent, p2.firstname as p2_firstname, p2.lastname as p2_lastname
            FROM ".$this->db->dbprefix('child')." c
            LEFT JOIN ".$this->db->dbprefix('site')." s ON c.`id_site` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('child_group')." cg ON c.`id_group` = cg.`id_child_group`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON s.`id_domain` = d.`id_domain`
            LEFT JOIN ".$this->db->dbprefix('parent')." p1 ON c.`id_parent_1` = p1.`id_parent`
            LEFT JOIN ".$this->db->dbprefix('parent')." p2 ON c.`id_parent_2` = p2.`id_parent`
            WHERE c.`deleted` = 0 
            AND c.`id_domain` =  ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY c.`lastname`, c.`firstname` ' : 'ORDER BY '.$orderby)
            .((is_numeric($p) && is_numeric($n)) ? ' LIMIT '.$p * $n.','.$n : '');
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    public function getChildrenCount()
    {
        $result = $this->getChildren();
        return count($result);
    }
    
    
    /*
     * Get gender of the child 1 = male / 2 = female
     */
    public function getGender($id)
    {
        $sql = "SELECT `gender`
            FROM ".$this->db->dbprefix('child')." c
            WHERE c.`id_child` = ?
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result->gender;
    }
    
    /**
     * @params id : id of the child
     * Is domain safe
     */
    public function getChildGroup($id)
    {
        $sql = "SELECT `id_group`
            FROM ".$this->db->dbprefix('child')." c
            WHERE c.`id_child` = ?
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result->id_group;
    }
    
    /**
     * @params id : id of the child
     * Is domain safe
     */
    public function getParents($id)
    {
        $parents = array();
        
        // Get parent 1
        $sql = "SELECT p.*
            FROM ".$this->db->dbprefix('child')." c,
            ".$this->db->dbprefix('parent')." p 
            WHERE c.`id_child` = ?
            AND c.`id_parent_1` = p.`id_parent`
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        
        if(count($result) > 0)
            $parents[] = $result;
        
        // Get parent 2
        $sql = "SELECT p.*
            FROM ".$this->db->dbprefix('child')." c,
            ".$this->db->dbprefix('parent')." p 
            WHERE c.`id_child` = ?
            AND c.`id_parent_2` = p.`id_parent`
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        
        if(count($result) > 0)
            $parents[] = $result;
        
        return $parents;
   
    }
    
    /*
     * Get the current event type available
     */
    public function getEventTypes($exclude_ids = null)
    {
        $exlude = null;
        if(is_array($exclude_ids))
            $exclude = implode(',', $exclude_ids);
        
        $sql = "SELECT e.*
            FROM ".$this->db->dbprefix('child_event_type')." e
            WHERE e.`deleted` = 0 
            AND e.`active` = 1 ".
            (!empty($exclude)? 'AND e.`id_child_event_type` NOT IN ('.$exclude.')' : '');
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    /*
     * Get the current event type available
     */
    public function getEventEmoticons()
    {
        $result = array(
            '100' => 'e_100_crying.png',
            '101' => 'e_101_sad.png',
            '102' => 'e_102_happy.png',
            '103' => 'e_103_upset.png',
            '104' => 'e_104_silent.png',
            '105' => 'e_105_tired.png',
        );
        return $result;
    }
    
    /*
     * Check if child has a uploaded profile picture
     */
    public function getProfilePicture($id)
    {
        $imgDir = $this->config->item('imgdir_children_secure');
        if(file_exists($imgDir.$id.'_mini.jpg'))
            return $imgDir.$id.'_mini.jpg';
        else
            return false;
    }
    
    
    /*
     * Check if a not deleted child exists with the same socialid
     * Is domain safe
     */
    public function socialidExists($value = null, $id_exclude = null)
    {
        if(is_null($value))
            return false;
        
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('child')." c 
            WHERE c.`deleted` = 0 
            AND (c.`socialid` LIKE ?
            OR c.`socialid_srch` LIKE ?
            OR c.`socialid` LIKE ?
            OR c.`socialid_srch` LIKE ?)
            AND c.`id_child` NOT IN (".(!empty($id_exclude)? $id_exclude : '0').")
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql,array($value, $value, my_searchString($value), my_searchString($value)));
        if($result->num_rows() > 0)
            return true;
        else
            return false;
        
    }
    
    /**
     * Get a child trustee
     * includes domain_name, site_name
     * @id = id_child_trustee
     * Is domain safe
     */
    public function getTrustee($id)
    {
        $sql = "SELECT ct.*,c.*
            FROM ".$this->db->dbprefix('child_trustee')." ct,
            ".$this->db->dbprefix('child')." c
            WHERE ct.`deleted` = 0
            AND ct.`id_domain` = ".(int)getUserDomain()."
            AND c.`deleted` = 0
            AND ct.`id_child` = c.`id_child`
            AND ct.`id_child_trustee` = ?
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }
    
    /*
     * Get the actual active trustees
     * Is domain safe
     */
    public function getTrustees($id_child)
    {
        $sql = "SELECT ct.*
            FROM ".$this->db->dbprefix('child_trustee')." ct
            WHERE ct.`deleted` = 0 
            AND ct.`id_child` = ?
            AND ct.`id_domain` =  ".(int)getUserDomain().'
            ORDER BY ct.`name`';
        $result = $this->db->query($sql, array((int)$id_child))->result();
        return $result;
    }
    
    /**
     * Check if child trustee has a uploaded profile picture
     * @id = id_child_trustee
     */
    public function getTrusteeProfilePicture($id)
    {
        $imgDir = $this->config->item('imgdir_trustees_secure');
        if(file_exists($imgDir.$id.'_mini.jpg'))
            return $imgDir.$id.'_mini.jpg';
        else
            return false;
    }
    
    /**
     * Get a child document
     * includes domain_name, site_name
     * @id = id_child_document
     * Is domain safe
     */
    public function getDocument($id)
    {
        $sql = "SELECT cd.*,c.*
            FROM ".$this->db->dbprefix('child_document')." cd,
            ".$this->db->dbprefix('child')." c
            WHERE cd.`id_domain` = ".(int)getUserDomain()."
            AND c.`deleted` = 0
            AND cd.`id_child` = c.`id_child`
            AND cd.`id_child_document` = ?
            AND c.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }
    
    /*
     * Get the actual documents
     * Is domain safe
     */
    public function getDocuments($id_child)
    {
        $sql = "SELECT cd.*
            FROM ".$this->db->dbprefix('child_document')." cd
            WHERE cd.`id_child` = ?
            AND cd.`id_domain` =  ".(int)getUserDomain().'
            ORDER BY cd.`docname`';
        $result = $this->db->query($sql, array((int)$id_child))->result();
        return $result;
    }
    
    /*
     *  Get the CURRENT checkin status of child
     *  no matter what date today is!
     *  @id : id of child
     *  Is domain safe
     *  Return is array with the current status and correspond query row
     */
	public function getCheckinStatus_verbose($id, $date = null)
    {   
        if(!isset($date)) 
			$date = new DateTime( date('Y-m-d') );
        
        $sql = "
			SELECT ce.*
            FROM ".$this->db->dbprefix('child_event')." ce,
            ".$this->db->dbprefix('child')." c
			WHERE ce.`id_child` = ".(int)$id." 
			AND ce.`id_type` = 1
            AND ce.`datetime_start` LIKE '".date_format($date,'Y-m-d')."%'
            AND c.`id_child` = ce.`id_child`
            AND ce.`id_domain` = ".(int)getUserDomain()."
            AND c.`id_domain` =  ".(int)getUserDomain()."
            ORDER BY ce.`datetime_start` DESC";
		$query = $this->db->query($sql);
        
        // Prep the result array
        $result = array(
            'event' => null,
            'status' => false
        );

        $query = $query->result();
        if(count($query) > 0)
            foreach ($query as $event)
            {
                // If any record is found with datetime_start with valid date and nothing for datetime_end
                // the child is currently checkedin
                if(validate_isDate($event->datetime_start) && empty($event->datetime_end))
                {
                    $result['status'] = 1;
                    $result['event'] = $event;
                    return $result;
                }
                // If a completed checkin/checkout is found, store it but keep looking for open checkin
                if(validate_isDate($event->datetime_start) && validate_isDate($event->datetime_end))
                {
                    $result['status'] = 2;
                    $result['event'] = $event;
                }       
            }
        return $result;
	}
    
    /*
     * Get the checkins that are completed (in and out)
     * for a given child on a given date or current date
     */
    public function getCheckinsCompleted($id, $date = null)
    {
		if(!isset($date)) 
			$date = new DateTime( date('Y-m-d') );
		
		$sql = "
			SELECT *
            FROM ".$this->db->dbprefix('child_event')." ce,
            ".$this->db->dbprefix('child')." c
			WHERE ce.`id_child` = ".(int)$id." 
			AND ce.`id_type` = 1
            AND ce.`datetime_start` LIKE '".date_format($date,'Y-m-d')."%'
            AND NOT ISNULL(ce.`datetime_start`)
            AND NOT ISNULL(ce.`datetime_end`)
            AND c.`id_child` = ce.`id_child`
            AND c.`id_domain` =  ".(int)getUserDomain()."
            ORDER BY ce.`datetime_start`";
		$qry = $this->db->query($sql);
		return $qry->result_array();
	}
    
    /*
     * Validate the datetime_start. Return false if it overlaps with a completed
     * checkin/checkout
     * @id_child : child
     * @datetime_start : datetime of the begin of the checkin
     */
	public function validateCheckin($id_child, $datetime_start)
	{
        $t_check = new DateTime($datetime_start);
        
        $date = new DateTime( date('Y-m-d') );
        $sql = "
			SELECT *
            FROM ".$this->db->dbprefix('child_event')." ce,
            ".$this->db->dbprefix('child')." c
			WHERE ce.`id_child` = ".(int)$id_child." 
			AND ce.`id_type` = 1
            AND ce.`datetime_start` LIKE '".date_format($date,'Y-m-d')."%'
            AND c.`id_child` = ce.`id_child`
            AND ce.`id_domain` = ".(int)getUserDomain()."
            AND c.`id_domain` =  ".(int)getUserDomain()."
            ORDER BY ce.`datetime_start` DESC";
		$qry = $this->db->query($sql);
        if($qry->num_rows = 0)
            return true;
        
		$result = $qry->result();

        foreach ($result as $event)
        {
            // Actually there is an open checkin -> any new checkin is not valid
            if(validate_isDate($event->datetime_start) && empty($event->datetime_end))
                return false;
            $t_start = (!empty($event->datetime_start) ? new DateTime($event->datetime_start) : false);
            $t_end = (!empty($event->datetime_end) ? new DateTime($event->datetime_end) : false);
            if ($t_check >= $t_start && $t_check <= $t_end)
                return false;
        }
        return true;     
    }
    
    /*
     * Validate the datetime_end. Return false if it overlaps with a completed
     * checkin/checkout
     * @id_child : child
     * @datetime_end : datetime of the end of the checkin
     */
	public function validateCheckout($id_child, $datetime_end)
	{
        $t_check = new DateTime($datetime_end);
        
        $date = new DateTime( date('Y-m-d') );
        $sql = "
			SELECT *
            FROM ".$this->db->dbprefix('child_event')." ce,
            ".$this->db->dbprefix('child')." c
			WHERE ce.`id_child` = ".(int)$id_child." 
			AND ce.`id_type` = 1
            AND ce.`datetime_start` LIKE '".date_format($date,'Y-m-d')."%'
            AND c.`id_child` = ce.`id_child`
            AND ce.`id_domain` = ".(int)getUserDomain()."
            AND c.`id_domain` =  ".(int)getUserDomain()."
            ORDER BY ce.`datetime_start` ASC";
		$qry = $this->db->query($sql);
        // If no records -> there was no checkin
        if($qry->num_rows = 0)
            return false;
        
		$result = $qry->result();

        foreach ($result as $event)
        {
            $t_start = (!empty($event->datetime_start) ? new DateTime($event->datetime_start) : false);
            $t_end = (!empty($event->datetime_end) ? new DateTime($event->datetime_end) : false);
          
            if ($t_check >= $t_start && $t_check <= $t_end)
                return false;
            
            // For a checkout there must be a checkin first
            if(validate_isDate($event->datetime_start) && empty($event->datetime_end) && $t_check > $t_start)
                return true;
        }
        return false;     
    }
    
    /*
     * Save the checkin
     * @id_child : child
     * @date : datetime of the operation
     */
	public function setCheckin($id_child, $datetime, $pickup_param = false)
	{
        // Check if valid date
        if(!validate_isDate($datetime))
            //return array('error' => 101);
        
        $currentStatus = $this->getCheckinStatus_verbose((int)$id_child);
        
        if ($currentStatus['status'] == 2 )
            if(!$this->validateCheckin((int)$id_child, $datetime))
                return array('checkin_overlap' => true);
        
        $id_group_of_child = $this->getChildGroup((int)$id_child);
        
        //Perform a checkin if no open checkin
		if ($currentStatus['status'] != 1)
        {
            $data = array(
				'id_child' => $id_child,
                'id_domain' => getUserDomain(),
                'id_group' => (int)$id_group_of_child,
				'id_type' => 1,
				'id_user_start' => (int)getUserId(),
				'datetime_start' => $datetime,
                'tag' => md5(getUserId().date('Y-m-d H:i:s').getUserDomain()),
				'date_add' => date('Y-m-d H:i:s'),
				'date_upd' => date('Y-m-d H:i:s')
			);
            
            // Check the pickups
            if(is_array($pickup_param))
            {
                $this->load->model('security_model');
                
                // Identify and check a parent
                if(isset($pickup_param['p']))
                    if($this->security_model->isParentInDomain((int)$pickup_param['p']))
                        // Add the pickup to data
                        $data['id_parent_in'] = (int)$pickup_param['p'];
                    
                // Identify and check a trustee
                if(isset($pickup_param['t']))
                    if($this->security_model->isTrusteeInDomain((int)$pickup_param['t']))
                        // Add the pickup to data
                        $data['id_child_trustee_in'] = (int)$pickup_param['t'];
            }
            
            // Checkin successfull
			return $this->db->insert('child_event', $data);
		}
        else
            // Return the current uncompleted checkin
            return array('event' => $currentStatus['event']);
    }
        
    /*
     * Save the checkout
     * @id_child : child
     * @date : datetime of the operation
     */
	public function setCheckout($id_child, $datetime, $pickup_param = false)
	{
        // Check if valid date
        if(!validate_isDate($datetime))
            //return array('error' => 101);
        
        $currentStatus = $this->getCheckinStatus_verbose((int)$id_child);
        
        if(!$this->validateCheckout((int)$id_child, $datetime))
            return array('checkout_overlap' => true);
        
        //Perform a checkout
		if ($currentStatus['status'] == 1)
        {
            // Check if the datetime param is younger than the start
            $datetstart = new DateTime($currentStatus['event']->datetime_start);
            $dateend = new DateTime($datetime);
            if($datetstart >= $dateend)
                // Error code : DateEnd lower than DateStart
                return array('error' => 102);
            
            // Check the pickups
            $p = false;
            if(is_array($pickup_param))
            {
                $this->load->model('security_model');
                
                // Identify and check a parent
                if(isset($pickup_param['p']))
                    if($this->security_model->isParentInDomain((int)$pickup_param['p']))
                        // Add the pickup to data
                        $p = array('p' => (int)$pickup_param['p']);
                    
                // Identify and check a trustee
                if(isset($pickup_param['t']))
                    if($this->security_model->isTrusteeInDomain((int)$pickup_param['t']))
                        // Add the pickup to data
                        $p = array('t' => (int)$pickup_param['t']);
            }

            // Update the checkin record
            $data = array(
				'id_child' => $id_child,
				'id_type' => 1,
				'id_user_end' => (int)getUserId(),
				'datetime_end' => $datetime,
				'date_upd' => date('Y-m-d H:i:s')
			);
            if($p)
            {
                if(isset($p['p']))
                    $data['id_parent_out'] = (int)$p['p'];
                if(isset($p['t']))
                    $data['id_child_trustee_out'] = (int)$p['t'];
            }

			$this->db->update('child_event', $data, array('id_child_event' => $currentStatus['event']->id_child_event, 'id_domain' => getUserDomain()));
            
            $id_group_of_child = $this->getChildGroup((int)$id_child);
            
            // Add the second record for the checkout => type = 2
            $data = array(
				'id_child' => $id_child,
                'id_domain' => getUserDomain(),
                'id_group' => (int)$id_group_of_child,
				'id_type' => 2,
				'id_user_start' => (int)getUserId(),
				'datetime_start' => $datetime,
                'tag' => $currentStatus['event']->tag,
				'date_add' => date('Y-m-d H:i:s'),
				'date_upd' => date('Y-m-d H:i:s')
			);
            if($p)
            {
                if(isset($p['p']))
                    $data['id_parent_out'] = (int)$p['p'];
                if(isset($p['t']))
                    $data['id_child_trustee_out'] = (int)$p['t'];
            }
            
            // Checkout successfull
			$this->db->insert('child_event', $data);
            
            return true;
		}
	}
    
    
    public function getChildJournal($id, $date)
    {
        $sql = "SELECT c.*,e.*, 
                e.`name` AS event_name,
                
                ustart.`id_user` AS start_id_user, 
                ustart.`firstname` AS start_user_firstname, 
                ustart.`lastname` AS start_user_lastname,
                
                uend.`id_user` AS end_id_user, 
                uend.`firstname` AS end_user_firstname, 
                uend.`lastname` AS end_user_lastname,
                
                pin.`id_parent` AS in_id_parent, 
                pin.`firstname` AS in_parent_firstname, 
                pin.`lastname` AS in_parent_lastname,
                
                pout.`id_parent` AS out_id_parent, 
                pout.`firstname` AS out_parent_firstname, 
                pout.`lastname` AS out_parent_lastname,
                
                e.`name` AS event_type
                
            FROM ".$this->db->dbprefix('child_event'). " c 
            LEFT JOIN ".$this->db->dbprefix('user'). " ustart ON c.`id_user_start` = ustart.`id_user`
            LEFT JOIN ".$this->db->dbprefix('user'). " uend ON c.`id_user_end` = uend.`id_user`
            LEFT JOIN ".$this->db->dbprefix('parent'). " pin ON c.`id_parent_in` = pin.`id_parent`
            LEFT JOIN ".$this->db->dbprefix('parent'). " pout ON c.`id_parent_out` = pout.`id_parent`
            LEFT JOIN ".$this->db->dbprefix('child_event_type'). " e ON c.`id_type` = e.`id_child_event_type`
            WHERE  c.`datetime_start` LIKE ?
            AND c.`id_child` = ?
            AND c.`id_domain` =  ".(int)getUserDomain().'
            ORDER BY c.`datetime_start`';
        $result = $this->db->query($sql, array(date_format($date, 'Y-m-d').'%', (int)$id));
        return $result->result();
        // ddd($result->result());
    }
    
    /*
     * Delete the record (flag delete)
     * Is domain safe
     */
    public function delete($id)
    {
        return $this->db->update('child', array('deleted' => 1, 'date_upd' => date('Y-m-d H:i:s')), array('id_child' => (int)$id, 'id_domain' => (int)getUserDomain())); 
    }
    
    /*
     * Delete the record (flag delete)
     * or hard delete if no entry in event
     * Is domain safe
     */
    public function deleteTrustee($id)
    {
        $s = false;
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('child_event')." 
            WHERE (`id_child_trustee_in` = ?
            OR `id_child_trustee_out` = ?)
            AND `id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array((int)$id, (int)$id));
        if($result->num_rows > 0)
            $s = $this->db->update('child_trustee', array('deleted' => 1, 'date_upd' => date('Y-m-d H:i:s')), array('id_child_trustee' => (int)$id, 'id_domain' => (int)getUserDomain())); 
        else
        {
            $this->db->where('id_child_trustee', (int)$id);
            $s = $this->db->delete('child_trustee');
        }
        if($s)
        {
            // In a next future -> delete the picture file to save space
            return $s;
        }
        else
            return false;
    }
    
    /**
     * Get all informations for a given document ID
     * @id = id of the document
     * Is domain safe
     */
    public function getChildDocument($id)
    {
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('child_document')." 
            WHERE `id_child_document` = ?
            AND `id_domain` =  ".(int)getUserDomain();
        
        $result = $this->db->query($sql, array((int)$id))->row();
        if(isset($result->filename_local) && file_exists($this->config->item('docsdir_childdocuments_secure').$result->filename_local))
            return $result;
        else
            return false;
    }
    
    /*
     * Get the filename on disk for a given document ID
     * @id = id of the document
     * Is domain safe
     */
    public function getNameChildDocument($id)
    {
        $result = $this->getChildDocument((int)$id);
        if($result)
            return $result->filename_local;
        else
            return false;
    }
    
    /*
     * Delete the record
     * Is domain safe
     */
    public function deleteChildDocument($id)
    {
        $sql = "SELECT `filename_local`
            FROM ".$this->db->dbprefix('child_document')." 
            WHERE `id_child_document` = ?
            AND `id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        if(isset($result->filename_local) && file_exists($this->config->item('docsdir_childdocuments_secure').$result->filename_local))
        {
            @unlink($this->config->item('docsdir_childdocuments_secure').$result->filename_local);
            return $this->db->delete('child_document', array('id_child_document' => (int)$id, 'id_domain' => (int)getUserDomain())); 
        }
        return false;
    }
    
    /*
     * Get the notices of a given child
     * Can be for a given date or the current date
     * Is domain safe
     */
    public function getChildNotices($id_child, $date = null, $total_only = false)
    {
        if(!isset($date)) 
			$date = new DateTime( date('Y-m-d') );
        
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('child_event')." 
            WHERE `id_child` = ?
            AND `id_type` IN (".$this->config->item('events_types_of_notices').")
            AND `datetime_start` LIKE '".date_format($date,'Y-m-d')."%'
            AND `id_domain` =  ".(int)getUserDomain()."
            ORDER BY `date_add`";
        $result = $this->db->query($sql, array($id));
        
        // Return only totals
        if($total_only)
            $result->num_rows();
        else
            $result->result();
    }
    
    /*
     * Get the count by notice type for a given child
     * Can be for a given date or the current date
     * Is domain safe
     */
    public function getChildNoticesByType($id_child, $date = null)
    {
        if(!isset($date)) 
			$date = new DateTime( date('Y-m-d') );
        
        $sql = "SELECT *, COUNT(`id_child_event`) AS type_count
            FROM ".$this->db->dbprefix('child_event')." 
            WHERE `id_child` = ?
            AND `id_type` IN (".$this->config->item('events_types_of_notices').")
            AND `datetime_start` LIKE '".date_format($date,'Y-m-d')."%'
            AND `id_domain` =  ".(int)getUserDomain()."
            GROUP BY `id_type`
            ORDER BY `date_add`";
        $result = $this->db->query($sql, array($id));
        
        $result->row();
    }
    
}
