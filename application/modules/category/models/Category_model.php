<?php   
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model 
{

	var $member_total;
    function __construct()
    {
        parent::__construct();
		$this->category_total = $this->get_total();
    }

	function get_total()
	{
		$this->db->select('count(id) as nb');
		$query = $this->db->get('product_category');
		$row = $query->row();
		return $row->nb;
	}	
	function orderattributes_total()
	{
		$this->db->select('count(id) as nb');
		$query = $this->db->get('order_attributes');
		$row = $query->row();
		return $row->nb;
	}	

	function get_categories($where = array(), $params = array())
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
		$query = $this->db->or_like($where);
		$query = $this->db->get('product_category');		

		if ($query->num_rows() > 0 )
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}

	}
	function get_user_roles()
	{
		$sql = "SELECT * FROM ci_user_type WHERE id !=1";
		$query = $this->db->query($sql);
		return $result = $query->result_array();

	}
	
 function get_order_columnname()
	{
		  $sql = "SELECT attribute_name FROM  ci_order_attributes where is_active=1"; 
		  $query = $this->db->query($sql);
		  $result = $query->result_array();
		  return $result;
	}
	
	function get_orderattributes($where = array(), $params = array())
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
		$query = $this->db->or_like($where);
		$query = $this->db->get('order_attributes');		

		if ($query->num_rows() > 0 )
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}

	}
	
  function get_order_product($order_id)
	{
		$sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_order_products.id as orderproduct_id, ci_order_products.quantity, ci_order_products.price_per_unit FROM ci_products, ci_product_brands, ci_order_products, ci_orders
		WHERE ci_order_products.product_id = ci_products.id AND ci_order_products.order_id=".$order_id." AND ci_products.brand_id = ci_product_brands.id AND ci_order_products.order_id = ci_orders.id ORDER BY ci_order_products.id ASC"; 
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}	
	
	function get_order_by_id($id)
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users 
		WHERE ci_orders.customer_id = ci_users.id AND ci_orders.id='".$id."'";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_order($where = array(), $params = array())
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
		$query = $this->db->or_like($where);
		$query = $this->db->get('orders');		

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
	function insert_attribute($data)
	{ 
 		$this->db->insert('order_attributes', $data);
		$id = $this->db->insert_id(); 
		return $id;
	}
	function insert_category($data)
	{
		$this->db->insert('product_category', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	function update_category($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('product_category', $data);
		return true;
	}
	function update_attribute($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('order_attributes', $data);
		return true;
	}
	function get_category_by_id($id)
	{

		$query = $this->db->get_where('product_category', array('id' => $id), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}
	function get_attribute_by_id($id)
	{

		$query = $this->db->get_where('order_attributes', array('id' => $id), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;

	}
	// ------------------------------------------------------------------------
	/**
	 * Checks if a category exists
	 *
	 * @access	public
	 * @param	mixed	search criteria
	 * @return	bool
	 */

	function exists($fields)
	{

		$query = $this->db->get_where('product_category', $fields, 1, 0);		

		if($query->num_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}
	function attributeexists($fields)
	{

		$query = $this->db->get_where('order_attributes', $fields, 1, 0);		

		if($query->num_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}
	

}