<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Dinokid - 2014
 * 
 * Provide several functions to expedite some tasks or get some information
 * that are related to the application
 */

class Security_model extends CI_Model {

    /*
     * Check if the id child belongs to the user domain
     * To be used on update operations (edit) and avoid domain violation
     */
    public function isChildInDomain($id_child)
    {   
        $sql = "SELECT `id_child`
            FROM ".$this->db->dbprefix('child')." 
            WHERE `id_domain` = ? 
            AND `id_child` = ?";
        if ($this->db->query($sql,array((int)getUserDomain(),(int)$id_child))->row())
            return true;
        else
            return false;
    }    
    
    /*
     * Check if the id parent belongs to the user domain
     * To be used on update operations (edit) and avoid domain violation
     */
    public function isParentInDomain($id_parent)
    {   
        $sql = "SELECT `id_parent`
            FROM ".$this->db->dbprefix('parent')." 
            WHERE `id_domain` = ? 
            AND `id_parent` = ?";
        if ($this->db->query($sql,array((int)getUserDomain(),(int)$id_parent))->row())
            return true;
        else
            return false;
    }  
    
    /*
     * Check if the id trustee belongs to the user domain
     * To be used on update operations (edit) and avoid domain violation
     */
    public function isTrusteeInDomain($id_child_trustee)
    {   
        $sql = "SELECT `id_child_trustee`
            FROM ".$this->db->dbprefix('child_trustee')." 
            WHERE `id_domain` = ? 
            AND `id_child_trustee` = ?";
        if ($this->db->query($sql,array((int)getUserDomain(),(int)$id_child_trustee))->row())
            return true;
        else
            return false;
    }   
    
    /*
     * Check if the id document belongs to the user domain
     * To be used on update operations (edit) and avoid domain violation
     */
    public function isDocumentInDomain($id_child_document)
    {   
        $sql = "SELECT `id_child_document`
            FROM ".$this->db->dbprefix('child_document')." 
            WHERE `id_domain` = ? 
            AND `id_child_document` = ?";
        if ($this->db->query($sql,array((int)getUserDomain(),(int)$id_child_document))->row())
            return true;
        else
            return false;
    }   
	
}
