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

	

	
	function coach($userid = null)
	{
	
	 //session_start();
	  
	   if($userid){
	   
	     $userdata = $this->member_model->get_user_by_id($userid);
		 $user = $this->member_model->validate_direct_login($userdata['email']);	
		 
		  if(isset($user['id']) && $user['id'] > 0)
		               {

							$_SESSION['user_id'] = $user['id'];

							$_SESSION['first_name'] = $user['first_name'];

							$_SESSION['last_name'] = $user['last_name'];

							$_SESSION['is_coach'] = $user['is_coach'];

							$_SESSION['is_paid'] = $user['is_paid'];
							
							$_SESSION['is_outer'] = 'outer';
							
							redirect('member/coach');
                       }
	   
	   }else{
	   
	   
			if( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
			{
				$user = $this->member_model->get_user_by_id($_SESSION['user_id']);
				$this->layout->load($this->template, 'becomecoach');
			}else{
				redirect('member/login');
			}

	   }
	    
		
		
	}

	function logout()

	{

		//session_start();

		//$this->user->logout();

		

		unset($_SESSION['user_id']);

		unset($_SESSION['first_name']);

		unset($_SESSION['last_name']);

		

		session_destroy();

		redirect(''); //member/login

		

		

		$this->session->set_flashdata('notification',"You are now logged out.");

		redirect($this->input->server('HTTP_REFERER'));

	}

	function login()

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			redirect('member/products');

		}

		else

		{

			if ( !$this->input->post('submit') )

			{

				$this->layout->load($this->template, 'login');



			}

			else

			{ 

				if ($this->input->post('submit') == 'submit')

				{

					$this->load->library('form_validation');

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

							$_SESSION['user_id'] = $user['id'];

							$_SESSION['first_name'] = $user['first_name'];

							$_SESSION['last_name'] = $user['last_name'];

							$_SESSION['is_coach'] = $user['is_coach'];

							$_SESSION['is_paid'] = $user['is_paid'];

							

							redirect('member/products');

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

	/* function login()

	{



		if ( $this->user->logged_in)

		{

			$this->session->set_flashdata('notification', __("You are now logged in", $this->template['module']));

			$redirect = $this->input->post('redirect');

			

			if ($redirect && (strpos($redirect, 'member/login') === false))

			{

				$redirect = str_replace(site_url(), '', $redirect); 

				redirect($redirect);

				return;

			}

			else

			{

				redirect ($this->system->page_home);

				return;

			}

		}

		else

		{

			if ( !$this->input->post('submit') )

			{

				$this->template['last_post'] = $this->session->userdata('last_post');

				$redirect = $this->session->userdata('redirect');

				if(!$redirect) $redirect = $this->input->server('HTTP_REFERER');

				$this->template['redirect'] = $redirect;

				

				

				//removed because values still needed

				//$this->session->unset_userdata('last_post');

				//$this->session->unset_userdata('redirect');

				

				$this->layout->load($this->template, 'login');



			}

			else

			{

				if(!$username = $this->input->post('username'))

				{

					$this->session->set_flashdata('notification', __("Please enter your username", $this->template['module']));

					redirect('member/login');

				}

				

				if(!$password = $this->input->post('password'))

				{

					$this->session->set_flashdata('notification', __("Please enter your password", $this->template['module']));

					redirect('member/login');

				}

				

				if(!$remember = $this->input->post('remember'))

				{

					$remember = false;

				}

			

				//exit("Remember: $remember");

				

				

				if ($this->user->login($username, $password, $remember))

				{

					$redirect = $this->input->post('redirect');

					if ($redirect && (strpos($redirect, 'member/login') === false))

					{

						$redirect = str_replace(site_url(''), '', $redirect); 

						redirect ($redirect);

						return;

					}

					else

					{

						redirect ($this->system->page_home);

						return;

					}

				}

				else

				{	

					$this->session->set_flashdata('notification', __("Login error. Please verify your username and your password.", $this->template['module']));

					redirect('member/login');

				}

			}

		}

	} */

	

	function signup()

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			redirect('member/products');

		}

		if ( !$this->input->post('submit') )

		{

			$this->layout->load($this->template, 'signup');

		}

		else

		{

			if ($this->input->post('submit') == 'submit')

			{

				$this->load->library('form_validation');

				$this->form_validation->CI =& $this;

				//$this->form_validation->set_rules('username',__('Username', $this->template['module']),"trim|required|min_length[4]|max_length[12]|xss_clean|callback__verify_username");

				$this->form_validation->set_rules('first_name','First Name',"trim|required|xss_clean");

				$this->form_validation->set_rules('last_name','Last Name',"trim|required|xss_clean");

				$this->form_validation->set_rules('email', "Email","trim|required|valid_email|callback__verify_mail");	

				$this->form_validation->set_rules('password','Password',"trim|matches[passconf]|required");

				$this->form_validation->set_rules('passconf', "Confirm", "trim");

				$this->form_validation->set_rules('ref_number','Referrer ID',"trim|required");

				$this->form_validation->set_rules('id_number','ID Number',"trim|required");

				

				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');



				$this->form_validation->set_message('min_length', 'The %s field is required');

				$this->form_validation->set_message('required', 'The %s field is required');

				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');

				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			

								



							

				if ($this->form_validation->run() == FALSE)

				{

					//$this->plugin->add_action('header', array(&$this, '_member_signup_header'));

					$this->layout->load($this->template, 'signup');

				}

				else

				{       

				     $id_number=$this->input->post('id_number');

					 $ref_number = $this->input->post('ref_number');

				

				     if ($this->member_model->exists(array('id_number' => $id_number)))

				     { 

					      $this->session->set_flashdata('notification', "The ID Number is already used, Try with another ID Number ");

					      redirect('member/signup');

				

				     }else{

					 

					        if ($this->member_model->exists(array('id_number' => $ref_number)))

				             {

					                   /**/

								$data = array(

										'first_name' => $this->input->post('first_name'),

										'last_name' => $this->input->post('last_name'),

										'email' => $this->input->post('email'),

										'password' => $this->user->_prep_password($this->input->post('password')),

										'ref_number' => $this->input->post('ref_number'),

										'id_number' => $this->input->post('id_number'),

										'is_coach' => 1,

										'status' => 'active',

										'registered' => time()

								

								);

								

									$user_id = $this->member_model->insert_user($data);
									$user = $this->member_model->get_user_by_id($user_id);

									if(isset($user['id']) && $user['id'] > 0)

									{

										$_SESSION['user_id'] = $user['id'];

										$_SESSION['first_name'] = $user['first_name'];

										$_SESSION['last_name'] = $user['last_name'];

										$_SESSION['is_coach'] = $user['is_coach'];

										$_SESSION['is_paid'] = $user['is_paid'];

										

										redirect('member/products');

									}

									else

									{

										$this->session->set_flashdata('notification', "No records found with this email & password.");

										redirect('member/login'); //

									}

										   /**/

							}else{

							

							 $this->session->set_flashdata('notification', "Referrer ID that you entered do not match with our record. Please enter valid referrer ID. ");

					         redirect('member/signup');

							

							}

					 }

					

					

					  

					//generate key

					/* $password = $this->_keygen();

					

					$id = $this->user->register(

						$this->input->post('username'),

						$password,

						$this->input->post('email')

					);

					

					$this->load->library('email');

					//send password

					$this->email->from($this->system->admin_email, $this->system->site_name);

					$this->email->to($this->input->post('email'));

					$this->email->subject(sprintf(__("Your password for %s", $this->template['module']), $this->system->site_name));

					$customized_message = "";

					$customized_message = $this->plugin->apply_filters('member_registered_msg', $customized_message);

					$message = sprintf(__("Hello %s,\n\nThank you for registering to %s.\nNow you can enter in the site with these information.\n\nUsername: %s\nPassword: %s\n\n", $this->template['module']), $this->input->post('username'), $this->system->site_name, $this->input->post('username'), $password);

					$message .= $customized_message;

					$message .= "\n\n";

					$message .= __("\nThank you.\nThe administrator", $this->template['module']);

					$this->email->message($message);



					$this->email->send();

					//notify admin

					

					$this->email->from($this->system->admin_email, $this->system->site_name);

					$this->email->to($this->system->admin_email);

					$this->email->subject(sprintf(__("New member for %s", $this->template['module']), $this->system->site_name));

					$this->email->message(sprintf(__("Hello admin,\n\nA new member has just registered into your site. These are the submitted information.\n\nUsername: %s\nEmail: %s\nIP: %s\nThank you.\nThe administrator", $this->template['module']), $this->input->post('username'), $this->input->post('email'), $this->input->ip_address()));



					$this->email->send(); */

					

					

					//$this->template['title'] = __("User registered", "member");

					//$this->template['message'] = nl2br(sprintf(__("Thank you for registering with this site.\n\nPlease check your email %s and get there your password, then turn back to log in.", "member"), "<b>" . $this->input->post('email') . "</b>"));

					//$this->template['message'] = nl2br(sprintf(__("Thank you for registering with this site.\n\nNow you are able to Log in your account with email address %s. Please go to Login section", "member"), "<b>" . $this->input->post('email') . "</b>"));

					//$this->layout->load($this->template, 'message');

					

				}

				

			}

			else

			{

				$this->layout->load($this->template, 'signup');

			}

		

		}



	}

	

	function customersignup()

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			redirect('member/products');

		}

		if ( !$this->input->post('submit') )

		{

			$this->layout->load($this->template, 'customersignup');

		}

		else

		{

			if ($this->input->post('submit') == 'submit')

			{

				$this->load->library('form_validation');

				$this->form_validation->CI =& $this;

				//$this->form_validation->set_rules('username',__('Username', $this->template['module']),"trim|required|min_length[4]|max_length[12]|xss_clean|callback__verify_username");

				$this->form_validation->set_rules('first_name','First Name',"trim|required|xss_clean");

				$this->form_validation->set_rules('last_name','Last Name',"trim|required|xss_clean");

				$this->form_validation->set_rules('email', "Email","trim|required|valid_email|callback__verify_mail");	

				$this->form_validation->set_rules('password','Password',"trim|matches[passconf]|required");

				$this->form_validation->set_rules('passconf', "Confirm", "trim");

				$this->form_validation->set_rules('ref_number','Reference Number',"trim|required");

				

				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');



				$this->form_validation->set_message('min_length', 'The %s field is required');

				$this->form_validation->set_message('required', 'The %s field is required');

				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');

				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			

								



							

				if ($this->form_validation->run() == FALSE)

				{

					//$this->plugin->add_action('header', array(&$this, '_member_signup_header'));

					$this->layout->load($this->template, 'customersignup');

				}

				else

				{

				

				   $ref_number = $this->input->post('ref_number');

				

			   if ($this->member_model->exists(array('id_number' => $ref_number)))

				{

				$data = array(

									'first_name' => $this->input->post('first_name'),

									'last_name' => $this->input->post('last_name'),

									'email' => $this->input->post('email'),

									'password' => $this->user->_prep_password($this->input->post('password')),

									'ref_number' => $this->input->post('ref_number'),

									'status' => 'active',

									'registered' => time()

									

								);

										

					$user_id = $this->member_model->insert_user($data);
					$user = $this->member_model->get_user_by_id($user_id);

					if(isset($user['id']) && $user['id'] > 0)

					{

						$_SESSION['user_id'] = $user['id'];

						$_SESSION['first_name'] = $user['first_name'];

						$_SESSION['last_name'] = $user['last_name'];

						$_SESSION['is_coach'] = $user['is_coach'];

						$_SESSION['is_paid'] = $user['is_paid'];

						

						redirect('member/products');

					}

					else

					{

						$this->session->set_flashdata('notification', "No records found with this email & password.");

						redirect('member/login'); //

					}

				

				}else{

				//$this->form_validation->set_message('_verify_id_number', __("The ref number is not exists", $this->template['module']));

				

					  $this->session->set_flashdata('notification', "Referrer ID that you entered do not match with our record. Please enter valid referrer ID.");

					   redirect('member/customersignup'); //

				

				}

				   

					

					//generate key

					/* $password = $this->_keygen();

					

					$id = $this->user->register(

						$this->input->post('username'),

						$password,

						$this->input->post('email')

					);

					

					$this->load->library('email');

					//send password

					$this->email->from($this->system->admin_email, $this->system->site_name);

					$this->email->to($this->input->post('email'));

					$this->email->subject(sprintf(__("Your password for %s", $this->template['module']), $this->system->site_name));

					$customized_message = "";

					$customized_message = $this->plugin->apply_filters('member_registered_msg', $customized_message);

					$message = sprintf(__("Hello %s,\n\nThank you for registering to %s.\nNow you can enter in the site with these information.\n\nUsername: %s\nPassword: %s\n\n", $this->template['module']), $this->input->post('username'), $this->system->site_name, $this->input->post('username'), $password);

					$message .= $customized_message;

					$message .= "\n\n";

					$message .= __("\nThank you.\nThe administrator", $this->template['module']);

					$this->email->message($message);



					$this->email->send();

					//notify admin

					

					$this->email->from($this->system->admin_email, $this->system->site_name);

					$this->email->to($this->system->admin_email);

					$this->email->subject(sprintf(__("New member for %s", $this->template['module']), $this->system->site_name));

					$this->email->message(sprintf(__("Hello admin,\n\nA new member has just registered into your site. These are the submitted information.\n\nUsername: %s\nEmail: %s\nIP: %s\nThank you.\nThe administrator", $this->template['module']), $this->input->post('username'), $this->input->post('email'), $this->input->ip_address()));



					$this->email->send(); */

					

					

					//$this->template['title'] = __("User registered", "member");

					//$this->template['message'] = nl2br(sprintf(__("Thank you for registering with this site.\n\nPlease check your email %s and get there your password, then turn back to log in.", "member"), "<b>" . $this->input->post('email') . "</b>"));

					//$this->template['message'] = nl2br(sprintf(__("Thank you for registering with this site.\n\nNow you are able to Log in your account with email address %s. Please go to Login section", "member"), "<b>" . $this->input->post('email') . "</b>"));

					//$this->layout->load($this->template, 'message');

					

				}

				

			}

			else

			{

				$this->layout->load($this->template, 'customersignup');

			}

		

		}



	}

	

	function allnotification($start = 0, $limit =10, $order = 'id')

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			//echo "<pre>"; print_r($_SESSION); exit;

			if($_SESSION['is_coach'] > 0)

			{

				

				$count=$this->member_model->get_count_all_media($_SESSION['user_id']);

				$this->template['media'] = $this->member_model->get_all_media($_SESSION['user_id'],array('limit' => $limit, 'start' => $start)); 

				//echo count($this->template['media']);

				//echo "<pre>"; print_r($media); exit;

				$this->load->library('pagination');

				$config['uri_segment'] = 3;

				$config['first_link'] = 'First';

				$config['last_link'] = 'Last';

				$config['base_url'] = site_url('member/allnotification');

				$config['total_rows'] = $count;

				$config['per_page'] = $limit; 

				

				$this->pagination->initialize($config); 

				$this->template['pager'] = $this->pagination->create_links();

				$this->template['start'] = $start;

				$this->layout->load($this->template, 'allnotification');

			}else{

				redirect('member/notification');

			}

					

		}else{

			redirect('member/login');

		}

		

	}

	

	function get_ajax_user_notification()

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{	//echo $_SESSION['user_id']; exit;

			$this->member_model->reset_user_notify_count($_SESSION['user_id']);

			/* if($this->user->update_user_notify_count($_SESSION['user_id']))

			{ */

				$noti_count = $this->user->get_user_media_notification($_SESSION['user_id']);

				if(count($noti_count) > 0)

				{	

					$result_string="";

					foreach($noti_count as $notif)

					{

						if($notif['is_publish'] == 1){

							$result_string.='<div class="anchorContainer unread">';

						}else{ 

							$result_string.='<div class="anchorContainer">';

						}

						$user_media_id = $notif['user_media_id'];

						$link = site_url('member/mediadetail/'.$user_media_id);

						$first_name = $notif['first_name'];

						$media_type = $notif['media_type'];

						$result_string.='<a href="'.$link.'" data-lity>';

						$result_string.='<span><img src="'.base_url().'application/views/'.$this->system->theme_dir . $this->system->theme.'/images/'.$media_type.'-icon011.png" alt="media-icon"></span>';

						$result_string.='<strong>'.$first_name.'</strong> shared a '.$media_type.' with you.</a>';

						$result_string.='</div>';

					}

					

					echo $result_string; exit;

					

					

				}else{

					echo "No notification found.";

				}

			

			/* }else{

				echo "Count not updated.";

			} */

		}else{

			echo "You are no longer logged in. Please login again.";

		}

	}

	

	function get_acitve_notification_count()

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			$count=$this->member_model->get_count_acitve_notification($_SESSION['user_id']);

			if($count > 0)

			{

				echo $count; exit; 

			}else{

				echo ""; exit;

			}

		}else{

			redirect('member/login');

		}

	}

	function profile()

	{

		//session_start();

		

		$this->layout->load($this->template, 'myaccount');

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

	

	function unauthorized($module, $level)

	{

		$this->template['data']  = array('module' => $module, 'level' => $level);

		$this->layout->load($this->template, 'unauthorized');

	}

	

	

	/* function profile($username = null) 

	{

		//session_start();

		$this->user->require_login();

		

		if ( is_null($username) )

		{

			$username = $this->user->username;

			$this->load->library('form_validation');

			$this->form_validation->CI =& $this;

			$this->form_validation->set_rules('password',__('Password', $this->template['module']),"trim|matches[passconf]|required");

			$this->form_validation->set_rules('passconf',__('Confirm', $this->template['module']),"trim|required");

			

			$this->template['member'] = $this->user->get_user(array('username' => $this->user->username));

			

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');



			$this->form_validation->set_message('required', __('The %s field is required', $this->template['module']));

			$this->form_validation->set_message('matches', __('The %s field does not match the %s field', $this->template['module']));

							

						

			if ($this->form_validation->run() == FALSE)

			{

				$this->layout->load($this->template, 'myprofile');

			}

			else

			{

				if ($this->input->post('password'))

				{

					$data['password'] = $this->input->post('password');

				}

				$this->user->update($username, $data);

				

				$this->session->set_flashdata('notification', __("Your profile was saved.", $this->template['module']));

				if ($redirect = $this->session->userdata("login_redirect"))

				{

					$this->session->set_userdata(array("login_redirect" => ""));

					redirect($redirect);

				}

				else

				{

					redirect('member/profile');

				}

			

			}				

		

		}

		else

		{

			echo $username;

		}

	} */

	

	function _keygen()

	{

		$size = 3;

		$key = "";

		$consonne = "bcdfghjklmnpqrstvwxz";

		$voyelle = "aeiouy";



		srand((double)microtime()*date("YmdGis"));



		for($cnt = 0; $cnt < $size; $cnt++)

		{

		$key .= $consonne[rand(0, 19)].$voyelle[rand(0, 5)];

		}



		return $key;

	}		

	

	



	

	function adino($code = null)

	{

		if (is_null($code))

		{

			if ($this->user->logged_in)

			{

				redirect('member/profile');

			}

			

			

			$this->load->library('form_validation');

			$this->form_validation->CI =& $this;

			$this->form_validation->set_rules('email','Email', "trim|required|valid_email|callback__email_not_found");	

			

			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

			

			$this->form_validation->set_message('required', 'The %s field is required');

			$this->form_validation->set_message('valid_email', 'The address %s is not a valid email');

			

			if ($this->form_validation->run() == FALSE)

			{

				$this->layout->load($this->template, 'adino');

				

			}

			else

			{



				$user = $this->user->get_user(array('email' => $this->input->post('email')));

				

				$key = $this->_keygen();

				$this->load->library('email');

				//send password

				$this->email->from($this->system->admin_email, $this->system->site_name);

				$this->email->to($user['email']);

				$this->email->subject(sprintf("Create a new password: %s", $this->system->site_name));

				$this->email->message(sprintf("Hello %s,\n\nYou said you forgot your password for %s. Since we do not keep passwords in clear, you have to create one. Click the link below to create a new password.\n\n%s\n\nThank you.\nThe administrator", $user['username'], $this->system->site_name, site_url($this->user->lang . '/member/adino/' . $key)));



				$this->email->send();

				

				$this->user->update($user['username'], array('activation' => $key));

				$this->template['message'] = sprintf("We have sent to %s the instruction on how to create a new password. Please check your email.", $user['email']);

				$this->layout->load($this->template, 'adino_result');

			}

		}

		else

		{

		//verify code

			if ($user = $this->user->get_user(array('activation' => $code)))

			{

				if ($this->input->post('newpass') && ($this->input->post('newpass') == $this->input->post('rnewpass')))

				{

					$this->user->update($user['username'], array('activation' => '', 'password' => $this->input->post('newpass')));

					$this->template['message'] = "Your password is now changed. You can login with your username and the new password.";

					$this->user->logout();

					$this->layout->load($this->template, 'adino_result');

				}

				else

				{



					$this->template['row'] = $user;

					$this->layout->load($this->template, 'adino_activate');

				}

			}

			else

			{

				$this->template['message'] = "The activation link is not valid. Please check again your email and verify the link. If you are sure the link was right then contact the administrator.";

				$this->layout->load($this->template, 'adino_result');

			

			}

		}

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

	

	function change_mail()

	{

		

		$this->user->require_login();

		

		$this->template['title'] = __("Change your email", "member") ;

		$this->load->library('form_validation');

		$this->form_validation->CI =& $this;

		$this->form_validation->set_rules('email','Email', "trim|required|matches[remail]|valid_email|callback__verify_mail");

		$this->form_validation->set_rules('remail','Confirm', "trim|required");

		

		$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');



		$this->form_validation->set_message('required', 'The %s field is required');

		$this->form_validation->set_message('matches', 'The %s field does not match the %s field');

		$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			

						

				

		if ($this->form_validation->run() == FALSE)

		{

			

			$this->layout->load($this->template, 'change_mail');

		}

		else

		{	

			$hash = $this->_keygen();

			$this->load->helper('file');

			write_file('cache/' . $hash, $this->input->post('email'));



			$this->load->library('email');

			//send password

			$this->email->from($this->system->admin_email, $this->system->site_name);

			$this->email->to($this->input->post('email'));

			$this->email->subject(sprintf("Email change confirmation", $this->system->site_name));

			$this->email->message(sprintf("Hello %s,\n\nYou asked to change your email for %s.\n Please click the link below to confirm that this email belongs to you. \n\n%s\n\nThank you.\nThe administrator", $this->user->username, $this->system->site_name, site_url('member/verify/' . $hash)));



			$this->email->send();

			



			$this->session->set_flashdata('notification', sprintf("Please, check your new email %s, We sent a link to verify that it belongs to you.", $this->input->post('email')));

			redirect('member/profile');

		}

	}

	/*services*/

	function services($start = 0, $limit = 10)

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

		

		    

			$this->template['services'] = $this->member_model->get_services(array('limit' => $limit, 'start' => $start));	

			

			//echo $this->member_model->product_count(); 

			$this->load->library('pagination');

			$config['uri_segment'] = 3;

			$config['first_link'] = 'First';

			$config['last_link'] = 'Last';

			$config['base_url'] = site_url('member/services');

			$config['total_rows'] =$this->member_model->services_count();

			$config['per_page'] = $limit; 



			$this->pagination->initialize($config); 



			$this->template['pager'] = $this->pagination->create_links();

			$this->template['start'] = $start;		

			$this->layout->load($this->template, 'services');	

		

		}else{

			redirect('member/login');

		}

	}

	

	/*Products*/

		function products($start = 0, $limit = 10)

	{

	

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

		  

			$this->template['products'] = $this->member_model->get_products(array('limit' => $limit, 'start' => $start));	

			

			//echo $this->member_model->product_count(); 

			$this->load->library('pagination');

			$config['uri_segment'] = 3;

			$config['first_link'] = 'First';

			$config['last_link'] = 'Last';

			$config['base_url'] = site_url('member/products');

			$config['total_rows'] =$this->member_model->product_count();

			$config['per_page'] = $limit; 



			$this->pagination->initialize($config); 



			$this->template['pager'] = $this->pagination->create_links();

			$this->template['start'] = $start;	

			$this->layout->load($this->template, 'products');	

		}else{

			redirect('member/login');

		}

	}

	/*Video*/	

	function video()

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			$this->template['video'] = $this->member_model->get_video();		

			$this->layout->load($this->template, 'video');

		}else{

			redirect('member/login');

		}

	}

	

	/*Video*/	

	function mycustomer($start = 0, $limit =10, $order = 'id')

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			if(isset($_SESSION['is_paid']) &&  $_SESSION['is_paid'] > 0)

			{

				$user = $this->member_model->get_user_by_id($_SESSION['user_id']);

				

				if(isset($user['id_number']) &&  $user['id_number'] != '')

				{

				

				  

				  

				  $total = $this->member_model->get_user_by_ref_number_total($user['id_number']);

					$this->template['customers'] = $this->member_model->get_user_by_ref_number($user['id_number'],array('limit' => $limit, 'start' => $start));

					

				} 

				

				

				$this->load->library('pagination');

				$config['uri_segment'] = 3;

				$config['first_link'] = 'First';

				$config['last_link'] = 'Last';

				$config['base_url'] = site_url('member/mycustomer');

				$config['total_rows'] = $total;

				$config['per_page'] = $limit; 

				

				$this->pagination->initialize($config); 

				$this->template['pager'] = $this->pagination->create_links();

				$this->template['start'] = $start;

				

				$this->layout->load($this->template, 'mycustomer');

			}else{

				

				$this->session->set_flashdata('notification', sprintf("Please change your membership to access this section."));

				redirect('member/products');

			}

			//$this->template['video'] = $this->member_model->get_video();		

			//$this->layout->load($this->template, 'video');

		}else{

			redirect('member/mycustomer');

		}

	}

	

	/*change password*/

	function changepassword()

	{

        //session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			

			$user_id = $_SESSION['user_id'];

			if ($this->input->post('submit') == 'submit')

			{

				$this->template['title'] = "Change your password" ;

				$this->load->library('form_validation');

				$this->form_validation->CI =& $this;

				$this->form_validation->set_rules('oldpassword','Old Password',"trim|required|xss_clean");

				$this->form_validation->set_rules('password','New Password',"trim|matches[passconf]|required");

				$this->form_validation->set_rules('passconf', "Confirm Password", "trim|required");

				

				

				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

				

				$this->form_validation->set_message('required', 'The %s field is required');

				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');

				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			

				

						

				if ($this->form_validation->run() == FALSE)

				{

					//$this->session->set_flashdata('notification', __("Your password has been changed successfully.", $this->template['module']));

					$this->layout->load($this->template, 'changepassword');

				}

				else

				{	

					$oldpassword = $this->user->_prep_password($this->input->post('oldpassword'));

					if(isset($user_id) && $user_id > 0 && $oldpassword != '')

					{

						if ($this->member_model->exists(array('password' => $oldpassword, 'id' => $user_id))) 

						{

							$data = array(

											'password' => $this->user->_prep_password($this->input->post('password')),

											);

											

							$this->member_model->update_user($user_id, $data);

							$this->session->set_flashdata('notification', "Password Changed Successfully !");

							redirect('member/changepassword');

							

						}else{

							$this->session->set_flashdata('notification', "Please enter correct Old password.");

							redirect('member/changepassword');

						}

					}

				}

			}else{

				$this->layout->load($this->template, 'changepassword');

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

	

	/*send notification to child member*/

	  function sentnotificationbyuser($media_id = null)

	          

		 {

		      //session_start();

			 

			 if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		        

				{

			  

				        if (is_null($media_id))

				         {

							  $this->session->set_flashdata("notification", "Media Id required");

							   redirect("member/allnotification");

				         }else{

						   

								//Get login user ID Number

								$id_number= $this->member_model->get_id_number($_SESSION['user_id']);

								

								//Get child user details

								$child_member=$this->member_model->get_child_user($id_number);

								//echo "<pre>"; print_r($child_member); exit;

								//Get Media details

								 $mediadata=$this->member_model->get_media_details($media_id);

								

								$count= count($child_member);

								

								if($count > 0 ){

										

										$date = date("Y-m-d");

										foreach($child_member as $userdata){

										

												$user_media =  array(

														'sender_id' => $_SESSION['user_id'],

														'receiver_id' => $userdata['id'],

														'media_type_id' => $mediadata[0]['media_type_id'],

														'media_id' => $mediadata[0]['media_id'],

														'date_created' => $date

												 );

												

										$this->member_model->insert_media_data($user_media);

										

										}

										

										$this->session->set_flashdata('notification', "Media has been sent to the down line members");

										redirect('member/allnotification');

							

					}else{

					

					$this->session->set_flashdata('notification', "You dont have any member in your network. Please provide your ID number to new User as Referrer Id.");

							redirect('member/allnotification');

					

					}

					

					

				

				         }

				

			 }else{

			    redirect('member/login');

		     }

				

		}

	function forgotpassword()

{

	//session_start(); 

			

	$this->template['msg']="";

	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0)

	{

		redirect('member/products');

	}

	else

	{

		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		if(isset($_POST['email']))
		{	

				$this->form_validation->set_rules('email', "Email","trim|required|valid_email");	

				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

				$this->form_validation->set_message('min_length', 'The %s field is required');

				$this->form_validation->set_message('required', 'The %s field is required');

				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');

				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');	

			if ($this->form_validation->run() == FALSE)

			{	
                $this->session->set_flashdata('notification', "Please enter valid email Id");
				$this->layout->load($this->template, 'forgotpassword');

			}

			else

			{

				$user = $this->member_model->get_user_by_email($_POST['email']);

				

				if(isset($user) && (is_array($user)))

				{	

					$user_id = $user[0]['id'];

					$display_password = rand(100000,10000000); 

					$password = $display_password; //$this->user->_prep_password($display_password);

					$this->member_model->change_password($user_id, $display_password, $password);

					

					

					/*$config['protocol'] = 'smtp';

					$config['smtp_host'] = 'localhost';						

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype'] = 'text/html';*/

					//$config['validate'] = 'TRUE';

					

			/*		$this->load->library('email');

					$this->email->initialize($config);

					$this->email->from($this->system->admin_email, $this->system->site_name); 

					

					

																

					$sub="New Login details From ".$this->system->site_name;

					$message="Hello, <br/><br/>";

					$message.= "Your password has been reset successfully on ".$this->system->site_name.".Please follow the links to login your account.<BR/>";

					$message.="<b>Email ID : </b>".$user[0]['email']."<br/>";

					$message.="<b>Password : </b>".$display_password."<br/>";

					$message.="<a href='".$link."' target='blank'>".$link."</a>";

					

					$this->email->to($_POST['email']);

					$this->email->subject($sub, "member");

					$this->email->message($message, "member");

					$this->email->send();

					

					$this->session->set_flashdata('notification', __("Your password has been sent to your email id Please check your email"));*/
                    $this->session->set_flashdata('notification', "Your password has been changed successfully");
					$this->layout->load($this->template, 'forgotpassword');

				}

				else

				{

					$this->session->set_flashdata('notification', "The email address does not exist in our database. Please enter valid email address");

					//$this->layout->load($this->template, 'forgotpassword');

					redirect('member/forgotpassword');

				}

			}

		}

		else

		{

			$this->layout->load($this->template, 'forgotpassword');

		}

	}

}



/*send notification to child member By Individual*/

	  function sentmediaindividual($media_id = null) 
	  
	  {

		      //session_start();

			 if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		         {
					$this->load->library('form_validation');

					$this->form_validation->CI =& $this; 

					$this->form_validation->set_rules('receiver_id','Line Member',"trim|required");

					$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

					$this->form_validation->set_message('min_length', 'The %s field is required');

					$this->form_validation->set_message('required', 'The %s field is required');
					
					
					
					//Get login user ID Number
					
					$id_number= $this->member_model->get_id_number($_SESSION['user_id']);
					$mediadata=$this->member_model->get_media_details($media_id);
					$this->template['userdata'] = $this->member_model->get_child_user($id_number);
					$this->template['media'] = $this->member_model->get_media_data($media_id);
					$this->template['media_id'] = $media_id;
					  if ($this->form_validation->run() == FALSE)

					  {
					  
					      $this->session->set_flashdata('notification', "Please select down line Member");
					       $this->layout->load($this->template, 'sentmediaindividual');

					  }else{
					  
					     

					

							$date = date("Y-m-d");

							$receiver_id=$this->input->post('receiver_id');

							$user_media =  array(

													'sender_id' => $_SESSION['user_id'],

													'receiver_id' => $receiver_id,

													'media_type_id' => $mediadata[0]['media_type_id'],

													'media_id' => $mediadata[0]['media_id'],

													'date_created' => $date

												);

												

							$this->member_model->insert_media_data($user_media);

							$this->session->set_flashdata('notification', "Media has been sent to the selected down line members");

							redirect('member/allnotification/');

							

					
					   }

			   }else{
			     $this->session->set_flashdata("notification", "This member doesn't exist");
                 redirect('member/login');

		     }
		}

		

		  /*Send notification by the login user*/

   

   	function sentnotification($start = 0, $limit =10, $order = 'id')

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{

			

			if($_SESSION['is_coach'] > 0)

			{

				$count=$this->member_model->get_count_send_media($_SESSION['user_id']);

				$this->template['media'] = $this->member_model->get_all_send_media($_SESSION['user_id'],array('limit' => $limit, 'start' => $start));

				//echo "<pre>"; print_r($media); exit;

				

				$this->load->library('pagination');

				$config['uri_segment'] = 3;

				$config['first_link'] = 'First';

				$config['last_link'] = 'Last';

				$config['base_url'] = site_url('member/sentnotification');

				$config['total_rows'] = $count;

				$config['per_page'] = $limit; 

				

				$this->pagination->initialize($config); 

				$this->template['pager'] = $this->pagination->create_links();

				$this->template['start'] = $start;

				

				$this->layout->load($this->template, 'sentnotification');

			}else{

				redirect('member/sentnotification');

			}

					

		}else{

			redirect('member/login');

		}

		

		

	}	

	   /*Send received by the login user*/

   

   	function receivednotification($start = 0, $limit =10, $order = 'id')

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{	

				//$this->template['media'] = $this->member_model->get_user_media_notification($_SESSION['user_id']);

				$count=$this->member_model->get_user_media_notification_count($_SESSION['user_id']);

				$this->template['media'] = $this->member_model->get_user_media_received_notification($_SESSION['user_id'],array('limit' => $limit, 'start' => $start));

				//echo "<pre>"; print_r($media); exit;

				

				

				$this->load->library('pagination');

				$config['uri_segment'] = 3;

				$config['first_link'] = 'First';

				$config['last_link'] = 'Last';

				$config['base_url'] = site_url('member/receivednotification');

				$config['total_rows'] = $count;

				$config['per_page'] = $limit; 

				

				$this->pagination->initialize($config); 

				$this->template['pager'] = $this->pagination->create_links();

				$this->template['start'] = $start;

				$this->layout->load($this->template, 'receivednotification');

			

					

		}else{

			redirect('member/login');

		}

		

		

	}	

	/*Send notification by the login user*/

   

   	function mediadetail($user_media_id)

	{

		//session_start();

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{   

		

		 $data=array("is_notify"=>0,"is_watch"=>1,'is_notify_read_count'=>0);

		

		        $this->member_model->update_user_notify($user_media_id,  $data);

				$this->template['media'] = $this->member_model->get_media_data($user_media_id);

				$this->layout->load($this->template, 'mediadetail');

			

					

		}else{

			redirect('member/login');

		}

		

		

	}	

	

	function deleterecord($id){

	

	if($id > 0){

	

			$this->member_model->delete_send($id);

			redirect('member/sentnotification');

	}

	

	

	

	}

	

	function deleterecord_recevied($id){

		if($id > 0){

		

				$this->member_model->delete_received($id);

				redirect('member/receivednotification');

		}



	}

	function get_document_download()

	{

		//session_start();

		

		 //$file_name='http://dackpharma.com/fitnessclub/media/media_type/text/'.$_POST['filename'];

		 

		// echo $file_name; exit;

		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)

		{	//echo $_SESSION['user_id']; exit;

			

			/* if($this->user->update_user_notify_count($_SESSION['user_id']))

			{ */

				if(!empty($_POST['filename']))

				{	

				

				  //  $file_name='http://dackpharma.com/fitnessclub/media/media_type/text/56d5283ca9eef.docx';

//				   // $file_name=$_POST['filename'];

//					

//					if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

//					

//					// get the file mime type using the file extension

//					switch(strtolower(substr(strrchr($file_name, '.'), 1))) {

//					case 'pdf': $mime = 'application/pdf'; break;

//					case 'zip': $mime = 'application/zip'; break;

//					case 'jpeg':

//					case 'jpg': $mime = 'image/jpg'; break;

//					default: $mime = 'application/force-download';

//					}

//					header('Pragma: public'); 	// required

//					header('Expires: 0');		// no cache

//					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

//					header('Cache-Control: private',false);

//					header('Content-Type: '.$mime);

//					header('Content-Disposition: attachment; filename="'.$file_name.'"');

//					header('Content-Transfer-Encoding: binary');

//					header('Content-Length: '.filesize($file_name));	// provide file size

//					header('Connection: close');

//					readfile($file_name);		// push it out

//					exit();

					

					

					

				}else{

					echo "No file found.";

				}

			

			/* }else{

				echo "Count not updated.";

			} */

		}else{

			echo "You are no longer logged in. Please login again.";

		}

	}

	

	

}