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
			
			$this->template['module']	= 'member';
			$this->template['admin']		= true;
			$this->_init();
		}
		
		function index()
		{
			//redirect('admin/member/listall');
			redirect('member/admin/listall');
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
			
			
			
			
			if ($this->input->post('sorting')){
				
				$order=$this->input->post('sorting');
			}
			
			//for searching
			  $mfilter='';
				if(isset($_POST['mfilter']))
				{ 
					if($this->input->post('mfilter'))
					{
						$mfilter = $this->input->post('mfilter');
						$_SESSION['mfilter'] = $mfilter;
					}else{
						$mfilter = '';
						$_SESSION['mfilter'] = '';
					}
				}else
				{ 
					if(isset($_SESSION['mfilter']) && $_SESSION['mfilter'] != ''){ 
					$mfilter = $_SESSION['mfilter'];
					}else{ 
						$mfilter = '';
						$_SESSION['mfilter'] = '';
					}
				} 
				$this->template['mfilter'] = $mfilter; 
			
			if ($this->template['mfilter'] !='')
			{
				//$where = array('first_name' => $filter, 'last_name' => $filter, 'ref_number' => $filter, 'email' => $filter);
				$where = array('fname' => $mfilter, 'lname' => $mfilter,'phone' => $mfilter, 'email' => $mfilter);
			}
			
			$this->template['members'] = $this->member_model->get_users($mfilter, array('start' => $start,'limit' => $limit, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/admin/listall');
			$config['total_rows'] = $this->member_model->get_total($mfilter);
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
		
		function save()
		{
			echo "Not Yet Implemented";
		}
		
		
		function create()
		{ 
			$this->template['user_roles'] = $this->member_model->get_user_roles();
			
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'member';
			//$this->form_validation->set_rules('username',__('Username', $this->template['module']),"trim|required|min_length[4]|max_length[12]|callback__verify_username");
			$this->form_validation->set_rules('name','First Name',"trim|required");
			$this->form_validation->set_rules('lname','Last Name',"trim|required");
			$this->form_validation->set_rules('uniq_id','User ID',"trim|required"); //|callback__verify_userid
			$this->form_validation->set_rules('email', "Email","trim|required|valid_email");	//|callback__verify_mail
			//$this->form_validation->set_rules('roles[]','Roles',"trim|required");
			$this->form_validation->set_rules('role','Role',"trim|required");
			//$this->form_validation->set_rules('password','Password',"trim|required");

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');	
			$this->form_validation->set_message('callback__verify_userid', "The User ID is already in use");		
			
			if ($this->form_validation->run() == FALSE)
			{	
				$this->layout->load($this->template, 'create'); 
			}
			else
			{
				//check if email belongs to someone else
				if ($this->member_model->exists(array('uniq_id' => $this->input->post('uniq_id'))))
				{	
					$this->session->set_flashdata('notification', "We already have this User id in our database.");
					$this->layout->load($this->template, 'create'); 
					return FALSE;
				}
				if ($this->member_model->exists(array('email' => $this->input->post('email'))))
				{	
					$this->session->set_flashdata('notification', "We already have this email address in our database.");
					$this->layout->load($this->template, 'create'); 
					return FALSE;
				}
				$passkey = $this->input->post('name').'@123';
				$data = array(
				'fname' => $this->input->post('name'),
				'lname' => $this->input->post('lname'),
				'uniq_id' => $this->input->post('uniq_id'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'type_id' => $this->input->post('role'),
				'password' => $this->user->_prep_password($passkey),
				'is_active' => $this->input->post('status')
				
				);
				$user_id = $this->member_model->insert_user($data);
				/* $roles = $this->input->post('roles');
				for($i=0;$i<count($roles);$i++) 
				{
					$role_data = array(
						'user_id' => $user_id,
						'type_id' => $roles[$i],
						'date_created' => date('Y-m-d')
					);
					$this->member_model->insert_user_role($role_data);
				}	*/
				$this->session->set_flashdata('notification', "User registered successfully !");
				redirect('member/admin/listall');
				
				
			}
		}

		function edit($user_id = null) 
		{
			$this->template['user_roles'] = $this->member_model->get_user_roles();

			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'member';
			//$this->form_validation->set_rules('username',__('Username', $this->template['module']),"trim|required|min_length[4]|max_length[12]|callback__verify_username");
			$this->form_validation->set_rules('name','First Name',"trim|required");
			$this->form_validation->set_rules('lname','Last Name',"trim|required");
			//$this->form_validation->set_rules('uniq_id','User ID',"trim|required");
			$this->form_validation->set_rules('email', "Email","trim|required|valid_email");	//|callback__verify_mail
			$this->form_validation->set_rules('role','Role',"trim|required");
			//$this->form_validation->set_rules('password','Password',"trim|required");

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
				$roles = $this->member_model->get_user_roles_by_id($user_id);
				$assigned_roles = array();
				for($j=0;$j<count($roles);$j++)
				{
					$assigned_roles[] = $roles[$j]['type_id'];
				}
				$this->template['roles'] = $assigned_roles;
				//echo "<pre>"; print_r($this->template['roles']); exit;
				if ($this->form_validation->run() == FALSE)
				{	 
					$this->layout->load($this->template, 'edit');
				}
				else
				{
					if ($this->member_model->exists(array('uniq_id' => $this->input->post('uniq_id'), 'id !=' => $user_id)))
					{	
						$this->session->set_flashdata('notification', "We already have this User id in our database.");
						$this->layout->load($this->template, 'edit'); 
						return FALSE;
					}
					if ($this->member_model->exists(array('email' => $this->input->post('email'), 'id !=' => $user_id)))
					{	
						$this->session->set_flashdata('notification', "We already have this email address in our database.");
						$this->layout->load($this->template, 'edit'); 
						return FALSE;
					}

					$data = array(
					'fname' => $this->input->post('name'),
					'lname' => $this->input->post('lname'),
					'uniq_id' => $this->input->post('uniq_id'),
					'phone' => $this->input->post('phone'),
					'type_id' => $this->input->post('role'),
					'email' => $this->input->post('email'),
					'is_active' => $this->input->post('status'),  
					'modified_date' => date('Y-m-d H:i:s')
					);
					$this->member_model->update_user($user_id, $data);	
					/*
					$roles = $this->input->post('roles');
					$this->db->delete('user_roles', array('user_id' => $user_id));
					for($i=0;$i<count($roles);$i++) 
					{
						$role_data = array(
							'user_id' => $user_id,
							'type_id' => $roles[$i],
							'date_created' => date('Y-m-d')
						);
						$this->member_model->insert_user_role($role_data);
					}	*/
					
					$this->session->set_flashdata('notification', "User saved");
					redirect("member/admin/listall");
				}
			}
			else 
			{
				$this->session->set_flashdata("notification", "This member doesn't exist");
				redirect("member/admin/listall");
			}				
		}
		
function admincustomerlist()
	{
		  $this->template['customers'] = $this->member_model->get_customers();
		  $this->layout->load($this->template, 'admincustomerlist');
	}		
		

//------------------------------------------------------------------------

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
				$this->db->delete('users', array('id' => $user_id));
				$this->db->delete('user_roles', array('user_id' => $user_id));
				$this->session->set_flashdata("notification", "User deleted");
				redirect("member/admin/listall");
			}
			else
			{
				$this->session->set_flashdata("notification", "User does not exist.");
				redirect("member/admin/listall");
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
		
	function brandlist($start = 0, $limit = 20, $order = 'id')
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
			$this->template['brands'] = $this->member_model->get_admin_brands($where, array('start' => $start, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/admin/brandlist');
			//$config['total_rows'] = $this->member_model->member_total;
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;			
			$this->layout->load($this->template, 'brandlist');
			return;
			
	}
	
   function addadminbrand()
	      {
        		    $this->load->library('form_validation');
					$this->form_validation->CI =& $this; 
					$this->template['module']	= 'member';
					$this->form_validation->set_rules('name','Brand name',"trim|required");
					$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
					$this->form_validation->set_message('required', 'The %s field is required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$this->layout->load($this->template, 'addadminbrand');
					}
					else
					{
						//check if email belongs to someone else
							if ($this->member_model->brand_exists(array('name' => $this->input->post('name'))))
							{	
								$this->session->set_flashdata('notification', "We already have this brand in our database.");
								$this->layout->load($this->template, 'addadminbrand'); 
								return FALSE;
							}
							$allowed_types = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');       
							$fileType = $_FILES['logo']['type'];
							$type=explode('/', $fileType);
							if (in_array($fileType, $allowed_types)) 
							{
									$name = uniqid();
									$findExt = explode(".",$_FILES['logo']['name']);
									$ext = $findExt[count($findExt)-1];	
									$imgname = $name.'.'.$ext;
									$filename = FCPATH.'/media/brandorg/'.$imgname;										
									@chmod($filename , 777);
									copy($_FILES['logo']['tmp_name'], $filename);
									$targetPath = FCPATH.'/media/brand/'.$imgname;
									$this->createThumbnail($_FILES['logo']['tmp_name'], $targetPath, 300 ,$ext, 300);		

									$data = array(
													'name' => $this->input->post('name'),
													'logo' => $imgname,
													'added_by' => 1,
													'is_active' => 1,
													'date_created' => date("Y-m-d")
												);

										$brand_id = $this->member_model->insert_brand($data);
										$this->session->set_flashdata('notification', "Brand added successfully !");
										redirect('member/admin/brandlist');
							}else{
								$this->session->set_flashdata('notification', "Please upload logo image of the correct file type.");
								$this->layout->load($this->template, 'addadminbrand'); 
								return FALSE;
							} 
					}
				
		
	}

	function editadminbrand($brand_id=null)
	{
		
			$this->template['brand_id'] = $brand_id;
			if ($this->template['brand'] = $this->member_model->get_brand_by_id($brand_id))
			{
			
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this; 
				$this->template['module']	= 'member';
				$this->form_validation->set_rules('name','Brand name',"trim|required");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'editadminbrand');
				}
				else
				{		
	
							$allowed_types = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');   
							if($_FILES['logo']['name'] != "" && $_FILES['logo']['tmp_name'] != "")
							{    
								$fileType = $_FILES['logo']['type'];
								$type=explode('/', $fileType);
								if (in_array($fileType, $allowed_types)) 
								{
										$name = uniqid();
										$findExt = explode(".",$_FILES['logo']['name']);
										$ext = $findExt[count($findExt)-1];	
										$imgname = $name.'.'.$ext;
										$filename = FCPATH.'/media/brandorg/'.$imgname;										
										@chmod($filename , 777);
										copy($_FILES['logo']['tmp_name'], $filename);
										$targetPath = FCPATH.'/media/brand/'.$imgname;
										$oldfile = FCPATH.'/media/brand/'.$this->template['brand']['logo'];
										$realfile = FCPATH.'/media/brandorg/'.$this->template['brand']['logo'];
										$this->createThumbnail($_FILES['logo']['tmp_name'], $targetPath, 300 ,$ext, 300);	
										unlink($oldfile);
										unlink($realfile);		
										
								}else{
									$this->session->set_flashdata('notification', "Please upload logo image of the correct file type.");
									$this->layout->load($this->template, 'editadminbrand'); 
									return FALSE;
								} 
							}else{ 
							     $imgname= $this->template['brand']['logo'];
							 }
							$data = array(
								'name' => $this->input->post('name'),
								'logo' => $imgname,
								'is_active' => $this->input->post('status')
								);
							$this->member_model->update_brand($brand_id, $data);
							$this->session->set_flashdata('notification', "Brand updated successfully !");
							redirect('member/admin/brandlist');

				}
			

		}else{
			$this->session->set_flashdata("notification", "This brand doesn't exist");
			redirect('member/admin/brandlist');
		}
	
    }	
	
function deletebrand($id)
		{
			if ($id > 0)
			{
				$branddata=$this->member_model->get_brand_by_id($id);
				$oldfile = FCPATH.'/media/brand/'.$branddata['logo'];
				$realfile = FCPATH.'/media/brandorg/'.$branddata['logo'];
				unlink($oldfile);
				unlink($realfile);
				
				$this->db->delete('product_brands', array('id' => $id));	
				 
				$this->session->set_flashdata("notification", "Brand deleted");
				redirect('member/admin/brandlist');
			}
			else
			{
				$this->session->set_flashdata("notification","Brand does not exist.");
				redirect('member/admin/brandlist');
			}
						
		}	
	
	
function createThumbnail($sourcePath, $thumbDirectory, $thumbWidth , $ext)
{  	
			if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg")
			{ 
				$srcImg = imagecreatefromjpeg($sourcePath); 
				$origWidth = imagesx($srcImg);
				$origHeight = imagesy($srcImg);
				$ratio = $origWidth / $thumbWidth;
				$thumbHeight = $origHeight/$ratio;			   
				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
				//imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, imagesx($thumbImg), imagesy($thumbImg));
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagejpeg($thumbImg, $thumbDirectory);
			}
			else if(strtolower($ext) == "png")
			{  
			    $srcImg = imagecreatefrompng($sourcePath);
				$origWidth = imagesx($srcImg);
				$origHeight = imagesy($srcImg);
				$ratio = $origWidth / $thumbWidth;
				$thumbHeight = $origHeight/$ratio; 
				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight); 
				$this->setTransparency($thumbImg,$srcImg); 
				imagealphablending($thumbImg, false); 
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagesavealpha($thumbImg, true); 
				imagepng($thumbImg, $thumbDirectory); 
			}
			else if(strtolower($ext) == "gif")
			{ 
				$srcImg = imagecreatefromgif($sourcePath); 
				$origWidth = imagesx($srcImg);
				$origHeight = imagesy($srcImg);
				$ratio = $origWidth / $thumbWidth;
				$thumbHeight = $origHeight/$ratio;			   
				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);				
				//imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, imagesx($thumbImg), imagesy($thumbImg));
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagegif($thumbImg, $thumbDirectory); 
			}else{ 	
			}			
} 	

function setTransparency($new_image,$image_source)
{
		$transparencyIndex = imagecolortransparent($image_source);
		$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
		if ($transparencyIndex >= 0) {
				$transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);   
		}
		$transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
		imagefill($new_image, 0, 0, $transparencyIndex);
			imagecolortransparent($new_image, $transparencyIndex);
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

		function _verify_userid($data)
		{
			$uniq_id = $this->input->post('uniq_id');
			//check if email belongs to someone else
			if ($this->member_model->exists(array('email' => $uniq_id))) //_verify_mail
			{
				$this->form_validation->set_message('_verify_userid', "The User ID is already in use");
				//$this->form_validation->set_message('verify_mail', "The email is already in use.");
				return FALSE;
			}
		}	
		
		
	}
	
?>
