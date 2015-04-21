<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parents_model extends My_Model {

	function __construct()
	{
		parent::__construct();
        $this->table = 'parent';
        $this->primaryKey = 'id_parent';
	}
    
    /*
     * Get a given parent that is not deleted
     * includes domain_name, site_name
     * Is domain safe
     */
    public function getParent($id)
    {
        $sql = "SELECT p.*, s.name AS site_name, d.name AS domain_name,
                (SELECT COUNT(`id_child`) FROM ".$this->db->dbprefix('child')." WHERE `id_parent_1` = p.`id_parent` AND `deleted` = 0 AND `enabled` = 1)+
                (SELECT COUNT(`id_child`) FROM ".$this->db->dbprefix('child')." WHERE `id_parent_2` = p.`id_parent` AND `deleted` = 0 AND `enabled` = 1) as count_childs
            FROM ".$this->db->dbprefix('parent')." p
            LEFT JOIN ".$this->db->dbprefix('site')." s ON p.`id_site_default` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON s.`id_domain` = d.`id_domain`
            WHERE p.`deleted` = 0 
            AND p.`id_domain` = ".(int)getUserDomain()." 
            AND p.`id_parent` = ?";
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }
    
    /*
     * Get all parents that are not deleted
     * includes domain_name, site_name
     * Is domain safe
     */
    public function getParents($p = null, $n = null, $orderby = null)
    {
        $p = (is_numeric($p) ? $p - 1 : null);
        
        $sql = "SELECT p.*, s.name AS site_name, d.name AS domain_name,
                (SELECT COUNT(`id_child`) FROM ".$this->db->dbprefix('child')." WHERE `id_parent_1` = p.`id_parent` AND `deleted` = 0 AND `enabled` = 1)+
                (SELECT COUNT(`id_child`) FROM ".$this->db->dbprefix('child')." WHERE `id_parent_2` = p.`id_parent` AND `deleted` = 0 AND `enabled` = 1) as count_childs
            FROM ".$this->db->dbprefix('parent')." p
            LEFT JOIN ".$this->db->dbprefix('site')." s ON p.`id_site_default` = s.`id_site`
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON s.`id_domain` = d.`id_domain`
            WHERE p.`deleted` = 0 
            AND p.`id_domain` = ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY p.`lastname`, p.`firstname` ' : 'ORDER BY '.$orderby)
            .((is_numeric($p) && is_numeric($n)) ? ' LIMIT '.$p * $n.','.$n : '');
        $result = $this->db->query($sql)->result();
        if(count($result) > 0)
            return $result;
        return false;
    }
    
    /*
     * Get the count of the parents in the domain
     * Is domain safe
     */
    public function getParentsCount()
    {
        $result = $this->getParents();
        return count($result);
    }
    
    /**
     * Get the active children of this parent
     */
    public function getActiveChildren($id)
    {
        $sql = "SELECT c.*
            FROM ".$this->db->dbprefix('child')." c
            WHERE c.`deleted` = 0
            AND c.`enabled` = 1
            AND (c.`id_parent_1` = ? OR c.`id_parent_2` = ?)
            AND c.`id_domain` = ".(int)getUserDomain()."
            ORDER BY c.`birthdate` DESC";
        $result = $this->db->query($sql, array($id, $id))->result();
        return $result;
    }
    
    /*
     * Check if a not deleted parent exists with the same social id
     * Is domain safe
     */
    public function socialidExists($value = null, $id_exclude = null)
    {
        if(is_null($value))
            return false;
        
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('parent')." p
            WHERE p.`deleted` = 0 
            AND p.`id_domain` = ".(int)getUserDomain()." 
            AND (p.`socialid` LIKE ?
            OR p.`socialid_srch` LIKE ?
            OR p.`socialid` LIKE ?
            OR p.`socialid_srch` LIKE ?)
            AND p.`id_parent` NOT IN (".(!empty($id_exclude)? $id_exclude : '0').")";
        $result = $this->db->query($sql,array($value, $value, my_searchString($value), my_searchString($value)));
        if($result->num_rows() > 0)
            return true;
        else
            return false;
        
    }
    
    
    /*
     * Check if a not deleted parent exists with the same email
     * Is domain safe
     */
    public function emailExists($value = null, $id_exclude = null)
    {
        if(is_null($value))
            return false;
        
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('parent')." p
            WHERE p.`deleted` = 0 
            AND p.`email` LIKE ? 
            AND p.`id_domain` = ".(int)getUserDomain()." 
            AND p.`id_parent` NOT IN (".(!empty($id_exclude)? $id_exclude : '0').")";
        $result = $this->db->query($sql,array($value));
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
        return $this->db->update('parent', array('deleted' => 1), array('id_parent' => $id, 'id_domain' => (int)getUserDomain())); 
    }
    
}
