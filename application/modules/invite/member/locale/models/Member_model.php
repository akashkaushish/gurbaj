<?php   
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model 
{

	var $member_total;
    function __construct()
    {
        parent::__construct();
		//$this->member_total = $this->get_total();
    }

	function get_total($filter='')
	{
		if(isset($filter) && ($filter != ''))
		{	   
	      $sql = "SELECT id FROM ci_users WHERE  id != 1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR uniq_id LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC  "; 	   
	  }else{	   
	      $sql = "SELECT id FROM ci_users WHERE  id != 1   GROUP BY id ORDER BY id DESC "; 
	  }
	  
	    $query = $this->db->query($sql);
	    return count($query->result_array());
	}
	
	function get_total_suppliers($filter='')
	{
		if(isset($filter) && ($filter != ''))
		{	   
	    $sql = "SELECT id FROM ci_users WHERE type_id = 3  AND is_active=1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR uniq_id LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC "; 
		 	$query = $this->db->query($sql);
		 	return count($query->result_array());
	   
	  }else{	   
	    $sql = "SELECT id FROM ci_users WHERE type_id = 3  AND is_active=1 GROUP BY id ORDER BY id DESC"; 
		 $query = $this->db->query($sql);
		 return count($query->result_array());
	  }
	}

	function get_suppliers($filter='',$params = array())
	{
		if(isset($filter) && ($filter != '')){	   
	    $sql = "SELECT * FROM ci_users WHERE type_id = 3  AND is_active=1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR uniq_id LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC ";  
		 	$query = $this->db->query($sql);
		 	return $result = $query->result_array();
	  }else{	   
	    $sql = "SELECT * FROM ci_users WHERE type_id = 3  AND is_active=1 GROUP BY id ORDER BY id DESC";
		 	$query = $this->db->query($sql);
		 	return $result = $query->result_array();
	  }
	}

	function get_games($params = array())
	{	
		$default_params = array
		(
			'order_by' => 'id',
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
			$where = array('id', $where);
		}
		$query = $this->db->or_like($where);
		$query =$this->db->get_where('games', array('is_active' => 1));
		
		return $query->result_array();
	}	



	function get_list()
	{
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	function get_users($filter='', $params = array())
	{
		if(isset($filter) && ($filter != ''))
		{	   
	    $sql = "SELECT * FROM ci_users WHERE  id != 1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR uniq_id LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit']." "; 
		 	
	   
	  }else{	   
	    $sql = "SELECT * FROM ci_users WHERE  id != 1 ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		
	  }
	
	     $query = $this->db->query($sql);
		 return $query->result_array();
	  
	}


	function get_users_old($where = array(), $params = array())
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
		echo $this->db->last_query(); 

		if ($query->num_rows() > 0 )
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}

	}
	
	
	function get_admin_brands($where = array(), $params = array())
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

		$query = $this->db->or_like($where);
		$query = $this->db->get('product_brands');		

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

	function get_brand_by_id($id)
	{

		$query = $this->db->get_where('product_brands', array('id' => $id), 1, 0);
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

	function get_user_roles_by_id($id)
	{
		$sql = "SELECT type_id FROM ci_user_roles WHERE user_id=".$id;
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function get_customers()
	{
		$sql = "SELECT ci_users.*, ci_user_roles.type_id FROM ci_users, ci_user_roles 
						WHERE ci_user_roles.user_id = ci_users.id AND ci_user_roles.type_id=4 AND ci_users.is_active=1";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
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

	function brand_exists($fields)
	{

		$query = $this->db->get_where('product_brands', $fields, 1, 0);		

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

	function insert_brand($data)
	{
		$this->db->insert('product_brands', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	function insert_user_role($data)
	{
		$this->db->insert('user_roles', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	function update_user($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}
	function update_brand($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('product_brands', $data);
		return true;
	}

	function validate_login($email, $password)
	{

		$query = $this->db->get_where('users', array('email' => $email, 'password' => $password, 'is_active' => 1), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}

/*13 feb*/

	function get_services($params = array())
	{

	    $this->db->limit($params['limit'], $params['start']);
		$query = $this->db->get_where('services', array('is_active' => 1));
		return $query->result_array();
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


	function update_user_notify($id, $data)
	{
		$this->db->where('user_media_id', $id);
		$this->db->update('user_media', $data);
		return true;
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
	
	function get_user_roles()
	{
		$sql = "SELECT * FROM ci_user_type WHERE id !=1";
		$query = $this->db->query($sql);
		return $result = $query->result_array();

	}



	
	function get_roles_by_id($id)
	{
		$sql = "SELECT ci_user_roles.*, ci_user_type.type, ci_user_type.id as roleIds FROM ci_user_roles, ci_user_type 
		WHERE ci_user_roles.type_id = ci_user_type.id AND ci_user_roles.user_id =".$id;
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function get_product_brands()
	{
		$sql = "SELECT ci_product_brands.*, ci_users.fname, ci_users.lname FROM ci_product_brands, ci_users 
		WHERE ci_product_brands.added_by = ci_users.id";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	

}