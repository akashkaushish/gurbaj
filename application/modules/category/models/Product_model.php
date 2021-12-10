<?php   
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model 
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
	
	function get_total_analizer_products($filter=''){
	  
		  if(isset($filter) && ($filter != '')){
		   $sql = "SELECT ci_products.id, ci_product_brands.name as brand_name, ci_product_category.category, ci_users.fname, ci_users.lname FROM ci_products, ci_product_brands, ci_product_category, ci_users 
		WHERE ci_products.category_id = ci_product_category.id AND ci_products.analyser_id = ci_users.id AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') ORDER BY ci_products.id DESC  ";
		$query = $this->db->query($sql);
		return count($query->result_array());
		  
		  }else{
		     $sql = "SELECT ci_products.id, ci_product_brands.name as brand_name, ci_product_category.category, ci_users.fname, ci_users.lname FROM ci_products, ci_product_brands, ci_product_category, ci_users 
		WHERE ci_products.category_id = ci_product_category.id AND ci_products.analyser_id = ci_users.id AND ci_products.brand_id = ci_product_brands.id ORDER BY ci_products.id DESC  ";
		$query = $this->db->query($sql);
		return count($query->result_array());
		  }
	
	}

	function get_products($filter='',$params = array())
	{
	
		if(isset($filter) && ($filter != '')){
		     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category, ci_users.fname, ci_users.lname FROM ci_products, ci_product_brands, ci_product_category, ci_users 
		WHERE ci_products.category_id = ci_product_category.id AND ci_products.analyser_id = ci_users.id AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit']." ";
		   $query = $this->db->query($sql);
		   return $result = $query->result_array();
		  
		}else{
		
		   $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category, ci_users.fname, ci_users.lname FROM ci_products, ci_product_brands, ci_product_category, ci_users 
		WHERE ci_products.category_id = ci_product_category.id AND ci_products.analyser_id = ci_users.id AND ci_products.brand_id = ci_product_brands.id ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit']." ";
		   $query = $this->db->query($sql);
		   return $result = $query->result_array();
		
		}
		
	}

	function get_buyer_products($filter='',$params = array())
	{
	
		if(isset($filter) && ($filter != '')){
		     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category, ci_order_products
		WHERE ci_order_products.product_id = ci_products.id AND ci_products.category_id = ci_product_category.id AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit']." ";
		   $query = $this->db->query($sql);
		   return $result = $query->result_array();
		  
		}else{
		
		   $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category, ci_users.fname, ci_users.lname FROM ci_products, ci_product_brands, ci_product_category, ci_users 
		WHERE ci_products.category_id = ci_product_category.id AND ci_products.analyser_id = ci_users.id AND ci_products.brand_id = ci_product_brands.id ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit']." ";
		   $query = $this->db->query($sql);
		   return $result = $query->result_array();
		
		}
		
	}
	
	
    function get_pending_carts()
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users
		WHERE ci_orders.customer_id = ci_users.id AND ci_orders.is_active = 0 ORDER BY ci_orders.id DESC LIMIT 20";
		$query = $this->db->query($sql);
		return $result = $query->result_array();

	}
	function get_sales_orders()
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users
		WHERE ci_orders.customer_id = ci_users.id AND ci_orders.is_active != 0 ORDER BY ci_orders.id DESC LIMIT 20";
		$query = $this->db->query($sql);
		return $result = $query->result_array();

	}
	function get_customer_orders($user_id)
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users
		WHERE ci_orders.created_by_user_id = ci_users.id AND ci_orders.customer_id = ".$user_id." 
		AND ci_orders.is_active != 0 ORDER BY ci_orders.id DESC LIMIT 20";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_shipping_orders()
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users
		WHERE ci_orders.created_by_user_id = ci_users.id AND ci_orders.status = 'Paid' ORDER BY ci_orders.id DESC LIMIT 20"; 
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_shipped_orders()
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users
		WHERE ci_orders.shipping_user_id = ci_users.id AND ci_orders.status = 'Shipped' ORDER BY ci_orders.id DESC LIMIT 20"; 
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_customer_pending_cart($user_id)
	{
		$sql = "SELECT id FROM ci_orders WHERE customer_id = ".$user_id." AND is_active = 0 ORDER BY ci_orders.id DESC LIMIT 1";
		$query = $this->db->query($sql);
		return $result = $query->result_array();

	}
	function get_pending_orders()
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users
		WHERE ci_orders.customer_id = ci_users.id AND ci_orders.is_active = 0 ORDER BY ci_orders.id DESC LIMIT 20";
		$query = $this->db->query($sql);
		return $result = $query->result_array();

	}
	
	function get_total_supplier_products($filter='')
	{
	
	   if(isset($filter) && ($filter != '')){	   
	     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category,  FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') GROUP BY ci_products.id ORDER BY ci_products.id DESC "; 
		 $query = $this->db->query($sql);
		 return count($query->result_array());
	   
	   }else{	   
	     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id GROUP BY ci_products.id ORDER BY ci_products.id DESC"; 
		 $query = $this->db->query($sql);
		 return count($query->result_array());
	   
	   }
		
	}
	
	function get_total_sales_products($filter='')
	{
	
	   if(isset($filter) && ($filter != '')){	   
	     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') GROUP BY ci_products.id ORDER BY ci_products.id DESC "; 
		 $query = $this->db->query($sql);
		 return count($query->result_array());
	   
	   }else{	   
	     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id GROUP BY ci_products.id ORDER BY ci_products.id DESC"; 
		 $query = $this->db->query($sql);
		 return count($query->result_array());
	   
	   }
		
	}
	
	function get_supplier_product($filter='',$params = array())
	{
	
	   if(isset($filter) && ($filter != '')){	   
	     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') GROUP BY ci_products.id ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		 $query = $this->db->query($sql);
		 return $result = $query->result_array();
	   
	   }else{	   
	     $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id GROUP BY ci_products.id ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		 $query = $this->db->query($sql);
		 return $result = $query->result_array();
	   
	   }
	}
	
	function get_product_for_order($filter='',$params = array())
	{
		if(isset($filter) && ($filter != '')){	   
	    $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id AND (ci_products.name LIKE '%".$filter."%'  OR ci_products.sku LIKE '%".$filter."%' OR ci_products.color LIKE '%".$filter."%' OR ci_products.size LIKE '%".$filter."%' OR ci_products.note LIKE '%".$filter."%') GROUP BY ci_products.id ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		 $query = $this->db->query($sql);
		 return $result = $query->result_array();
	   
	   }else{	   
	    $sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category FROM ci_products, ci_product_brands, ci_product_category
		 WHERE ci_products.category_id = ci_product_category.id  AND ci_products.brand_id = ci_product_brands.id GROUP BY ci_products.id ORDER BY ci_products.id DESC LIMIT ".$params['start']." ,".$params['limit'].""; 
		 $query = $this->db->query($sql);
		 return $result = $query->result_array();
	   }
	}
	
	function get_order_product($order_id)
	{
		$sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_order_products.id as orderproduct_id, ci_order_products.quantity, ci_order_products.price_per_unit FROM ci_products, ci_product_brands, ci_order_products, ci_orders
		WHERE ci_order_products.product_id = ci_products.id AND ci_order_products.order_id=".$order_id." AND ci_products.brand_id = ci_product_brands.id AND ci_order_products.order_id = ci_orders.id ORDER BY ci_order_products.id ASC"; 
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_product_detail_by_id($id)
	{
		$sql = "SELECT ci_products.*, ci_product_brands.name as brand_name, ci_product_category.category, count(ci_product_supplier.supplier_id) AS suppliercount FROM ci_products, ci_product_brands, ci_product_category, ci_product_supplier 
		WHERE ci_products.category_id = ci_product_category.id AND ci_product_supplier.product_id = ci_products.id AND ci_products.brand_id = ci_product_brands.id AND ci_products.id='".$id."' GROUP BY ci_products.id ORDER BY ci_products.id DESC LIMIT 20"; 
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	/*function get_orders_sales()
	{
		$sql = "SELECT ci_users.fname, ci_users.lname, ci_users.email, ci_users.phone FROM ci_users, ci_orders 
				WHERE ci_orders.customer_id = ci_users.id AND ci_orders.status='new' ORDER BY ci_orders.id desc";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}*/

	function get_supplier_by_prodcutid($id)
	{
		$this->db->select('supplier_id');
		$query = $this->db->get_where('product_supplier', array('product_id' => $id));
		$result = $query->result_array();
		return $result;
	}
	function get_all_suppliers()
	{
		$sql = "SELECT ci_users.id, ci_users.fname, ci_users.lname, ci_users.uniq_id, ci_users.phone FROM ci_users, ci_user_roles 
		WHERE ci_user_roles.user_id = ci_users.id AND ci_user_roles.type_id=8 AND ci_users.is_active = 1 ORDER BY fname";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function get_product_supplierlist($id)
	{
		$sql = "SELECT ci_product_supplier.*, ci_users.fname, ci_users.lname, ci_users.uniq_id FROM ci_products, ci_product_supplier, ci_users 
		WHERE ci_products.id = ci_product_supplier.product_id AND ci_users.id = ci_product_supplier.supplier_id AND ci_product_supplier.product_id='".$id."' ORDER BY ci_product_supplier.is_default DESC LIMIT 20";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function confirm_customer_order($order_id)
	{
		$date=date('Y-m-d');
		$sql = "UPDATE ci_orders SET status='Confirmed', customer_confirm_date='".$date."'  WHERE id =".$order_id; 
		$query = $this->db->query($sql);
		return true;
	}
	function get_order_by_id($id)
	{
		$sql = "SELECT ci_orders.*, ci_users.fname, ci_users.lname FROM ci_orders, ci_users 
		WHERE ci_orders.customer_id = ci_users.id AND ci_orders.id='".$id."'";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}
	function update_suppliers_default_by_product_id($product_id)
	{
		$sql = "UPDATE ci_product_supplier SET is_default=0 WHERE product_id =".$product_id; 
		$query = $this->db->query($sql);
		return true;
	}
	function set_default_supplier($id)
	{
		$sql = "UPDATE ci_product_supplier SET is_default=1 WHERE id =".$id; 
		$query = $this->db->query($sql);
		return true;
	}
	
	function get_product_by_id($id)
	{

		$query = $this->db->get_where('products', array('id' => $id), 1, 0);
		if($query->num_rows() == 1)
			return $query->row_array();
		else
			return FALSE;
	}
	
	
	function get_order_product_by_id($id)
	{
		$query = $this->db->get_where('order_products', array('id' => $id), 1, 0);
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
	function get_user_by_type($type)
	{

		$query = $this->db->get_where('users', array('type_id' => $type)); 
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function get_supplier_by_id($id)
	{
		$query = $this->db->get_where('product_supplier', array('id' => $id), 1, 0);
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

	function get_product_categories()
	{
		$sql = "SELECT id, category FROM ci_product_category WHERE is_active =1 ORDER BY category asc";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function get_product_brands()
	{
		$sql = "SELECT ci_product_brands.id, ci_product_brands.name FROM ci_product_brands WHERE is_active =1 ORDER BY ci_product_brands.name asc";
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function insert_product($data)
	{
		$this->db->insert('products', $data); 
		$id = $this->db->insert_id(); 
		return $id;
	}
	function insert_product_in_order($data)
	{
		$this->db->insert('order_products', $data); 
		$id = $this->db->insert_id();
		return $id;
	}
	function insert_order($data)
	{
		$this->db->insert('orders', $data); 
		$id = $this->db->insert_id(); //print_r($this->db->last_query());  exit;
		return $id;
	}
	function insert_product_supplier($data)
	{
		$this->db->insert('product_supplier', $data); 
		$id = $this->db->insert_id();
		return $id;
	}
	function update_product_supplier($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('product_supplier', $data);
		return true;
	}
	function confirm_order_payment($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('orders', $data);
		return true;
	}
	function submit_order($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('orders', $data);
		return true;
	}
	function update_product($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('products', $data);
		return true;
	}

	function delete_product($id)
	{
		$this->db->delete('products', array('id' => $id));
		return true;
	}
	function delete_order_product($id)
	{
		$this->db->delete('order_products', array('id' => $id));
		return true;
	}

	function delete_order($id)
	{
		$this->db->delete('orders', array('id' => $id));
		return true;
	}
	function delete_order_products($order_id)
	{
		$this->db->delete('order_products', array('order_id' => $order_id));
		return true;
	}
	function delete_product_supplier($id)
	{
		$this->db->delete('product_supplier', array('id' => $id));
		return true;
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
	
 //update product order price
  function set_order_price($id,$price)
	{
		$sql = "UPDATE ci_order_products SET price_per_unit='".$price."' WHERE id =".$id; 
		$query = $this->db->query($sql);
		return true;
	}
//update totalsalted
  function update_order_price($order_id,$sales_id,$total_cost)
	{
		 $sql = "UPDATE ci_orders SET total_cost='".$total_cost."', sales_confirm_date='".@date('Y-m-d')."',  sale_user_id='".$sales_id."', is_active='2' WHERE id =".$order_id; 
		$query = $this->db->query($sql);
		return true;
	}
	

}