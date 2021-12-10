<?php    if (!defined('BASEPATH')) exit('No direct script access allowed');
class Member extends MX_Controller {
	var $template = array();
	function __construct()
	{
		parent::__construct();
		$this->template['module']	= 'member';
		$this->load->model('member_model');
		$this->_init();
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
	function _member_signup_header()
	{
		echo '<script src="' .  base_url() . 'application/views/' . $this->system->theme . '/javascript/jquery.validate.pack.js" type="text/javascript"></script>';
	}
function signup() {

		 $this->load->library('form_validation');
		 $this->form_validation->CI =& $this;		 
		 $this->template['roles']  = $this->member_model->get_user_roles();		 
		
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('advertiser/listads');
		}
		
				$this->form_validation->set_rules('first_name','First Name',"trim|required");
				$this->form_validation->set_rules('last_name','last Name',"trim|required");
				$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
				$this->form_validation->set_rules('phone','Phone',"trim|required");
				$this->form_validation->set_rules('type','Role',"trim|required");
				$this->form_validation->set_rules('password','Password',"trim|matches[passconf]|required");
				$this->form_validation->set_rules('passconf', "Confirm", "trim");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('min_length', 'The %s field is required');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');
				if ($this->form_validation->run() == FALSE)
				{	
					$this->layout->load($this->template, 'signup'); 
				}
				else
				{
					 $email=$this->input->post('email');
					 
					 if ($this->member_model->exists(array('email' => $email)))
				     {
					      $this->session->set_flashdata('notification', "User Already exist, Please try with another email");
					      redirect('member/signup');
				     }
					 else{
					     //Upload company Logo
				            $type=$this->input->post('type');
							if($type ==4 || $type==8){
							    $is_active=1;
							}else{
							    $is_active=0;
							}
							$data = array(
										'fname' => $this->input->post('first_name'),
										'lname ' => $this->input->post('last_name'),
										'email' => $this->input->post('email'),
										'type_id' => $this->input->post('type'),
										'phone' => $this->input->post('phone'),
										'uniq_id' => uniqid(),  
										'password' => $this->user->_prep_password($this->input->post('password')),
										'status' => 'active',
										'is_active' =>  $is_active
										
								);
								$user_id = $this->member_model->insert_user($data);
								$user = $this->member_model->get_user_by_id($user_id);
								
														
								if(isset($user['id']) && $user['id'] > 0)
								{
								        session_start();
										$_SESSION['user_id'] = $user['id'];
										$_SESSION['first_name'] = $user['fname'];
										$_SESSION['last_name'] = $user['lname'];
										$_SESSION['email'] = $user['email'];
										$_SESSION['phone'] = $user['phone'];
						                $_SESSION['user_type_id'] = $user['type_id'];
										redirect('member/dashboard');
								}
								 else {
								   $this->session->set_flashdata('notification', "Some probelen to save data, please try again");
									redirect('member/signup'); //
								}
								
								
					 }
				}
			
			
	}	
	function logout()
	{
		session_start();
		//$this->user->logout();
		unset($_SESSION['user_id']);
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['user_type_id']);
		session_destroy();

