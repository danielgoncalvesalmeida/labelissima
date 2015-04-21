<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_model extends My_Model {

	function __construct()
	{
		parent::__construct();
        $this->table = 'child_group';
        $this->primaryKey = 'id_child_group';
	}

    /*
     * Get a given group that is not deleted
     * includes domain_name, site_name
     */
    public function getGroup($id)
    {
        $sql = "SELECT cg.*, s.name AS site_name, d.name AS domain_name
            FROM ".$this->db->dbprefix('child_group')." cg
            LEFT JOIN ".$this->db->dbprefix('site')." s ON cg.`id_site` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON cg.`id_domain` = d.`id_domain`
            WHERE cg.`deleted` = 0 
            AND cg.`id_child_group` = ?
            AND cg.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }
    
    /*
     * Get all groups that are not deleted
     * includes domain_name, site_name
     * Is domain safe
     */
    public function getGroups($p = null, $n = null, $orderby = null, $id_site = null)
    {
        $p = (is_numeric($p) ? $p - 1 : null);
        
        
        $sql = "SELECT cg.*, s.name AS site_name, d.name AS domain_name
            FROM ".$this->db->dbprefix('child_group')." cg
            LEFT JOIN ".$this->db->dbprefix('site')." s ON cg.`id_site` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON cg.`id_domain` = d.`id_domain`
            WHERE cg.`deleted` = 0 
            ".(is_numeric($id_site) ? "AND cg.`id_site` = ".(int)$id_site : "" )."
            AND cg.`id_domain` =  ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY cg.`order` ASC ' : 'ORDER BY '.$orderby)
            .((is_numeric($p) && is_numeric($n)) ? ' LIMIT '.$p * $n.','.$n : '');
        //$this->db->cache_on();
        $result = $this->db->query($sql)->result();
        //$this->db->cache_off();
        return $result;
    }
    
    /*
     * Get active children of a given group
     */
    public function getGroupChildren($id)
    {
        $sql = "SELECT c.*
            FROM ".$this->db->dbprefix('child')." c
            WHERE c.`deleted` = 0 
            AND c.`enabled` = 1
            AND c.`id_group` = ?
            AND c.`id_domain` =  ".(int)getUserDomain()."
            ORDER BY c.`firstname`, c.`lastname`";
        $result = $this->db->query($sql, array($id))->result();
        return $result;
    }
    
    /*
     * Check if group id does exist and not deleted one
     * Is domain safe
     */
    public function checkGroupIsValid($id)
    {
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('child_group')." cg
            WHERE cg.`deleted` = 0 
            AND cg.`id_child_group` = ? 
            AND cg.`id_domain` = ".(int)getUserDomain();
        $result = $this->db->query($sql,array((int)$id));
        if($result->num_rows() > 0)
            return true;
        else
            return false;
    }
    
    /*
     * Get children of a group that ARE checked in today
     * Is domain safe
     * @id : id group
     */
    public function getGroup_childrenCheckedin($id)
    {
        if(isset($datetime))
            $date = new DateTime( $datetime );
        else
            $date = new DateTime( date('Y-m-d') );
        
        $sql = "SELECT c.*, ce.*, @vid_child:=ce.`id_child`, MAX(ce.`id_child_event`)
            FROM ".$this->db->dbprefix('child')." c,
            ".$this->db->dbprefix('child_event')." ce
            WHERE c.`deleted` = 0 
            AND c.`enabled` = 1
            AND c.`id_group` = ?
            AND c.`id_child` = ce.`id_child`
            AND ce.id_type = 1 
            AND NOT ISNULL(ce.`datetime_start`)
            AND ISNULL(ce.`datetime_end`)
            AND ce.`datetime_start` LIKE '".date_format($date, 'Y-m-d')."%'
            AND c.`id_domain` =  ".(int)getUserDomain()."
            GROUP BY ce.`id_child`
            ORDER BY c.`firstname`, c.`lastname`";
        $result = $this->db->query($sql, array((int)$id))->result();
        return $result;
    }
   
   
    /*
     * Get children of a group that ARE checked out today
     * Is domain safe
     */
    public function getGroup_childrenCheckedout($id)
    {
        if(isset($datetime))
            $date = new DateTime( $datetime );
        else
            $date = new DateTime( date('Y-m-d') );
        
        $sql = "SELECT c.*, ce.*, @vid_child:=ce.`id_child`, MAX(ce.`id_child_event`)
            FROM ".$this->db->dbprefix('child')." c,
            ".$this->db->dbprefix('child_event')." ce
            WHERE c.`deleted` = 0 
            AND c.`enabled` = 1
            AND c.`id_group` = ?
            AND c.`id_child` = ce.`id_child`
            AND ce.id_type = 1 
            AND NOT ISNULL(ce.`datetime_start`)
            AND NOT ISNULL(ce.`datetime_end`)
            AND ce.`datetime_start` LIKE '".date_format($date, 'Y-m-d')."%'
            AND c.`id_domain` =  ".(int)getUserDomain()."
            GROUP BY ce.`id_child`
            ORDER BY c.`firstname`, c.`lastname`";
        $result = $this->db->query($sql, array((int)$id))->result();
        return $result;
    }
    
    /*
     * Get children of a group with a count of the notices and with the peak of 
     * the notice reached. It gives the results based on todays date.
     * Is domain safe
     */
    public function getGroup_noticesTotals($id_group)
    {
        if(isset($datetime))
            $date = new DateTime( $datetime );
        else
            $date = new DateTime( date('Y-m-d') );
        
        $sql = "SELECT c.*, ce.*
            FROM ".$this->db->dbprefix('child')." c
            LEFT JOIN ".$this->db->dbprefix('child_event')." ce ON (c.`id_child` = ce.`id_child`)
            WHERE c.`deleted` = 0 
            AND c.`enabled` = 1
            AND c.`id_group` = ?
            AND c.`id_child` = ce.`id_child`
            AND ce.`id_type` IN (".$this->config->item('events_types_of_notices').")
            AND ce.`datetime_start` LIKE '".date_format($date, 'Y-m-d')."%'
            AND c.`id_domain` =  ".(int)getUserDomain()."
            ORDER BY c.`id_child`";
        $result = $this->db->query($sql, array((int)$id_group));
        if($result->num_rows() == 0)
            return false;
        
        $totals = array();
        $result = $result->result();
        foreach ($result as $key => $value)
        {
            if(!isset($totals[$value->id_child]))
                $totals[$value->id_child] = array(
                    'total' => 0,
                    'seek' => 0,
                    'rest' => 0,
                    'activity' => 0,
                    'general' => 0,
                    'meal' => 0,
                    'pampers' => 0,
                    'severity' => null,
                );
            
            $totals[$value->id_child]['total'] = ++$totals[$value->id_child]['total'];
            if($value->id_type == 3)
                $totals[$value->id_child]['seek'] = ++$totals[$value->id_child]['seek'];
            if($value->id_type == 4)
                $totals[$value->id_child]['rest'] = ++$totals[$value->id_child]['rest'];
            if($value->id_type == 5)
                $totals[$value->id_child]['activity'] = ++$totals[$value->id_child]['activity'];
            if($value->id_type == 6)
                $totals[$value->id_child]['general'] = ++$totals[$value->id_child]['general'];
            if($value->id_type == 7)
                $totals[$value->id_child]['meal'] = ++$totals[$value->id_child]['meal'];
            if($value->id_type == 8)
                $totals[$value->id_child]['pampers'] = ++$totals[$value->id_child]['pampers'];
            
        }
        
        // Determine severity peak
        foreach ($totals as &$value)
        {
            if($value['seek'] > 0)
                $value['severity'] = 'danger';
        }
        return $totals;
    }
    
    /*
     * Get all groups that are not deleted
     * includes domain_name, site_name, with total children assigned to it.
     * Is domain safe
     */
    public function getGroupsWithTotals($orderby = null, $id_domain = 1, $id_site = null)
    {
        $sql = "SELECT @id_group:=cg.id_child_group, cg.*, s.name AS site_name, d.name AS domain_name, 
                (SELECT COUNT(id_child) FROM ".$this->db->dbprefix('child')." 
                    WHERE id_group = @id_group
                    AND `deleted` = 0 AND `enabled` = 1) as children_count
            FROM ".$this->db->dbprefix('child_group')." cg
            LEFT JOIN ".$this->db->dbprefix('site')." s ON cg.`id_site` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON cg.`id_domain` = d.`id_domain`
            WHERE cg.`deleted` = 0 
            AND cg.`id_domain` =  ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY cg.`order` ASC' : 'ORDER BY '.$orderby);
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    /*
     * Get all groups that are not deleted
     * includes domain_name, site_name, with total children assigned to it.
     * Contains also the events and other stats for today
     * Is domain safe
     */
    public function getGroupsWithTodaysTotals($orderby = null, $id_domain = 1, $id_site = null)
    {
        $date = new DateTime( date('Y-m-d') );
        $id_for_notices = $this->config->item('events_types_of_notices');
        $id_for_notices_danger = $this->config->item('events_types_of_notices');
        $id_for_notices_danger = (empty($id_for_notices_danger) ? 3 : $id_for_notices_danger);
        
        $sql = "SELECT @id_group:=cg.id_child_group, cg.*, s.name AS site_name, d.name AS domain_name, 
                (SELECT COUNT(id_child) FROM ".$this->db->dbprefix('child')." 
                    WHERE id_group = @id_group
                    AND `deleted` = 0 AND `enabled` = 1) as children_count,
                (SELECT COUNT(id_type) FROM ".$this->db->dbprefix('child_event')."
                    WHERE id_type IN (".$id_for_notices.") 
                    AND id_group = cg.`id_child_group`
                    AND datetime_start LIKE '".date_format($date, 'Y-m-d')."%') as notices_count,
                (SELECT COUNT(id_type) FROM ".$this->db->dbprefix('child_event')."
                    WHERE id_type IN (".$id_for_notices_danger.") 
                    AND id_group = cg.`id_child_group`
                    AND datetime_start LIKE '".date_format($date, 'Y-m-d')."%') as notices_danger_count,
                (SELECT COUNT(id_type) FROM ".$this->db->dbprefix('child_event')."
                    WHERE id_type IN (1) 
                    AND id_group = cg.`id_child_group`
                    AND datetime_start LIKE '".date_format($date, 'Y-m-d')."%') as checkin_count,
                (SELECT COUNT(id_type) FROM ".$this->db->dbprefix('child_event')."
                    WHERE id_type IN (2) 
                    AND id_group = cg.`id_child_group`
                    AND datetime_start LIKE '".date_format($date, 'Y-m-d')."%') as checkout_count
            FROM ".$this->db->dbprefix('child_group')." cg
            LEFT JOIN ".$this->db->dbprefix('site')." s ON cg.`id_site` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON cg.`id_domain` = d.`id_domain`
            WHERE cg.`deleted` = 0 
            AND cg.`id_domain` =  ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY cg.`order` ASC' : 'ORDER BY '.$orderby);

        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    /**
     * Get the journal for the kids of the group
     * It is a journal i.e. it includes the all children (even those that are disabled and soft deleted)
     * Children are shown according to their group assignement corresponding to the given date
     * 
     * @id : id of the group
     * @date : DateTime
     * Is domain safe
     */
    public function getGroupJournal($id, $date)
    {
        if(!$date instanceof DateTime)
            $date = new DateTime(date('Y-m-d'));
        
        $childs_all = array();
        $childs_all[] = 0;
        
        // First get the concerned children from the event journal
        $sql = "SELECT c.`id_child`
            FROM ".$this->db->dbprefix('child_event'). " ce
            LEFT JOIN ".$this->db->dbprefix('child'). " c ON ce.`id_child` = c.`id_child`
            WHERE ce.`datetime_start` LIKE ?
            AND ce.`id_group` = ? 
            AND ce.`id_domain` =  ".(int)getUserDomain()."
            GROUP BY c.`id_child`";
        $childs = $this->db->query($sql, array(date_format($date, 'Y-m-d').'%', (int)$id))->result_array();
     
 
        foreach ($childs as $v)
            $childs_all[] = $v['id_child'];
        
        // Retrieve the current children assigned to the group
        $sql = "SELECT c.`id_child`
            FROM ".$this->db->dbprefix('child'). " c
            WHERE c.`id_group` = ? 
            AND c.`id_domain` =  ".(int)getUserDomain()."
            AND c.`enabled` = 1
            AND c.`deleted` = 0
            GROUP BY c.`id_child`";
        $childs = $this->db->query($sql,array((int)$id))->result_array();
 
        foreach ($childs as $v)
        {
            if(!in_array($v['id_child'], $childs_all))
                $childs_all[] = $v['id_child'];
        }
            
        // Retrieve all the children data ordered by first and last name
        $sql = "SELECT c.*
            FROM ".$this->db->dbprefix('child'). " c
            WHERE c.`id_group` = ? 
            AND c.`id_domain` =  ".(int)getUserDomain()."
            AND c.`id_child` IN (".implode(',', $childs_all).")
            GROUP BY c.`id_child`
            ORDER BY c.`firstname`, c.`lastname`";
        $childs = $this->db->query($sql,array((int)$id))->result_array();

        // Get the events related to the selected date
        $sql = "SELECT ce.*, 
                cet.`name` AS event_type,
                
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
                pout.`lastname` AS out_parent_lastname
                
            FROM ".$this->db->dbprefix('child_event'). " ce 
            LEFT JOIN ".$this->db->dbprefix('user'). " ustart ON ce.`id_user_start` = ustart.`id_user`
            LEFT JOIN ".$this->db->dbprefix('user'). " uend ON ce.`id_user_end` = uend.`id_user`
            LEFT JOIN ".$this->db->dbprefix('parent'). " pin ON ce.`id_parent_in` = pin.`id_parent`
            LEFT JOIN ".$this->db->dbprefix('parent'). " pout ON ce.`id_parent_out` = pout.`id_parent`
            LEFT JOIN ".$this->db->dbprefix('child_event_type'). " cet ON ce.`id_type` = cet.`id_child_event_type`
            LEFT JOIN ".$this->db->dbprefix('child'). " c ON ce.`id_child` = c.`id_child`
            WHERE  ce.`datetime_start` LIKE ?
            AND ce.`id_group` = ?
            AND ce.`id_domain` =  ".(int)getUserDomain().'
            ORDER BY ce.`datetime_start`';
        $events = $this->db->query($sql, array(date_format($date, 'Y-m-d').'%', (int)$id))->result();
        
        // Merge the events with the corresponding child
        foreach ($childs as $kc => $vc)
        {
            $t_e = array();
            foreach ($events as $ve)
            {
                //ddd($ve);
                if($ve->id_child == $vc['id_child'])
                    $t_e[] = $ve;
            }
            $childs[$kc]['events'] = $t_e;
        }
        
        //ddd($childs);
        
        return $childs;
        // ddd($result->result());
    }
    
    /*
     * Swap position of two records
     * @id_current will become @id_swap
     * Is domain safe
     */
    public function swapPosition($id_current, $id_swap)
    {
        $this->db->cache_delete_all();
        $sql = "SELECT * 
            FROM ".$this->db->dbprefix('child_group')." 
            WHERE `id_child_group` IN (?, ?)
            AND `id_domain` =  ".(int)getUserDomain()." ";
        $result = $this->db->query($sql, array($id_current,$id_swap))->result_array();
        $update = array();
        $update[0] = array('id' => $result[0]['id_child_group'], 'order' => $result[1]['order']);
        $update[1] = array('id' => $result[1]['id_child_group'], 'order' => $result[0]['order']);
        foreach ($update as $value) {
            $this->db->update('child_group',array('order' => $value['order']),array('id_child_group' => $value['id']));
        }
    }
    
    /*
     * Get current max position
     * Is domain safe
     */
    public function getMaxPosition()
    {
        $sql = "SELECT MAX(`order`) AS max_order 
            FROM ".$this->db->dbprefix('child_group')."
            WHERE `id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql)->row();
        return $result->max_order;
    }
    
    /*
     * Get a list of the active sites
     * Is domain safe
     */
    public function getSites($orderby = null)
    {
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('site')." s
            WHERE s.`deleted` = 0 
            AND s.`id_domain` =  ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY s.`order`' : 'ORDER BY '.$orderby);
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    /*
     * Check if a not deleted group exists with the same name
     * Is domain safe
     */
    public function groupExists($name = null)
    {
        if(is_null($name))
            return false;
        
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('child_group')." cg
            WHERE cg.`deleted` = 0 
            AND cg.`name` LIKE ?
            AND cg.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql,array($name));
        if($result->num_rows() > 0)
            return true;
        else
            return false;
        
    }
    
    /*
     * Delete the record (flag delete)
     * Is domain safe
     */
    public function delete($id)
    {
        return $this->db->update('child_group', array('deleted' => 1), array('id_child_group' => $id,'id_domain' => (int)getUserDomain())); 
    }
    
}   
