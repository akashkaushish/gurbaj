<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');


class Member_model extends CI_Model {
	
	var $member_total;
    function __construct()
    {
        parent::__construct();
		$this->member_total = $this->get_total();
    }

	function get_total()
	{
		$this->db->select('count(id) as nb');
		//$query = $this->db->where(array('is_delete' => 0));
		$query = $this->db->get('users');
		$row = $query->row();
		return $row->nb;
	}
		

	function get_list()
	{
		$query = $this->db->get('users');
		return $query->result_array();
	}


	function get_users($where = array(), $params = array())
	{
	
		$default_params = array
		(
			'order_by' => 'id',
			'limit' => 5,
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
			$where = array('id', $where);
		}
		//$query = $this->db->where(array('id !='=> 1, 'is_delete' => 0));
		$query = $this->db->where(array('id !='=> 1));

		$query = $this->db->or_like($where);
		$query = $this->db->get('users');
		
		if ($query->num_rows() > 0 )
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	function validate_direct_login($email)
	{
		$query = $this->db->get_where('users', array('email' => $email,'status' => 'active'), 1, 0);
		
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}	
	
	// ------------------------------------------------------------------------
	
	/**
	 * Get specific user
	 *
	 * @access	public
	 * @param	string	username
	 * @return	mixed	user data
	 */
	function get_user($username)
	{
		$query = $this->db->get_where('users', array('username' => $username), 1, 0);
		
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;
	}
	
	function get_user_by_id($id)
	{
		$query = $this->db->get_where('users', array('id' => $id), 1, 0);
		
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;
	}
	
	function get_user_by_ref_number($id_number,$params = array())
	{ 
	
	    $this->db->limit($params['limit'], $params['start']);
		$query = $this->db->get_where('users', array('ref_number' => $id_number));
		return $query->result_array();
	}
	
	
	function get_user_by_ref_number_total($id_number)
	{ 
	
	    
		$query = $this->db->get_where('users', array('ref_number' => $id_number));
		return count($query->result_array());
	}
	
	
	// ------------------------------------------------------------------------
	
	/**
	 * Checks if a user exists
	 *
	 * @access	public
	 * @param	mixed	search criteria
	 * @return	bool
	 */
	function exists($fields)
	{
		$query = $this->db->get_where('users', $fields, 1, 0);
		
		if($query->num_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	// ------------------------------------------------------------------------
	
	
	/**
	 * Create a new user
	 *
	 * @access	public
	 * @param	string	username
	 * @param	string	email address
	 * @param	string	password
	 * @param	mixed	parameters
	 * @return	void
	 */

	// ------------------------------------------------------------------------
	
	/**
	 * Increment user post count
	 *
	 * @access	public
	 * @param	integer	user id
	 * @return	void
	 */
	function add_post($id)
	{
		$this->db->where('id', $id);
		$this->db->set('post_count','post_count+1', FALSE);
		$this->db->update('users');
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Decrement user post count
	 *
	 * @access	public
	 * @param	integer	user id
	 * @return	void
	 */
	function remove_post($id)
	{
		$this->db->where('id', $id);
		$this->db->set('post_count','post_count-1', FALSE);
		$this->db->update('users');
	}
	
	// ------------------------------------------------------------------------
	
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
		$this->db->update('users', $data);
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
		$this->db->delete('users', array('id' => $id));
	}
	
	function insert_user($data)
	{
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		return $id;
	}
	
	function update_user($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}
	
	function validate_login($email, $password)
	{
		$query = $this->db->get_where('users', array('email' => $email, 'password' => $password, 'status' => 'active'), 1, 0);
		
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;
		/* $sql = "SELECT * FROM ci_users WHERE email='".$email."' and password='".$password."' and status='active'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return @$result; */
	}
/*13 feb*/
	function get_services($params = array())
	{
	
	    $this->db->limit($params['limit'], $params['start']);
		$query = $this->db->get_where('services', array('is_active' => 1));
		return $query->result_array();
	}
	function get_products($params = array())
	{
	   $this->db->limit($params['limit'], $params['start']);
		$query = $this->db->get_where('products', array('is_active' => 1));
		return $query->result_array();
	}
	function get_video()
	{
		$query = $this->db->get_where('tutorial_videos', array('is_active' => 1));
		return $query->result_array();
	}	

	function get_all_media($user_id,$params = array())
	{
        //$query = $this->db->get_where('media', array('is_active' => 1));
		//return $query->result_array();
		/* $sql = "SELECT ci_media.*, ci_media_type.media_type FROM ci_media, ci_media_type
		WHERE ci_media.media_type_id= ci_media_type.media_type_id and ci_media.is_active=1"; */

		// Commented on 10-Nov-2017
		/* $sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id, ci_user_media.is_gallery, ci_user_media.receiver_id, ci_user_media.sender_id  FROM ci_media, ci_media_type, ci_user_media
		 WHERE ci_user_media.receiver_id = '".$user_id."' AND ci_user_media.sender_id = 1 AND ci_media.media_id = ci_user_media.media_id 
		 AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		 AND ci_user_media.receiver_status = 1  AND ci_media.is_delete=1 AND ci_user_media.is_gallery = 1 ORDER BY ci_user_media.user_media_id DESC LIMIT ".$params['start']." ,".$params['limit']."";   */

		 $sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id, ci_user_media.is_gallery, ci_user_media.receiver_id, ci_user_media.sender_id  FROM ci_media, ci_media_type, ci_user_media
		 WHERE ci_user_media.receiver_id = '".$user_id."' AND ci_user_media.sender_id = 1 AND ci_media.media_id = ci_user_media.media_id 
		 AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		 AND ci_user_media.receiver_status = 1  AND ci_media.is_delete=1 AND ci_user_media.is_gallery = 1 ORDER BY ci_user_media.user_media_id DESC LIMIT ".$params['start']." ,".$params['limit']."";


		$query = $this->db->query($sql);
		return $result = $query->result_array();
		 
	}
	
	
	function get_child_user($id_number)
	{
		$query = $this->db->get_where('users', array('status' => 'active', 'ref_number' => $id_number));
		return $query->result_array();
	}
	
	
	function get_id_number($id)
	{
		$query = $this->db->get_where('users', array('id' => $id), 1, 0);
		$data=$query->row_array();
		
		if($query->num_rows() == 1)
		   return $data['id_number'];
		else
		  return FALSE;
	}
	
  function get_user_by_email($email)
	{
		$query = $this->db->get_where('users', array('status' => 'active', 'email' => $email));
		
		
		if($query->num_rows() == 1)
		   return $query->result_array();
		else
		  return FALSE;
		
	}
	
	function change_password($user_id, $display_password, $password)
	{
		//$sql = "UPDATE ci_users SET password='".$this->user->_prep_password($display_password)."' WHERE id=".$user_id; 
		//$query = $this->db->query($sql);
		//return true;
	}
	
	function get_media_details($media_id)
	{
	
		$sql = "SELECT * from ci_user_media where user_media_id=".$media_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	function insert_media_data($data)
	{
	
		$this->db->insert('user_media', $data);
		$id = $this->db->insert_id();
		return $id;
	}	
	
	
	function get_count_send_media($user_id)
	{
     
		$sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id FROM ci_media, ci_media_type, ci_user_media
		 WHERE ci_user_media.sender_id = '".$user_id."' AND ci_media.media_id = ci_user_media.media_id 
		 AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		 AND ci_user_media.sender_status = 1 AND ci_media.is_delete=1 ";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return count($result);
		 
	}
	
	function get_all_send_media($user_id,$params = array())
	{
        //$query = $this->db->get_where('media', array('is_active' => 1));
		//return $query->result_array();
		/* $sql = "SELECT ci_media.*, ci_media_type.media_type FROM ci_media, ci_media_type
		WHERE ci_media.media_type_id= ci_media_type.media_type_id and ci_media.is_active=1"; */
		$sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id, ci_user_media.sender_id, ci_user_media.receiver_id, ci_users.first_name FROM ci_media, ci_media_type, ci_users, ci_user_media
		 WHERE ci_user_media.sender_id = '".$user_id."' AND ci_user_media.receiver_id = ci_users.id AND ci_media.media_id = ci_user_media.media_id 
		 AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		 AND ci_user_media.sender_status = 1 AND ci_media.is_delete=1 ORDER BY ci_user_media.user_media_id desc LIMIT ".$params['start']." ,".$params['limit']."";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
		 
	}
	
	
		function get_user_media_received_notification($user_id,$params = array())
      {
		   $data = array();
		   if($user_id > 0)
		   { 
		   
			$sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id, ci_user_media.is_gallery, ci_users.first_name FROM ci_media, ci_media_type, ci_user_media, ci_users
		   WHERE ci_user_media.receiver_id = '".$user_id."' AND ci_user_media.sender_id = ci_users.id AND ci_media.media_id = ci_user_media.media_id 
		   AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		   AND ci_user_media.receiver_status = 1 AND ci_media.is_delete=1 AND ci_user_media.is_gallery !=1 ORDER BY ci_user_media.user_media_id desc LIMIT ".$params['start']." ,".$params['limit'].""; 
			$query = $this->db->query($sql);
			return $data = $query->result_array();
			
		   }else{
			return $data;
		   }
     }
	
	
	
	function get_user_media_notification($user_id,$params = array())
      {
		   $data = array();
		   if($user_id > 0)
		   { 
		   
			$sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id, ci_users.first_name FROM ci_media, ci_media_type, ci_user_media, ci_users
		   WHERE ci_user_media.receiver_id = '".$user_id."' AND ci_user_media.sender_id = ci_users.id AND ci_media.media_id = ci_user_media.media_id 
		   AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		   AND ci_user_media.receiver_status = 1 AND ci_user_media.is_notify = 1 ORDER BY ci_user_media.user_media_id desc LIMIT ".$params['start']." ,".$params['limit'].""; 
			$query = $this->db->query($sql);
			return $data = $query->result_array();
			
		   }else{
			return $data;
		   }
     }
	 
 function get_user_media_notification_count($user_id)
      {
		   $data = array();
		   if($user_id > 0)
		   { 
		   
			$sql = "SELECT ci_media.*, ci_media_type.media_type, ci_users.first_name, ci_user_media.is_gallery FROM ci_media, ci_media_type, ci_user_media, ci_users
		   WHERE ci_user_media.receiver_id = '".$user_id."' AND ci_user_media.sender_id = ci_users.id AND ci_media.media_id = ci_user_media.media_id 
		   AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1
		   AND ci_user_media.receiver_status = 1 AND ci_media.is_delete=1 AND ci_user_media.is_notify = 1 AND ci_user_media.is_gallery !=1"; 
		   
		   
			$query = $this->db->query($sql);
			$result = $query->result_array();
		    return count($result);
			
		   }else{
			return $data;
		   }
     }
 function get_media_data($user_media_id)
        {
			//$sql = "SELECT * from ci_media where media_id=".$media_id;
			$sql = "SELECT ci_media.*, ci_media_type.media_type FROM ci_media, ci_media_type, ci_user_media
			 WHERE ci_media.media_type_id= ci_media_type.media_type_id AND ci_user_media.media_id = ci_media.media_id AND ci_user_media.user_media_id=".$user_media_id;
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
function update_user_notify($id, $data)
	{
		$this->db->where('user_media_id', $id);
		$this->db->update('user_media', $data);
		return true;
	}
function product_count(){
	$this->db->select('count(id) as nb');
		$query = $this->db->get('products');
		$row = $query->row();
		return $row->nb;
	
	}
	
	function services_count(){
	$this->db->select('count(id) as nb');
		$query = $this->db->get('services');
		$row = $query->row();
		return $row->nb;
	
	}
	
	function get_count_all_media($user_id)
	{
	
		$sql = "SELECT ci_media.*, ci_media_type.media_type,ci_user_media.user_media_id,ci_user_media.is_gallery, ci_user_media.receiver_id, ci_user_media.sender_id FROM ci_media, ci_media_type, ci_user_media
		WHERE ci_user_media.receiver_id = '".$user_id."' AND ci_user_media.sender_id = 1 AND ci_media.media_id = ci_user_media.media_id 
		AND ci_media.media_type_id= ci_media_type.media_type_id AND ci_media.is_active=1 AND ci_media.is_delete=1
		AND ci_user_media.receiver_status = 1 AND ci_user_media.is_gallery = 1";
		$query = $this->db->query($sql);
		
		$result = $query->result_array();
		return count($result);
	}
	
	function get_count_acitve_notification($user_id)
	{
		$this->db->select('count(is_notify_read_count) as nb');
		$query = $this->db->get_where('user_media', array('receiver_id' => $user_id, 'is_notify_read_count' => 1), 1, 0);
		$row = $query->row();
		//echo  $sql = $this->db->last_query(); exit;
		return $row->nb;
	}
	
	function reset_user_notify_count($user_id)
	{
		if($user_id > 0)
		{
			$data = array('is_notify_read_count' => 0);
			$this->db->where('receiver_id', $user_id);
			$this->db->update('user_media', $data);
			return true;
		}else{
			return false;
		}
	}
	function delete_send($id)
	{
		//$this->db->delete('user_media', array('user_media_id' => $id));
		$data = array('sender_status' => 0);
		$this->db->where('user_media_id', $id);
		$this->db->update('user_media', $data);
		return true;
		
	}
	
	function delete_received($id)
	{
		$data = array('receiver_status' => 0);
		$this->db->where('user_media_id', $id);
		$this->db->update('user_media', $data);
		return true;
	}
	
}