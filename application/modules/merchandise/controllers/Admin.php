<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MX_Controller {
		
		var $template = array();
		
		function __construct()
		{
			
			parent::__construct();
			//$this->output->enable_profiler(true);
						
			$this->load->library('administration');
			$this->load->model('member_model');
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->template['module']	= 'merchandise';
			$this->template['admin']		= true;
			$this->_init();
		}
		
		function index()
		{
			//redirect('admin/member/listall');
			redirect('merchandise/admin/listall');
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
		
		function listall($start = 0, $limit = 10, $order = 'id') 
		{

			$where = array();
			
			
			if ($filter = $this->input->post('filter'))
			{
				//$where = array('first_name' => $filter, 'last_name' => $filter, 'ref_number' => $filter, 'email' => $filter);
				$where = array('name' => $filter, 'email' => $filter);

			}
			
			if ($this->input->post('sorting')){
			
			     $order=$this->input->post('sorting');
			}
			
			
			
			/*else{
			
			$this->input->post('sorting')
			
			}*/
			$this->template['merchandise'] = $this->member_model->get_users($where, array('limit' => $limit, 'start' => $start, 'order_by' => $order));
			$this->load->library('pagination');

			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			//$config['base_url'] = site_url('admin/member/listall');
			$config['base_url'] = site_url('merchandise/admin/listall');
			$config['total_rows'] = $this->member_model->member_total;
			$config['per_page'] = $limit; 
			


			$this->pagination->initialize($config); 

			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;
			
			$this->layout->load($this->template, 'admin');
			return;
		}
		
		
		function settings()
		{
			echo "Not Yet Implemented";
		}

		function packages()
		{

			$this->template['pack'] = $this->db->get('package')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'pack');
		}

		function addpackages()
		{
			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$anima = implode(',',$_POST['anima']);
				$price = $_POST['price'];
				$description = $_POST['description'];

				$this->db->insert('package', array('product_id'=>$productid, 'name'=>$name, 'pack_image'=>'1.jpg', 'pack_animations'=>$anima, 'price'=>$price, 'description'=>$description));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Package Added Successfully.');
					$this->layout->load($this->template, 'addpack');
				}else{
					$this->session->set_flashdata('notification', 'Package Insertion Failed.');
					$this->layout->load($this->template, 'addpack');
				}
			}else{
				$this->layout->load($this->template, 'addpack');
			}
			
		}

		function editpack($para)
		{

			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$anima = implode(',',$_POST['anima']);
				$price = $_POST['price'];
				$description = $_POST['description'];
				$this->db->trans_start();
				$this->db->where('id', $para);
				$this->db->update('package', array('product_id'=>$productid, 'name'=>$name, 'pack_image'=>'1.jpg', 'pack_animations'=>$anima, 'price'=>$price, 'description'=>$description));
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('notification', 'Package Edit Failed.');
					$this->template['pack'] = $this->db->get_where('package', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editpack');
				}else{
					$this->session->set_flashdata('notification', 'Package Edit Successfully.');
					$this->template['pack'] = $this->db->get_where('package', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editpack');
				} 
			}else{
				$this->template['pack'] = $this->db->get_where('package', array('id'=>$para))->row_array();
				$this->template['start'] = 0;
				$this->layout->load($this->template, 'editpack');
			}
		}

		function deletepack($para)
		{
			
			$this->db->where('id', $para);
			$this->db->delete('package');
			$this->session->set_flashdata('notification', 'Package Deleted Successfully.');
			redirect('merchandise/admin/packages', 'refresh');
		}

		function animations()
		{
			$this->template['animations'] = $this->db->get('animations')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'anima');
		}

		function addanimations()
		{
			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$type = $_POST['type'];
				$cate = $_POST['cate'];
				$price = $_POST['price'];

				$this->db->insert('animations', array('product_id'=>$productid, 'name'=>$name, 'ani_type'=>$type, 'ani_category'=>$cate, 'ani_image'=>'1.jpg', 'price'=>$price));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Animation Added Successfully.');
					$this->layout->load($this->template, 'addanima');
				}else{
					$this->session->set_flashdata('notification', 'Animation Insertion Failed.');
					$this->layout->load($this->template, 'addanima');
				}
			}else{
				$this->layout->load($this->template, 'addanima');
			}
			
		}

		function editanimations($para)
		{

			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$type = $_POST['type'];
				$cate = $_POST['cate'];
				$price = $_POST['price'];
				$this->db->trans_start();
				$this->db->where('id', $para);
				$this->db->update('animations', array('product_id'=>$productid, 'name'=>$name, 'ani_type'=>$type, 'ani_category'=>$cate, 'ani_image'=>'1.jpg', 'price'=>$price));
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('notification', 'Animation Edit Failed.');
					$this->template['pack'] = $this->db->get_where('animations', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editanima');
				}else{
					$this->session->set_flashdata('notification', 'Animation Edit Successfully.');
					$this->template['pack'] = $this->db->get_where('animations', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editanima');
				} 
			}else{
				$this->template['pack'] = $this->db->get_where('animations', array('id'=>$para))->row_array();
				$this->template['start'] = 0;
				$this->layout->load($this->template, 'editanima');
			}
		}

		function deleteanimations($para)
		{
			
			$this->db->where('id', $para);
			$this->db->delete('animations');
			$this->session->set_flashdata('notification', 'Animation Deleted Successfully.');
			redirect('merchandise/admin/animations', 'refresh');
		}

		function gifts()
		{
			$this->template['gifts'] = $this->db->get('gifts')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'gifts');
		}

		function addgifts()
		{
			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$type = $_POST['type'];
				$cate = $_POST['cate'];
				$price = $_POST['price'];

				$this->db->insert('gifts', array('product_id'=>$productid, 'name'=>$name, 'category'=>$cate, 'type'=>$type, 'image'=>'1.jpg', 'price'=>$price));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Gift Added Successfully.');
					$this->layout->load($this->template, 'addgifts');
				}else{
					$this->session->set_flashdata('notification', 'Gift Insertion Failed.');
					$this->layout->load($this->template, 'addgifts');
				}
			}else{
				$this->layout->load($this->template, 'addgifts');
			}
			
		}

		function editgifts($para)
		{

			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$type = $_POST['type'];
				$cate = $_POST['cate'];
				$price = $_POST['price'];
				$this->db->trans_start();
				$this->db->where('id', $para);
				$this->db->update('gifts', array('product_id'=>$productid, 'name'=>$name, 'category'=>$cate, 'type'=>$type, 'image'=>'1.jpg', 'price'=>$price));
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('notification', 'Gift Edit Failed.');
					$this->template['pack'] = $this->db->get_where('gifts', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editgifts');
				}else{
					$this->session->set_flashdata('notification', 'Gift Edit Successfully.');
					$this->template['pack'] = $this->db->get_where('gifts', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editgifts');
				} 
			}else{
				$this->template['pack'] = $this->db->get_where('gifts', array('id'=>$para))->row_array();
				$this->template['start'] = 0;
				$this->layout->load($this->template, 'editgifts');
			}
		}

		function deletegifts($para)
		{
			
			$this->db->where('id', $para);
			$this->db->delete('gifts');
			$this->session->set_flashdata('notification', 'Gift Deleted Successfully.');
			redirect('merchandise/admin/gifts', 'refresh');
		}

		function geotags()
		{
			$this->template['geotag'] = $this->db->get('geotag')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'geotag');
		}

		function addgeotags()
		{
			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$price = $_POST['price'];

				$this->db->insert('geotag', array('product_id'=>$productid, 'name'=>$name, 'price'=>$price));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Plan Added Successfully.');
					$this->layout->load($this->template, 'addgeotags');
				}else{
					$this->session->set_flashdata('notification', 'Plan Insertion Failed.');
					$this->layout->load($this->template, 'addgeotags');
				}
			}else{
				$this->layout->load($this->template, 'addgeotags');
			}
			
		}

		function editgeotags($para)
		{

			if(isset($_POST) && isset($_POST['prodsub'])){
				$productid = $_POST['productid'];
				$name = $_POST['name'];
				$price = $_POST['price'];
				$this->db->trans_start();
				$this->db->where('id', $para);
				$this->db->update('geotag', array('product_id'=>$productid, 'name'=>$name, 'price'=>$price));
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('notification', 'Plan Edit Failed.');
					$this->template['pack'] = $this->db->get_where('geotag', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editgeotags');
				}else{
					$this->session->set_flashdata('notification', 'Plan Edit Successfully.');
					$this->template['pack'] = $this->db->get_where('geotag', array('id'=>$para))->row_array();
					$this->template['start'] = 0;
					$this->layout->load($this->template, 'editgeotags');
				} 
			}else{
				$this->template['pack'] = $this->db->get_where('geotag', array('id'=>$para))->row_array();
				$this->template['start'] = 0;
				$this->layout->load($this->template, 'editgeotags');
			}
		}

		function deletegeotags($para)
		{
			
			$this->db->where('id', $para);
			$this->db->delete('geotag');
			$this->session->set_flashdata('notification', 'Geotag Deleted Successfully.');
			redirect('merchandise/admin/geotags', 'refresh');
		}

		function payments()
		{
			$this->template['purchase'] = $this->db->get('purchase')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'purchase');
		}
		
		function save()
		{
			echo "Not Yet Implemented";
		}
		
		function create()
		{
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			
			//$this->form_validation->set_rules('username',__('Username', $this->template['module']),"trim|required|min_length[4]|max_length[12]|callback__verify_username");
			$this->form_validation->set_rules('first_name','First Name',"trim|required");
			$this->form_validation->set_rules('last_name','Last Name',"trim|required");
			$this->form_validation->set_rules('email', "Email","trim|required|valid_email|callback__verify_mail");	
			$this->form_validation->set_rules('password','Password',"trim|required");
			
			
			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
						
			if ($this->form_validation->run() == FALSE)
			{
				$this->layout->load($this->template, 'create');
			}
			else
			{
		
					  $data = array(

									'first_name' => $this->input->post('first_name'),
									'last_name' => $this->input->post('last_name'),
									'password' => $this->user->_prep_password($this->input->post('password')),
									'email' => $this->input->post('email'),
									'registered' => time()
								);
					   $this->member_model->insert_user($data);
					   $this->session->set_flashdata('notification', "User registered");
					   redirect('member/admin/listall');
				   
				
			}

		}

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
		
		function deleteuser($user_id)
		{
			if ($user_id > 0)
			{
				//$this->member_model->delete_user($user_id);
				$this->db->delete('users', array('id' => $user_id));
				//$data = array('is_delete' => 1, 'status' => 'disabled');
				//$this->member_model->update_user($user_id, $data);
				$this->session->set_flashdata("notification", "User deleted");
				//redirect("admin/member/listall");
				redirect("member/admin/listall");
			}
			else
			{
				$this->session->set_flashdata("notification", "User does not exist.");
				redirect("member/admin/listall");
				//redirect("admin/member/listall");
			}
						
		}

		function delete($username = null, $confirm = 0)
		{

			$this->user->check_level('member', LEVEL_DEL);
			if (is_null($username))
			{
				$this->session->set_flashdata("notification", "Username and status required");
				//redirect("admin/member/listall");
				redirect("member/admin/listall");
			}
			
			if ($username == $this->session->userdata("username"))
			{
				$this->session->set_flashdata("notification", "You cannot remove yourself");
				//redirect("admin/member/listall");
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
				//redirect("admin/member/listall");
				redirect("member/admin/listall");
			}
			

			
		}
		
		function status($user_id = null, $fromstatus = null)
		{
			if (is_null($user_id) || is_null($fromstatus))
			{
				$this->session->set_flashdata("notification", "User Id and status required");
				//redirect("admin/member/listall");
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
			//redirect("admin/member/listall");
			redirect("member/admin/listall");
			
			
		}
		function edit($user_id = null) 
		{
			
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
						
			/* $this->form_validation->set_rules('first_name',__('First Name', $this->template['module']),"trim|required");
			$this->form_validation->set_rules('last_name',__('Last Name', $this->template['module']),"trim|required"); */

			$this->form_validation->set_rules('name','Name',"trim|required");

			$this->form_validation->set_rules('email',"Email","trim|required|valid_email");	
		
			
			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
			
			if ( $user_id == 0 || $user_id == '' )
			{
				$this->session->set_flashdata("notification", "This member doesn't exist");
				redirect("admin/member/listall");
			}
			$this->template['user_id'] = $user_id;			
			if ($this->template['member'] = $this->member_model->get_user_by_id($user_id))
			{
				
						
				if ($this->form_validation->run() == FALSE)
				{	 
					$this->layout->load($this->template, 'edit');
				}
				else
				{
					$data = array(
							'name' => $this->input->post('name'),
							//'last_name' => $this->input->post('last_name'),
							'email' => $this->input->post('email'),
							'status' => $this->input->post('status')
							);
					$this->member_model->update_user($user_id, $data);

					
					$this->session->set_flashdata('notification', "User saved");
					//redirect('admin/member/listall');
					redirect("member/admin/listall");
				}
			}
			else 
			{
				$this->session->set_flashdata("notification", "This member doesn't exist");
				//redirect("admin/member/listall");
				redirect("member/admin/listall");
			}				

		}


	// ------------------------------------------------------------------------
	
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
			//$password = $this->input->post('password');
			//$username = $this->input->post('username');
			
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