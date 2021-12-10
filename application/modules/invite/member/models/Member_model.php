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
	      $sql = "SELECT id FROM ci_users WHERE  id != 1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC  "; 	   
	  }else{	   
	      $sql = "SELECT id FROM ci_users WHERE  id != 1   GROUP BY id ORDER BY id DESC "; 
	  }
	  
	    $query = $this->db->query($sql);
	    return count($query->result_array());
	}
	
	function get_package_licence_price($id)
	{
		$query = $this->db->get_where('plans', array('id' => $id), 1, 0);
		$data=$query->row_array();
		
		if($query->num_rows() == 1)
		   return $data;
		else
		  return FALSE;
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
	
	function get_user_payment($filter='', $params = array())
	{
		if(isset($filter) && ($filter != ''))
		{	   
	    $sql = "SELECT * FROM ci_users WHERE  id != 1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR uniq_id LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit']." "; 
		 	
	   
	  }else{	   
	    //$sql = "SELECT * FROM ci_user_plan_details WHERE is ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		$sql = "SELECT ci_user_plan_details.*, ci_users.fname as fname, ci_users.lname as lname,ci_plans.plan_name FROM ci_user_plan_details, ci_users ,ci_plans
		WHERE ci_user_plan_details.plan_id = ci_plans.id AND ci_user_plan_details.user_id =ci_users.id LIMIT ".$params['start']." ,".$params['limit']." ";
		
	  }
	     $query = $this->db->query($sql);
		 return $query->result_array();
	  
	}
	function get_user_payment_total($filter='')
	{
		if(isset($filter) && ($filter != ''))
		{	   
	    	$sql = "SELECT id FROM ci_users WHERE  id != 1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR uniq_id LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC"; 
		}else{	   
			//$sql = "SELECT * FROM ci_user_plan_details WHERE is ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
			$sql = "SELECT ci_user_plan_details.id, ci_users.fname as fname, ci_users.lname as lname,ci_plans.plan_name FROM ci_user_plan_details, ci_users ,ci_plans
			WHERE ci_user_plan_details.plan_id = ci_plans.id AND ci_user_plan_details.user_id =ci_users.id";
		}
	     $query = $this->db->query($sql);
		 return count($query->result_array());
	  
	}

	function get_user_withdraw_requests()
	{
		
		$sql = "SELECT ci_withdraws.*, ci_users.fname as fname, ci_users.lname as lname FROM ci_withdraws, ci_users
		WHERE ci_withdraws.user_id = ci_users.id";
		  $query = $this->db->query($sql);
		 return $query->result_array();
	  
	}
	
	function get_users($filter='', $params = array())
	{
		if(isset($filter) && ($filter != ''))
		{	   
	    $sql = "SELECT * FROM ci_users WHERE  id != 1 AND (fname LIKE '%".$filter."%'  OR lname LIKE '%".$filter."%' OR email LIKE '%".$filter."%' OR phone LIKE '%".$filter."%') GROUP BY id ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit']." "; 
		 	
	   
	  }else{	   
	    $sql = "SELECT * FROM ci_users WHERE  id != 1 ORDER BY id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		
	  }
	 	 $sql;
	  	 $query = $this->db->query($sql);
		 return $query->result_array();
	  
	}
	function get_user_total_wallet($userid)
	{
		$sql = "SELECT wallet_total FROM ci_users WHERE id = '".$userid."' ORDER BY id DESC LIMIT 1"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['wallet_total']) && $result[0]['wallet_total'] > 0)
		{
			return $wallet_total = @$result[0]['wallet_total'];
		}else{
			return 0;
		}
	}
	function get_user_total_invested($userid)
	{
		$sql = "SELECT sum(payment_amount) as totalinvest FROM ci_user_plan_details WHERE user_id = '".$userid."' AND is_confirmed=1"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['totalinvest']) && $result[0]['totalinvest'] > 0)
		{
			return $totalinvested = @$result[0]['totalinvest'];
		}else{
			return 0;
		}
	}
	function get_user_total_withdrawn($userid)
	{
		$sql = "SELECT sum(amount) as totalwithdrawn FROM ci_user_transactions WHERE user_id = '".$userid."' AND trans_type='debit' AND trans_reason='waithdraw'"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['totalwithdrawn']) && $result[0]['totalwithdrawn'] > 0)
		{
			return $totalwithdrawn = @$result[0]['totalwithdrawn'];
		}else{
			return 0;
		}
	}
	function get_admin_approve($userid)
	{
		 $sql = "SELECT ci_user_plan_details.*, ci_plans.plan_name FROM ci_user_plan_details, ci_plans
		  WHERE ci_plans.id = ci_user_plan_details.plan_id AND ci_user_plan_details.user_id = '".$userid."' ORDER BY ci_user_plan_details.id DESC"; 
	  	 $query = $this->db->query($sql);
		 return $query->result_array();
	  
	}
	function get_all_plans()
	{
		$sql = "SELECT * FROM ci_plans WHERE is_active=1 ORDER BY id ASC"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_user_active_plans()
	{
		$today = date('Y-m-d');
		$sql = "SELECT ci_user_plan_details.*, ci_plans.price, ci_plans.payout FROM ci_user_plan_details, ci_plans WHERE ci_user_plan_details.plan_id = ci_plans.id AND ci_user_plan_details.is_confirmed=1 AND ci_user_plan_details.is_close=0 AND ci_user_plan_details.plan_activation_date <= '".$today."' AND ci_user_plan_details.plan_end_date >='".$today."' ORDER BY ci_user_plan_details.id ASC"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function total_paid_to_user_today($user_id)
	{
		$today = date('Y-m-d');
		$sql = "SELECT sum(amount) as total FROM ci_user_transactions WHERE user_id = '".$user_id."' AND trans_type='credit' AND date_created ='".$today."' AND is_transfer=0"; 
		$query = $this->db->query($sql); 
		$result = $query->result_array(); 
		if(isset($result[0]['total'])){ return $result[0]['total']; }else{ return 0; }
	}
	function get_today_updated_payout($user_plan_id, $user_id)
	{
		$today = date('Y-m-d');
		$sql = "SELECT id FROM ci_user_transactions WHERE user_id=".$user_id." AND payout_plan_id=".$user_plan_id." AND trans_type='credit' AND date_created = '".$today."'"; 
		$query = $this->db->query($sql);
		$result = $query->result_array(); 
		if(isset($result[0]['id'])){  return @$result[0]['id']; }else{ return 0; }
	}
	function get_today_updated_commission($user_plan_id, $user_id)
	{
		$today = date('Y-m-d');
		$sql = "SELECT id FROM ci_user_transactions WHERE user_id=".$user_id." AND comm_by_plan_id=".$user_plan_id." AND trans_type='credit' AND date_created = '".$today."'"; 
		$query = $this->db->query($sql);
		$result = $query->result_array(); 
		if(isset($result[0]['id'])){  return @$result[0]['id']; }else{ return 0; }
	}
	function get_user_transaction_by_id($userid, $start, $limit)
	{
		$sql = "SELECT * FROM ci_user_transactions WHERE user_id=".$userid." ORDER BY id DESC LIMIT ".$start." , ".$limit; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_user_transaction_by_id_count($userid)
	{
		$sql = "SELECT count(id) as num FROM ci_user_transactions WHERE user_id=".$userid." ORDER BY id DESC"; 
		$query = $this->db->query($sql);
		$result = $query->result_array(); 
		if(isset($result[0]['num'])){  return @$result[0]['num']; }else{ return 0; }
	}

	function get_user_withdraws($userid)
	{
		$sql = "SELECT * FROM ci_withdraws WHERE user_id=".$userid." ORDER BY id DESC"; 
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
		$this->db->last_query(); 

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
	
	
	function user_plan_data($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('user_plan_details', $data);
		return true;
	}

	function end_user_plans($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('user_plan_details', $data);
		return true;
	}
	
	function get_userpayment_by_id($id)
	{
		$query = $this->db->get_where('user_plan_details', array('id' => $id), 1, 0);
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
	function get_user_by_refcode($code)
	{
		$query = $this->db->get_where('users', array('my_ref_code' => $code), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;
	}
	function get_plan_by_id($id)
	{
		$query = $this->db->get_where('plans', array('id' => $id), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;
	}
	function get_user_by_ref_code($code)
	{
		$query = $this->db->get_where('users', array('my_ref_code' => $code), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}
	function get_user_activeplan($user_id)
	{
		$sql = "SELECT * FROM ci_user_plan_details WHERE is_close=0 AND is_confirmed=1 AND user_id=".$user_id;
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_user_by_key($key)
	{
		$sql = "SELECT * FROM ci_users WHERE activation_key='".$key."'";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_subscription_plans()
	{
		$sql = "SELECT * FROM ci_plans WHERE is_active=1";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function get_user_roles_by_id($id)
	{
		$sql = "SELECT type_id FROM ci_user_roles WHERE user_id=".$id;
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function get_my_downline($user_id)
	{
		$sql = "SELECT * FROM ci_users WHERE ref_id = '".$user_id."'";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_my_total_ref($user_id)
	{
		$sql = "SELECT SUM(amount) as com,  SUM(would_be_amount) as could_be_com FROM ci_user_transactions WHERE user_id = '".$user_id."' AND trans_reason='commission'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result; 
	}
	/*function get_my_total_couldbe_com($user_id)
	{
		$sql = "SELECT SUM(would_be_amount) as com FROM ci_user_transactions WHERE user_id = '".$user_id."' AND trans_reason='commission'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['com'])){ return $result[0]['com']; }else{ return 0; }
	}*/
	function get_user_plan_amount_by_id($plan_id)
	{
		$sql = "SELECT price FROM ci_plans WHERE id = '".$plan_id."'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['price'])){ return $result[0]['price']; }else{ return 0; }
	}
	function get_num_active_downline($user_id)
	{
		$sql = "SELECT count(id) as cnt FROM ci_users WHERE ref_id = '".$user_id."' AND is_paid=1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['cnt'])){ return $result[0]['cnt']; }else{ return 0; }
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
	function insert_withdraw_request($data)
	{
		$this->db->insert('withdraws', $data);
		$id = $this->db->insert_id();
		return $id;
	}
	function insert_payout($data)
	{
		$this->db->insert('user_transactions', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	function insert_user_transaction($data)
	{
		$this->db->insert('user_transactions', $data);
		$id = $this->db->insert_id();
		return $id;
	}
	
	function insert_plan($data)
	{
		$this->db->insert('user_plan_details', $data);
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
	function update_withdraw_request($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('withdraws', $data);
		return true;
	}
	function update_user_transaction($id, $amount)
	{
		$sql="UPDATE ci_users SET wallet_total = wallet_total+".$amount." WHERE id =".$id;
		$query = $this->db->query($sql);
		return true;
		//$this->db->where('id', $id);
		//$this->db->update('user_transactions', $data);
		//return true;
	}
	function debit_user_wallet($id, $amount)
	{
		$sql="UPDATE ci_users SET wallet_total = wallet_total-".$amount." WHERE id =".$id;
		$query = $this->db->query($sql);
		return true;
		//$this->db->where('id', $id);
		//$this->db->update('user_transactions', $data);
		//return true;
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