		$this->session->set_flashdata('notification',"You are now logged out.");
		redirect('member/login');
	}
	function login()
	{
		//session_start();
		$this->load->library('form_validation');
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('member/dashboard');
		}
		else
		{
			if ( !$this->input->post('submit') )
			{
				$this->layout->load($this->template, 'login');
			}
			else
			{ 
				if ($this->input->post('submit') == 'Submit')
				{
					
					$this->form_validation->CI =& $this; 
					$this->form_validation->set_rules('email', "Email","trim|required|valid_email");	
					$this->form_validation->set_rules('password','Password',"trim|required");
					$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
					$this->form_validation->set_message('required', 'The %s field is required');
					$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');
					if ($this->form_validation->run() == FALSE)
					{
						$this->layout->load($this->template, 'login');
					}
					else
					{
						$email = $this->input->post('email');
						$password = $this->user->_prep_password($this->input->post('password'));
						$user = $this->member_model->validate_login($email, $password);
						
						if(isset($user['id']) && $user['id'] > 0)
						{
							$roles = $this->member_model->get_roles_by_id($user['id']);
							//echo "<pre>"; print_r($roles); exit;
							/*$user_role_id = ""; $user_roles="";
							for($i=0;$i<count($roles);$i++)
							{
								$user_role_id=$user_role_id.$roles[$i]['roleIds'].",";
								$user_roles.=$roles[$i]['type'].",";
							}*/
							$_SESSION['user_id'] = $user['id'];
							$_SESSION['first_name'] = $user['fname'];
							$_SESSION['last_name'] = $user['lname'];
							$_SESSION['user_type_id'] = $user['type_id'];
							//$_SESSION['user_role_id'] = $user_role_id;
							//$_SESSION['user_roles'] = $user_roles;
							
							redirect('member/dashboard');
						}
						else
						{
							$this->session->set_flashdata('notification', "No records found with this email & password.");
							redirect('member/login'); //
						}
					}
				}
				else
				{
					$this->layout->load($this->template, 'login');
				}
			}
		}
	}
	
	function dashboard()
	{
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		  {
		    
		     $this->layout->load($this->template, 'dashboard');
		   
		  }else{
		   $this->session->set_flashdata('notification',"You are not login.");
		   redirect('member/login');
		
		} 
		
	}

	function product_brands()
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			//$userroles = explode(",", $_SESSION['user_role_id']); 
			if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 2)
			{
				$this->template['brands'] = $this->member_model->get_product_brands();
				$this->layout->load($this->template, 'product_brands');
			}else{
				redirect('member/unauthorized');
			} 
		}else{
			$this->session->set_flashdata('notification',"You are not login.");
			redirect('member/login');
		} 
	}

	function suppliers($start = 0, $limit =10)
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 3)
			{
			    
			//for searching
			  $filter='';
				if(isset($_POST['filter']))
				{ 
					if($this->input->post('filter'))
					{
						$filter = $this->input->post('filter');
						$_SESSION['filter'] = $filter;
					}else{
						$filter = '';
						$_SESSION['filter'] = '';
					}
				}else
				{ 
					if(isset($_SESSION['filter']) && $_SESSION['filter'] != ''){ 
					$filter = $_SESSION['filter'];
					}else{ 
						$filter = '';
						$_SESSION['filter'] = '';
					}
				} 
				$this->template['filter'] = $filter; 		
			//end searching
				
				$this->template['suppliers'] = $this->member_model->get_suppliers($filter,array('limit' => $limit, 'start' => $start)); 
				
				$this->load->library('pagination');
				$config['uri_segment'] = 3;
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['base_url'] = site_url('product/list');
				$config['total_rows'] = $this->member_model->get_total_suppliers($filter);
				$config['per_page'] = $limit; 
				$this->pagination->initialize($config); 
				$this->template['pager'] = $this->pagination->create_links();
				$this->template['start'] = $start;
				
				//echo "<pre>"; print_r($this->template['products']); exit;
				$this->layout->load($this->template, 'suppliers');
			}else{
				redirect('member/unauthorized');
			} 
		}else{
			$this->session->set_flashdata('notification',"You are not login.");
			redirect('member/login');
		} 
	}

	function customerlist()
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			//$userroles = explode(",", $_SESSION['user_role_id']); 
			if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 5)
			{
				$this->template['customers'] = $this->member_model->get_customers();
				$this->layout->load($this->template, 'customerlist');
			}else{
				redirect('member/unauthorized');
			} 
		}else{
			$this->session->set_flashdata('notification',"You are not login.");
			redirect('member/login');
		} 
	}




	function addbrand()
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{		$user_id = $_SESSION['user_id'];
				//$userroles = explode(",", $_SESSION['user_role_id']); 
				if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 2)
				{
					$this->load->library('form_validation');
					$this->form_validation->CI =& $this; 
					$this->template['module']	= 'member';
					$this->form_validation->set_rules('name','Brand name',"trim|required");
					//$this->form_validation->set_rules('logo','Brand Logo',"trim|required");

					$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
					$this->form_validation->set_message('required', 'The %s field is required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$this->layout->load($this->template, 'addbrand');
					}
					else
					{
						//check if email belongs to someone else
							if ($this->member_model->brand_exists(array('name' => $this->input->post('name'))))
							{	
								$this->session->set_flashdata('notification', "We already have this brand in our database.");
								$this->layout->load($this->template, 'addbrand'); 
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
										'added_by' => $user_id,
										'is_active' => $this->input->post('status'),
										'date_created' => date("Y-m-d")
										
										);

										$brand_id = $this->member_model->insert_brand($data);
										$this->session->set_flashdata('notification', "Brand added successfully !");
										redirect('member/product_brands');
							}else{
								$this->session->set_flashdata('notification', "Please upload logo image of the correct file type.");
								$this->layout->load($this->template, 'addbrand'); 
								return FALSE;
							} 
					}
				}else{
					redirect('member/unauthorized');
				}

		}else{
			$this->session->set_flashdata('notification',"You are not login.");
			redirect('member/login');
		} 
	}

	function editbrand($brand_id=null)
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$this->template['brand_id'] = $brand_id;
			if ($this->template['brand'] = $this->member_model->get_brand_by_id($brand_id))
			{
			$user_id = $_SESSION['user_id'];
			//$userroles = explode(",", $_SESSION['user_role_id']); 
			if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 2)
			{
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this; 
				$this->template['module']	= 'member';
				$this->form_validation->set_rules('name','Brand name',"trim|required");
				//$this->form_validation->set_rules('logo','Brand Logo',"trim|required");

				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'editbrand');
				}
				else
				{		
						//echo "<pre>"; print_r($_POST); print_r($_FILES); exit;
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
										$this->createThumbnail($_FILES['logo']['tmp_name'], $targetPath, 300 ,$ext, 300);			
										
								}else{
									$this->session->set_flashdata('notification', "Please upload logo image of the correct file type.");
									$this->layout->load($this->template, 'editbrand'); 
									return FALSE;
								} 
							}else{ $imgname= $this->template['brand']['logo']; }
							$data = array(
								'name' => $this->input->post('name'),
								'logo' => $imgname,
								'added_by' => $user_id,
								'is_active' => $this->input->post('status')
								);
							$this->member_model->update_brand($brand_id, $data);
							$this->session->set_flashdata('notification', "Brand updated successfully !");
							redirect('member/product_brands');

				}
			}else{
				redirect('member/unauthorized');
			}
	

		}else{
			$this->session->set_flashdata("notification", "This brand doesn't exist");
			redirect("member/product_brands");
		}

	}else{
		$this->session->set_flashdata('notification',"You are not login.");
		redirect('member/login');
	} 
    }


	function _verify_username($data)
	{
		$username = $this->input->post('username');
		//check if email belongs to someone else
		if ($this->member_model->exists(array('username' => $username)))
		{
			$this->form_validation->set_message('_verify_username', "The username is already in use");
			return FALSE;
		}
		if ( !preg_match("/^[a-zA-Z0-9._-]+$/", $username))
		{
			$this->form_validation->set_message('_verify_username', "The username format is not valid, please use alphanumeric characters.");
			return FALSE;
		}
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


	function unauthorized()
	{
		$this->layout->load($this->template, 'unauthorized');
	}

		
	
	function _email_not_found($email)
	{
		//check if email belongs to someone else
		if (!$this->member_model->exists(array('email' => $email)))
		{
			$this->form_validation->set_message('_email_not_found', 'The address %s is not found in our database. Try another address.');
			return FALSE;
		}
	}	

	/*change password*/
	function changepassword()
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id'];
			
				//$this->template['title'] = "Change your password" ;
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('oldpassword','Old Password',"trim|required");
				$this->form_validation->set_rules('password','New Password',"trim|matches[passconf]|required");
				$this->form_validation->set_rules('passconf', "Confirm Password", "trim|required");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
				if ($this->form_validation->run() == FALSE)
				{
						$this->layout->load($this->template, 'changepassword');
				}
				else
				{	
					$oldpassword = $this->user->_prep_password($this->input->post('oldpassword'));
					if(isset($user_id) && $user_id > 0 && $oldpassword != '')
					{
						if ($this->member_model->exists(array('password' => $oldpassword, 'id' => $user_id))) 
						{
							$data = array('password' => $this->user->_prep_password($this->input->post('password')));
							$this->member_model->update_user($user_id, $data);
							$this->session->set_flashdata('notification', "Password Changed Successfully !");
							redirect('member/changepassword');
						}else{
							$this->session->set_flashdata('notification', "Please enter correct Old password.");
							redirect('member/changepassword');
						}
					}else{
						$this->session->set_flashdata('notification', "Please enter correct Old paswword.");
						$this->layout->load($this->template, 'changepassword');
						return FALSE;
					}
				}
			
		}else{
			redirect('member/login');
		}
	}
	function verify($hash = "null")
	{
		$this->user->require_login();
		$this->load->helper('file');
		if (is_file('cache/' . $hash))
		{
			$email = read_file('cache/' . $hash);
			$this->user->update($this->user->username, array('email' => $email));
			@unlink('cache/' . $hash);
			$this->session->set_flashdata('notification', "Your email is now changed. ");
			redirect('member/profile');
		}
		else
		{
			$this->session->set_flashdata('notification', "The link is not valid. Please check your email to verify. ");
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



}