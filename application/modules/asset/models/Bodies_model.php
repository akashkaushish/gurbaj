<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');


class Bodies_model extends CI_Model {
	
	var $bodies_total;
    function __construct()
    {
        parent::__construct();
		$this->bodies_total = $this->get_total();
    }

	function get_total()
	{
		$this->db->select('count(id) as nb');
		//$query = $this->db->where(array('is_delete' => 0));
		$query = $this->db->get('bodies');
		$row = $query->row();
		return $row->nb;
	}
		

	function get_list()
	{
		$query = $this->db->get('bodies');
		return $query->result_array();
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Checks if a body exists
	 *
	 * @access	public
	 * @param	mixed	search criteria
	 * @return	bool
	 */
	function exists($fields)
	{
		$query = $this->db->get_where('bodies', $fields, 1, 0);
		
		if($query->num_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	
	/**
	 * Change user information
	 *
	 * @access	public
	 * @param	mixed	changed data
	 * @return	void
	 */
	function change($data)
	{
		$this->db->where('id', $this->_user['id']);
		$this->db->update('bodies', $data);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Delete a user
	 *
	 * @access	public
	 * @param	integer	user id
	 * @return	void
	 */
	function delete($id)
	{
		$this->db->delete('bodies', array('id' => $id));
	}
  
	function body_count(){
		$this->db->select('count(id) as nb');
		$query = $this->db->get('bodies');
		$row = $query->row();
		return $row->nb;
	
	}
	
	function get_bodies($params = array())
	{
		$where = array();
		$default_params = array
		(
			'order_by' => 'id',
			'limit' => 50,
			'start' => null,
			'limit' => null
		);
		
		foreach ($default_params as $key => $value)
		{
			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];
		}	
	
		if (!is_array($where))
		{
			$where = array('id', $where);
		}
		$query = $this->db->or_like($where);	   
		$this->db->order_by($params['order_by'],"DESC");
		$this->db->limit($params['limit'], $params['start']);
		$query = $this->db->get_where('bodies', array('is_active' => 1));
		return $query->result_array();
	}
	function insert_newbody($data){
	
		$this->db->insert('bodies', $data);
		$id = $this->db->insert_id();
		return $id;

	}
	

	function get_allbodies($params = array())
	{
		$where = array();
		$default_params = array
		(
			'order_by' => 'id',
			'limit' => 50,
			'start' => null,
			'limit' => null
		);
		
		foreach ($default_params as $key => $value)
		{
			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];
		}	
	
		
		$query = $this->db->or_like($where);
	    $this->db->order_by($params['order_by'],"DESC");
	    $this->db->limit($params['limit'], $params['start']);
		$query = $this->db->get_where('bodies');
		return $query->result_array();
	}
	function get_body_by_id($id){
	
	$query = $this->db->get_where('bodies', array('id' => $id), 1, 0);
		
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}

	function updatebody($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('bodies', $data);
	}

}