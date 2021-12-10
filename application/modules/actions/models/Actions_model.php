<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');


class Actions_model extends CI_Model {
	
	var $audio_total; 
	var $category_total;
	var $sub_category_total;
    function __construct()
    {
        parent::__construct();
		$this->image_total= $this->get_total();
		
    }

	function get_total()
	{
		$this->db->select('count(action_id) as nb');
		$query = $this->db->get('user_action');
		$row = $query->row();
		return $row->nb;
	}
	

	// ------------------------------------------------------------------------
	
	/**
	 * Checks if a audio exists
	 *
	 * @access	public
	 * @param	mixed	search criteria
	 * @return	bool
	 */
	function exists($fields)
	{
		$query = $this->db->get_where('user_action', $fields, 1, 0);
		
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
		$this->db->update('user_action', $data);
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
		$this->db->delete('user_action', array('action_id' => $id));
	}
  
	function audio_count(){
		$this->db->select('count(action_id) as nb');
		$query = $this->db->get('user_action');
		$row = $query->row();
		return $row->nb;
	
	}
	
	function insert_action($data){
	
		$this->db->insert('user_action', $data);
		$id = $this->db->insert_id();
		return $id;

	}
	
	function get_actions($where,$params = array())
	{
			$default_params = array
		(
			'order_by' => 'action_id',
			'limit' => 10,
			'start' => null,
			'limit' => null
		);
		
		foreach ($default_params as $key => $value)
		{
			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];
		}
		
		$this->db->order_by($params['order_by'],"DESC");
		$this->db->limit($params['limit'], $params['start']);
	
		if (!is_array($where))
		{
			$where = array('action_id', $where);
		}
		$query = $this->db->or_like($where);
		$query = $this->db->get('user_action');
		
		return $query->result_array();
	}
	
	
	function get_action_by_id($id){
	$query = $this->db->get_where('user_action', array('action_id' => $id), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}
	
	function updateaction($id, $data)
	{
		$this->db->where('action_id', $id);
		$this->db->update('user_action', $data);
	}

}