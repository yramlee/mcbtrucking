<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_model extends CI_Model {       
    private $_table, $_id, $_refno, $_startdate, $_enddate, $_company_id, $_date_created, $_date_modified;
    
    public function __construct() {
        parent::__construct();
        $this->_table = 'billing';
        $this->_id = 'id'; 
        $this->_refno = 'ref_no';
        $this->_company_id = 'company_id';
        $this->_startdate = 'start_date';
        $this->_enddate = 'end_date';
        $this->_date_created = 'date_created';
        $this->_date_modified = 'date_modified';
    }
    
    /**
     * Gets all the data
     * 
     * @return array
     */
    public function get_all()
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    /**
     * Gets all the data by company
     * 
     * @return array
     */
    public function get_all_by_company($company_id = null)
    {
        $this->db->from($this->_table);
        $this->db->where($this->_company_id, $company_id);
        $this->db->order_by("start_date", "asc");
        $query = $this->db->get(); 
        return !empty($query) ? $query->result():array();
    }
    
    /**
     * Gets all records but with limit and offset
     * 
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_limit_offset($limit = 5, $offset = 1) {
        $this->db->from($this->_table);
        $this->db->limit($limit, $offset);
        $query  = $this->db->get();
        return $query->result();
    }
    
    /**
     * Gets by id
     * 
     * @param int $id
     * @return array
     */
    public function get_by_id($id = null)
    {
        $query = $this->db->get_where($this->_table, array($this->_id => $id));
        return !empty($query) ? $query->result()[0]:array();
    }
    
    
    /**
     * Inserts a record to pages table
     * 
     * @param array $data
     */
    public function insert($data = array())
    {        
        $data[$this->_date_created] = date('Y-m-d H:i:s');   
        $data[$this->_date_modified] = date('Y-m-d H:i:s');   
        $this->db->insert($this->_table, $data);
    }
    
    /**
     * Updates a record in the table
     * 
     * @param array $data
     */
    public function update($data = array())
    { 
        $data[$this->_date_modified] = date('Y-m-d H:i:s');        
        $this->db->update($this->_table, $data, array($this->_id => $data[$this->_id]));
    }
    
    /**
     * Deletes a record in the table
     * 
     * @param int $id
     */
    public function delete_by_id($id = null)
    { 
        $this->db->delete($this->_table, array($this->_id => $id));
    }
}
