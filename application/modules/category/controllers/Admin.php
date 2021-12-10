<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Admin extends MX_Controller {
		
		var $template = array();
		
		function __construct()
		{
			
			parent::__construct();
			//$this->output->enable_profiler(true);
			
			$this->load->library('administration');
			$this->load->model('category_model');
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->template['module']	= 'category';
			$this->template['admin']	= true;
			$this->_init();
		}
		
		function index()
		{
			redirect('category/admin/listall');
		}
		
		function _init() 
		{
			/*
				* default values
			*/
			if (!isset($this->system->login_signup_enabled)) 
			{
				$this->system->login_signup_enabled = 1;
			}
			
		}
		
		function listall($start = 0, $limit = 20, $order = 'id') 
		{
			$where = array();
			
			
			if ($filter = $this->input->post('filter'))
			{
				$where = array('category' => $filter, 'is_active' => $filter);
			}
			
			if ($this->input->post('sorting')){
				
				$order=$this->input->post('sorting');
			}
			
			/*else{
				
				$this->input->post('sorting')
				
			}*/
			$this->template['categories'] = $this->category_model->get_categories($where, array('start' => $start, 'order_by' => $order));
			//echo "<pre>"; print_r($this->template['categories']); exit;
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('category/admin/listall');
			$config['total_rows'] = $this->category_model->category_total;
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;			
			$this->layout->load($this->template, 'admin');
			return;
		}
		function orderattributes($start = 0, $limit = 20, $order = 'id') 
		{
			$where = array();
			
			if ($filter = $this->input->post('filter'))
			{
				$where = array('category' => $filter, 'is_active' => $filter);
			}
			
			if ($this->input->post('sorting')){
				
				$order=$this->input->post('sorting');
			}
			
			/*else{
				
				$this->input->post('sorting')
				
			}*/
			$this->template['attributes'] = $this->category_model->get_orderattributes($where, array('start' => $start, 'order_by' => $order));
			//echo "<pre>"; print_r($this->template['categories']); exit;
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('category/admin/orderattributes');
			$config['total_rows'] = $this->category_model->orderattributes_total;
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;			
			$this->layout->load($this->template, 'orderattributes');
			return;
		}
		
		
		function orderlist($start = 0, $limit = 20, $order = 'id') 
		{
			$where = array();
			
			
			if ($filter = $this->input->post('filter'))
			{
				$where = array('category' => $filter, 'is_active' => $filter);
			}
			
			if ($this->input->post('sorting')){
				
				$order=$this->input->post('sorting');
			}
			
			/*else{
				
				$this->input->post('sorting')
				
			}*/
			$this->template['orders'] = $this->category_model->get_order($where, array('start' => $start, 'order_by' => $order));
			//echo "<pre>"; print_r($this->template['categories']); exit;
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('category/admin/listall');
			$config['total_rows'] = $this->category_model->category_total;
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;			
			$this->layout->load($this->template, 'orderlist');
			return;
		}
	function orderdetail($order_id=null)
	{
		
	
				$this->template['order_id'] = $order_id;
				$this->template['order'] = $this->category_model->get_order_by_id($order_id); 
			
				if(isset($this->template['order'][0]['id']))
				{ 
				    $this->template['columnname'] = $this->category_model->get_order_columnname();
					$this->template['products'] = $this->category_model->get_order_product($order_id); 
					$this->layout->load($this->template, 'orderdetail');
				}else{
					$this->session->set_flashdata('notification',"Something went wrong, as we lost this order data.");
					
				}
			
		
	}	
		
		function settings()
		{
			echo "Not Yet Implemented";
		}
		
		function save()
		{
			echo "Not Yet Implemented";
		}
		
		function createattribute()
		{
			$this->template['user_roles'] = $this->category_model->get_user_roles();
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'category';
			
			$this->form_validation->set_rules('attribute_name','Attribute Name',"trim|required");
			//$this->form_validation->set_rules('roles','Roles',"trim|required");

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			
			if ($this->form_validation->run() == FALSE)
			{	
				$this->layout->load($this->template, 'createattribute'); 
			}
			else
			{
				//check if attribute already exist
				if ($this->category_model->attributeexists(array('attribute_name' => $this->input->post('attribute_name'))))
				{	
					$this->session->set_flashdata('notification', "We already have this attribute in our database.");
					$this->layout->load($this->template, 'createattribute'); 
					return FALSE;
				}
				$roles = $this->input->post('roles');
				$user_roles = "";
				for($i=0;$i<count($roles);$i++) 
				{
					$user_roles = $user_roles.$roles[$i].",";
				}
				//echo $user_roles; exit;
				$attributename = $this->input->post('attribute_name');
				$data = array(
				'attribute_name' => $this->input->post('attribute_name'),
				'permit_user_type' => $user_roles,
				'is_active' => 1,
				'date_created' => date('Y-m-d')
				);
				$this->category_model->insert_attribute($data);
				$fields = array(
					$attributename => array(
							'type' => 'VARCHAR',
							'constraint' => '200',
					),
					);
				$this->load->dbforge();
				$this->dbforge->add_column('orders', $fields);
				$this->session->set_flashdata('notification', "Attribute added successfully !");
				redirect('category/admin/orderattributes');
				
				
			}			
		}
		function editattribute($id)
		{
			$this->template['user_roles'] = $this->category_model->get_user_roles();
			$this->template['attribute'] = $this->category_model->get_attribute_by_id($id);
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'category';
			
			$this->form_validation->set_rules('attribute_name','Attribute Name',"trim|required");
			//$this->form_validation->set_rules('roles','Roles',"trim|required");

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			
			if ($this->form_validation->run() == FALSE)
			{	
				$this->layout->load($this->template, 'editattribute'); 
			}
			else
			{
				//check if attribute already exist
				if ($this->category_model->attributeexists(array('attribute_name' => $this->input->post('attribute_name'))))
				{	
					$this->session->set_flashdata('notification', "We already have this attribute in our database.");
					$this->layout->load($this->template, 'editattribute'); 
					return FALSE;
				}
				$roles = $this->input->post('roles');
				$user_roles = "";
				for($i=0;$i<count($roles);$i++) 
				{
					$user_roles = $user_roles.$roles[$i].",";
				}
				//echo $user_roles; exit;
				$attributename = $this->input->post('attribute_name');
				$oldname = $this->template['attribute']['attribute_name'];
				$data = array(
				'attribute_name' => $this->input->post('attribute_name'),
				'permit_user_type' => $user_roles,
				'is_active' => 1,
				'date_created' => date('Y-m-d')
				);
				$this->category_model->update_attribute($id,$data);
				$fields = array(
					$oldname => array(
							'name' => $attributename,
							'type' => 'VARCHAR',
							'constraint' => '200',
					),
					);
				$this->load->dbforge();
				$this->dbforge->modify_column('orders', $fields);
				$this->session->set_flashdata('notification', "Attribute added successfully !");
				redirect('category/admin/orderattributes');
				
				
			}			
		}
		function deleteattribute($id)
		{
			$attribute = $this->category_model->get_attribute_by_id($id);
			//echo "<pre>"; print_r($attribute); exit;
			if($attribute['id'] > 0)
			{
				$this->load->dbforge();
				$this->dbforge->drop_column('orders', $attribute['attribute_name']);
				$this->db->delete('order_attributes', array('id' => $id));

				$this->session->set_flashdata('notification', "Attribute deleted successfully !");
			}else{
				$this->session->set_flashdata('notification', "No such attribute.");
			}
			redirect('category/admin/orderattributes');
		}
		
		function create()
		{ 
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'category';
			$this->form_validation->set_rules('category','Category',"trim|required");
			

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			
			if ($this->form_validation->run() == FALSE)
			{	
				$this->layout->load($this->template, 'create'); 
			}
			else
			{
				//check if email belongs to someone else
				if ($this->category_model->exists(array('category' => $this->input->post('category'))))
				{	
					$this->session->set_flashdata('notification', "We already have this category in our database.");
					$this->layout->load($this->template, 'create'); 
					return FALSE;
				}
				
				$data = array(
				'category' => $this->input->post('category'),
				'is_active' => $this->input->post('status'),
				'date_created' => date('Y-m-d')
				
				);
				$this->category_model->insert_category($data);
				$this->session->set_flashdata('notification', "Category added successfully !");
				redirect('category/admin/listall');
				
				
			}
		}

		function edit($category_id = null) 
		{
			
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'category';
			$this->form_validation->set_rules('category','Category',"trim|required");
			

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			
			if ( $category_id == 0 || $category_id == '' )
			{
				$this->session->set_flashdata("notification", "This category doesn't exist");
				redirect("admin/category/listall");
			}
			$this->template['category_id'] = $category_id;			
			if ($this->template['category'] = $this->category_model->get_category_by_id($category_id))
			{				
				if ($this->form_validation->run() == FALSE)
				{	 
					$this->layout->load($this->template, 'edit');
				}
				else
				{
					$data = array(
					'category' => $this->input->post('category'),
					'is_active' => $this->input->post('status')
					); 
					$this->category_model->update_category($category_id, $data);	
					
					$this->session->set_flashdata('notification', "Category saved");
					redirect("category/admin/listall");
				}
			}
			else 
			{
				$this->session->set_flashdata("notification", "This category doesn't exist");
				redirect("category/admin/listall");
			}				
		}
		// ------------------------------------------------------------------------

		function _verify_username($data)
		{
			$username = $this->input->post('username');
			
			//check if email belongs to someone else
			if ($this->member_model->exists(array('username' => $username)))
			{
				$this->validation->set_message('_verify_username', "The username is already in use");
				return FALSE;
			}
		}		
		
		function profile($username = null) 
		{
			if ( is_null($username) )
			{
				$username = $this->session->userdata("username");
			}
			
			if ($this->member_model->exists("username = '$username'"))
			{
				echo "exist";
			}
			else 
			{
				$this->session->set_flashdata("notification", "This member doesn't exist");
				redirect("member/admin/listall");
			}
			
		}
		
		function deletecategory($category_id)
		{
			if ($category_id > 0)
			{
				$this->db->delete('product_category', array('id' => $category_id));
				$this->session->set_flashdata("notification", "Category deleted");
				redirect("category/admin/listall");
			}
			else
			{
				$this->session->set_flashdata("notification", "Category does not exist.");
				redirect("category/admin/listall");
			}
			
		}
		
		
		
		function veifyaccount($user_id=NULL)
		{
			if ($user_id > 0 )
			{
				
				$userdata=$this->member_model->get_user_by_id($user_id);
				
				if(isset($userdata['verified']) && ($userdata['verified'] ==0)){
					$data = array('verified' => 1);
					}else{
					$data = array('verified' => 0);
					
				}
				
				$this->member_model->update_user($user_id, $data);				
				$this->session->set_flashdata("notification", "User updated successfully");
				redirect("member/admin/listall");
			}
			else
			{
				$this->session->set_flashdata("notification", "User does not exist.");
				redirect("member/admin/listall");
			}
			
		}
		
		
		function delete($username = null, $confirm = 0)
		{
			$this->user->check_level('member', LEVEL_DEL);
			if (is_null($username))
			{
				$this->session->set_flashdata("notification", "Username and status required");
				redirect("member/admin/listall");
			}
			
			if ($username == $this->session->userdata("username"))
			{
				$this->session->set_flashdata("notification", "You cannot remove yourself");
				redirect("member/admin/listall");
				
			}
			
			if($confirm == 0)
			{
				$this->template['username'] = $username;
				$this->layout->load($this->template, 'delete');
			}
			else
			{
				$this->db->delete('users', array('username' => $username));
				$this->plugin->do_action('member_delete', $username);
				$this->session->set_flashdata("notification", "User deleted");
				redirect("member/admin/listall");
			}
			
			
		}
		
		function status($user_id = null, $fromstatus = null)
		{
			if (is_null($user_id) || is_null($fromstatus))
			{
				$this->session->set_flashdata("notification", "User Id and status required");
				redirect("member/admin/listall");
			}
			
			if ($fromstatus == 'active') 
			{
				$data['status'] = 'disabled';
			}
			else
			{
				$data['status'] = 'active';
			}
			$this->member_model->update_user($user_id, $data);
			$this->session->set_flashdata("notification", __("User status updated", $this->template['module']));
			redirect("member/admin/listall");
			
			
		}
		
		
		/**
			* Registration validation callback
			*
			
			* @access	private
			* @param	string
			* @return	bool
		*/
		function _verify_mail($data)
		{
			$email = $this->input->post('email');
			//check if email belongs to someone else
			if ($this->member_model->exists(array('email' => $email))) //_verify_mail
			{
				$this->form_validation->set_message('_verify_mail', "The email is already in use");
				//$this->form_validation->set_message('verify_mail', "The email is already in use.");
				return FALSE;
			}
		}		
		
		
	}
	
?>