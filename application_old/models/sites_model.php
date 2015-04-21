<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites_model extends My_Model {

	function __construct()
	{
		parent::__construct();
        $this->table = 'site';
        $this->primaryKey = 'id_site';
	}
    
    /*
     * Get a given site that is not deleted
     * includes domain_name
     * Is domain safe
     */
    public function getSite($id)
    {
        $sql = "SELECT s.*, d.name AS domain_name
            FROM ".$this->db->dbprefix('site')." s
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON s.`id_domain` = d.`id_domain`
            WHERE s.`deleted` = 0 
            AND s.`id_site` = ?
            AND s.`id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql, array($id))->row();
        return $result;
    }
    
    /*
     * Get all sites that are not deleted
     * includes domain_name
     * Is domain safe
     */
    public function getSites($p = null, $n = null, $orderby = null)
    {
        $p = (is_numeric($p) ? $p - 1 : null);
        
        $sql = "SELECT s.*, d.name AS domain_name
            FROM ".$this->db->dbprefix('site')." s
            LEFT JOIN ".$this->db->dbprefix('domain')." d ON s.`id_domain` = d.`id_domain`
            WHERE s.`deleted` = 0 
            AND s.`id_domain` =  ".(int)getUserDomain()." "
            .(empty($orderby) ? 'ORDER BY s.`order` ASC ' : 'ORDER BY '.$orderby)
            .((is_numeric($p) && is_numeric($n)) ? ' LIMIT '.$p * $n.','.$n : '');
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    
    /*
     * Check if site id does exist and not deleted one
     * Is domain safe
     */
    public function checkSiteIsValid($id)
    {
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('site')." s
            WHERE s.`deleted` = 0 
            AND s.`id_site` = ? 
            AND s.`id_domain` = ".(int)getUserDomain();
        $result = $this->db->query($sql,array((int)$id));
        if($result->num_rows() > 0)
            return true;
        else
            return false;
    }
    
    /*
     * Swap position of two records
     * @id_current will become @id_swap
     * Is domain safe
     */
    public function swapPosition($id_current, $id_swap)
    {
        $sql = "SELECT * 
            FROM ".$this->db->dbprefix('site')." 
            WHERE `id_site` IN (?, ?)
            AND `id_domain` =  ".(int)getUserDomain()." ";
        $result = $this->db->query($sql, array($id_current,$id_swap))->result_array();
        $update = array();
        $update[0] = array('id' => $result[0]['id_site'], 'order' => $result[1]['order']);
        $update[1] = array('id' => $result[1]['id_site'], 'order' => $result[0]['order']);
        foreach ($update as $value) {
            $this->db->update('site',array('order' => $value['order']),array('id_site' => $value['id']));
        }
    }
    
    /*
     * Get current max position
     * Is domain safe
     */
    public function getMaxPosition()
    {
        $sql = "SELECT MAX(`order`) AS max_order 
            FROM ".$this->db->dbprefix('site')."
            WHERE `id_domain` =  ".(int)getUserDomain();
        $result = $this->db->query($sql)->row();
        return $result->max_order;
    }
    
    
    /*
     * Check if a not deleted site exists with the same name
     * Is domain safe
     */
    public function siteExists($name = null)
    {
        if(is_null($name))
            return false;
        
        $sql = "SELECT *
            FROM ".$this->db->dbprefix('site')." 
            WHERE `deleted` = 0 
            AND `name` LIKE ?
            AND `id_domain` =  ".(int)getUserDomain();
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
        return $this->db->update('site', array('deleted' => 1), array('id_site' => $id,'id_domain' => (int)getUserDomain())); 
    }
    
    
}

