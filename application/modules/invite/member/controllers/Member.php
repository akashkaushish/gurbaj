<?php     if (!defined('BASEPATH')) exit('No direct script access allowed');
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
	
	function pay($planid=NULL)
	{
		$this->template['selectpage'] = 2;
	     $this->load->library('form_validation');
		 $this->form_validation->CI =& $this;	
		 		 
	    if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){
			  if(isset($planid) && ($planid == 0 )){	
					 $this->session->set_flashdata('notification', "You are not a paid member, Please buy any package.");
					 redirect('member/package');	
			   }
			    /*Get Plan Key*/
			     $plankey=$package[$packageid];
				  $this->template['planid']=$planid;
				$this->form_validation->set_rules('transaction_id','Transaction Id',"trim|required|alpha_numeric|min_length[32]|max_length[32]");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				if ($this->form_validation->run() == FALSE)
				{	
					$this->layout->load($this->template, 'pay'); 
				}
				else
				{
					 if($plandata=$this->member_model->get_package_licence_price($planid)){ 
							$data = array(
										'plan_id' => $planid,
										'user_id' => $_SESSION['user_id'],
										'transaction_id' => $this->input->post('transaction_id'),
										'payment_amount' => $plandata['price'],
										'payment_date' => @date('Y-m-d')										
								); 
								$insertplan = $this->member_model->insert_plan($data);
								
								//echo  $this->db->last_query();  exit;
								if($insertplan)
								{
									$userdata = $this->member_model->get_user_by_id($_SESSION['user_id']); 
									$from = 'CrypGrow <support@crypgrow.com>';
									$name = $userdata[0]['first_name'];
									$lname = $userdata[0]['last_name'];
									$to = $userdata[0]['email'];
									$subject = 'Congrats, for starting a investment plan';
									$message ='<p>You have successfully started a investment plan on CrypGrow. Now, CrypGrow Admin will confirm your payment transaction number you entered and activate your plan . We will show the way to successive.</p>
									<p>Thank you again,</p>
									<p>Team CrypGrow</p>';
									$headers = "From: $from";
									$alldata='Hello '.$name.' '.$lname.', '.$message ;
									$semi_rand = md5(time());
									$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
							    	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
									$message1='<!DOCTYPE HTML><html>
												<head>
												<meta charset="utf-8">
												<title>index</title>
												<meta name="description" content="" />
												<meta name="keywords" content="" />
												</head>
												<body style="margin:0px; padding:0px; background:#efefef;">
												<table width="100%" border="0" style="background:#efefef;" cellspacing="0" cellpadding="0">
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0">
														<tr>
														<td><table width="100%" border="0" style="background-color:rgb(72, 54, 191);" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left" style="padding:10px; text-align:center;"><img src="'.base_url().'application/views/themes/vjpro/img/logo.png" alt=""/></td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td style=" background-color:rgb(72, 54, 191);"><table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td style="width:20%; padding-top:10px;"><hr style="color:rgb(255,255,255)" width="100%" size="1" align="left"></td>
																<td style="width:60%; padding-top:10px; font-size:16px; font-weight:bold; text-align:center; line-height:24px; color:#fff; text-transform:uppercase; font-family:Arial, Helvetica, sans-serif;">'.$subject.'</td>
																<td style="width:20%; padding-top:10px;"><hr style="color:rgb(255,255,255)" width="100%" size="1" align="right"></td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left"><img src="'.base_url().'application/views/themes/vjpro/img/emailbanner.jpg" alt=""/></td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td style=" background-color:rgb(255, 255, 255);" align="center">&nbsp;</td>
														</tr>
														<tr>
														<td style=" background-color:rgb(255, 255, 255);" align="center"><table width="550" border="0" cellspacing="10" cellpadding="10">
															<tr>
																<td align="left" style="border:1px solid #000; font-size:13px; color:#000; font-family:Arial, Helvetica, sans-serif; padding:10px;">'. $alldata.'
																</td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td style=" background-color:rgb(255, 255, 255);" align="center">&nbsp;</td>
														</tr>
														<tr>
														<td><table width="100%" border="0" cellspacing="0" cellpadding="4">
															<tr>
																<td align="center" style="background:rgb(60, 60, 61);">&nbsp;</td>
															</tr>
															<tr>
																<td align="center" style="background:rgb(60, 60, 61); font-size:13px; color:#fff; font-family:Arial, Helvetica, sans-serif;">COPYRIGHT &copy; CrypGrow '.date('Y').' ALL RIGHTS RESERVED</td>
															</tr>
															<tr>
																<td align="center" style="background:rgb(60, 60, 61);">&nbsp;</td>
															</tr>
															</table></td>
														</tr>
													</table>
													<!--template end-->
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												</table>
												</body>
												</html>';
									$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" .$message1 . "\n\n";
									$message .= "--{$mime_boundary}\n";
									mail($to, $subject, $message, $headers);

									$this->session->set_flashdata('notification', "You have successfully started a investment plan on CrypGrow, Please wait untill Admin approve your payment.");
									redirect('member/thanks');
								   
								}else {
								  $this->session->set_flashdata('notification', "There is some problem to save your data, please try again");
									redirect('member/pay/'.$planid);
								}
								
					 }else{		     
						$this->session->set_flashdata('notification', "You have selected invalid package.");
						redirect('member/package');		  
		              }			
					 
				}
		}else{
				redirect('member/login');
			}	
	}	
	function withdraw()
	{	$this->template['selectpage'] = 4;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id'];
			$this->template['wallet_total'] = $this->member_model->get_user_total_wallet($user_id);
			//$this->template['title'] = "Change your password" ;
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			$this->form_validation->set_rules('account','Account',"trim|required");
			$this->form_validation->set_rules('amount','Amount',"trim|required");
			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
			if ($this->form_validation->run() == FALSE)
			{
					$this->layout->load($this->template, 'withdraw');
			}
			else
			{	
				if($this->template['wallet_total'] > 9)
				{
					$amount = $this->input->post('amount');
					$account = $this->input->post('account');
					if($amount > $this->template['wallet_total'])
					{
						$this->session->set_flashdata('notification', "Amount entered is greater that your wallet amount.");
						$this->layout->load($this->template, 'withdraw');
					}else{
						$today = date('Y-m-d');
						$data = array(
							'user_id' => $user_id,
							'amount ' => $amount,
							'account ' => $account,
							'date_created' => $today,
							'is_active' => 0
						); 
						$request_id = $this->member_model->insert_withdraw_request($data);
						if($request_id > 0)
						{
							$data_user_trans = array(
								'user_id' => $user_id,
								'trans_type' => 'debit',
								'amount' => $amount,
								'trans_reason' => 'withdraw',  
								'date_created' => $today
								);  
							$user_transaction_id = $this->member_model->insert_user_transaction($data_user_trans);
							$this->member_model->debit_user_wallet($user_id,$amount);
							$this->session->set_flashdata('notification', "Withdraw request sent successfully.");
							redirect('member/withdrawrequests');
						}
					}
				}else{
					$this->session->set_flashdata('notification', "You do not have enough amount in your wallet to withdraw.");
					$this->layout->load($this->template, 'withdraw');
				}
			}
			
		}else{
			redirect('member/login');
		}

	}
	function package() 
	{
		$this->template['selectpage'] = 2;
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){	
			//get advertiser data
			$user = $this->member_model->get_user_by_id($_SESSION['user_id']); 
			$this->template['plans']  = $this->member_model->get_all_plans();
			$this->template['activeplan']  = $_SESSION['user_plan'];
			/*if(isset($user['is_paid']) && ($user['is_paid'] ==1)){
				$this->session->set_flashdata('notification', "You are a paid member, no need to buy any package.");
				redirect('member/dashboard');	
			}*/
	
			$this->layout->load($this->template, 'package');
		}else{
			redirect('member/login');
		}
	}
	
	function thanks() 
	{
		
			if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){	
		
			$this->layout->load($this->template, 'thanks');
		}else{
			redirect('member/login');
		}
	}
	
	function signup() {

		 $this->load->library('form_validation');
		 $this->form_validation->CI =& $this;		 
			 
		
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('member/login');
		}
		
				$this->form_validation->set_rules('first_name','First Name',"trim|required");
				$this->form_validation->set_rules('last_name','last Name',"trim|required");
				$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
				$this->form_validation->set_rules('phone','Phone',"trim|required"); //|numeric|min_length[4]|max_length[10]
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
						   $activation_key = md5(rand(100,10000));
						   $display_key = $this->user->encryptval($this->input->post('password'));
						   $ref_code = $this->input->post('ref_code');
						   $email = $this->input->post('email');
						   $email_data = explode("@",$email);
						   $my_ref_num = $email_data[0].substr(time(),0,4).rand(10000 , 99999);
						   if($ref_code != "")
						   {
								$ref_user = $this->member_model->get_user_by_ref_code($ref_code);
								if(isset($ref_user['id']) && $ref_user['id'] > 0)  
								{
									$ref_id = $ref_user['id'];
								}else{
									$this->session->set_flashdata('notification', "The Refferal Code that you entered is not correct, please enter valid Refferal Code.");
									$this->layout->load($this->template, 'signup');
									return false;
								}
							}else{
								$ref_id = 0;
							}
							$today_date = date('Y-m-d');
							//$phone = $this->input->post('countryCode')."-".$this->input->post('phone');
							$data = array(
										'fname' => $this->input->post('first_name'),
										'lname ' => $this->input->post('last_name'),
										'email' => $this->input->post('email'),
										'countrycode' => $this->input->post('countryCode'),
										'phone' => $this->input->post('phone'),
										'password' => $this->user->_prep_password($this->input->post('password')),
										'display_key' => $display_key,
										'ref_code_used' =>  $ref_code,
										'ref_id' => $ref_id,
										'my_ref_code' => $my_ref_num,
										'activation_key' => $activation_key,
										'created_date' => $today_date,
										'status' => 'active',
										'is_active' => 0
										
								); 
								$user_id = $this->member_model->insert_user($data);
								$user = $this->member_model->get_user_by_id($user_id);
								
														
								if(isset($user['id']) && $user['id'] > 0)
								{
									$confirmlink = base_url()."member/activate/".$user['activation_key'];
									$from = 'CrypGrow <support@crypgrow.com>';
									$name = $this->input->post('first_name');
									$lname = $this->input->post('last_name');
									$to = $this->input->post('email');
									$subject = 'Welcome to CrypGrow';
									$message ='<p>Hello and welcome to the Real World of CrypGrow. CrypGrow bring the right people together to challenge established thinking and drive transformation. We will show the way to successive. We hope you have a blast with the app and please be sure to tell all of your friends so they can join you. Please click the link below to confirm your account.</p>
									<p><a href="'.$confirmlink.'">'.$confirmlink.'</a></p>
									<p>Thank you again,</p>
									<p>Team CrypGrow</p>';
									$headers = "From: $from";
									$alldata='Hello '.$name.' '.$lname.', '.$message ;
									$semi_rand = md5(time());
									$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
							    	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
									$message1='<!DOCTYPE HTML><html>
												<head>
												<meta charset="utf-8">
												<title>index</title>
												<meta name="description" content="" />
												<meta name="keywords" content="" />
												</head>
												<body style="margin:0px; padding:0px; background:#efefef;">
												<table width="100%" border="0" style="background:#efefef;" cellspacing="0" cellpadding="0">
												<tr>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0">
														<tr>
														<td><table width="100%" border="0" style="background-color:rgb(72, 54, 191);" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left" style="padding:10px; text-align:center;"><img src="'.base_url().'application/views/themes/vjpro/img/logo.png" alt=""/></td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td style=" background-color:rgb(72, 54, 191);"><table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td style="width:20%; padding-top:10px;"><hr style="color:rgb(255,255,255)" width="100%" size="1" align="left"></td>
																<td style="width:60%; padding-top:10px; font-size:16px; font-weight:bold; text-align:center; line-height:24px; color:#fff; text-transform:uppercase; font-family:Arial, Helvetica, sans-serif;">'.$subject.'</td>
																<td style="width:20%; padding-top:10px;"><hr style="color:rgb(255,255,255)" width="100%" size="1" align="right"></td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left"><img src="'.base_url().'application/views/themes/vjpro/img/emailbanner.jpg" alt=""/></td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td style=" background-color:rgb(255, 255, 255);" align="center">&nbsp;</td>
														</tr>
														<tr>
														<td style=" background-color:rgb(255, 255, 255);" align="center"><table width="550" border="0" cellspacing="10" cellpadding="10">
															<tr>
																<td align="left" style="border:1px solid #000; font-size:13px; color:#000; font-family:Arial, Helvetica, sans-serif; padding:10px;">'. $alldata.'
																</td>
															</tr>
															</table></td>
														</tr>
														<tr>
														<td style=" background-color:rgb(255, 255, 255);" align="center">&nbsp;</td>
														</tr>
														<tr>
														<td><table width="100%" border="0" cellspacing="0" cellpadding="4">
															<tr>
																<td align="center" style="background:rgb(60, 60, 61);">&nbsp;</td>
															</tr>
															<tr>
																<td align="center" style="background:rgb(60, 60, 61); font-size:13px; color:#fff; font-family:Arial, Helvetica, sans-serif;">COPYRIGHT &copy; CrypGrow '.date('Y').' ALL RIGHTS RESERVED</td>
															</tr>
															<tr>
																<td align="center" style="background:rgb(60, 60, 61);">&nbsp;</td>
															</tr>
															</table></td>
														</tr>
													</table>
													<!--template end-->
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
												</table>
												</body>
												</html>';
									$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" .$message1 . "\n\n";
									$message .= "--{$mime_boundary}\n";
									mail($to, $subject, $message, $headers);
									$this->session->set_flashdata('notification', "Your account created successfully, Please check your email to proceed further.");
									redirect('member/signup');
								    
								}else {
								  $this->session->set_flashdata('notification', "Some problem to save data, please try again");
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
			//$this->session->set_flashdata('notification', "");
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
							$_SESSION['user_id'] = $user['id'];
							$_SESSION['first_name'] = $user['fname'];
							$_SESSION['last_name'] = $user['lname'];
							$_SESSION['user_plan'] = $user['user_plan'];
							$_SESSION['user_plan'] = $user['user_plan'];
							$_SESSION['is_paid'] = $user['is_paid'];
							redirect('member/dashboard');
						}
						else
						{
							$this->session->set_flashdata('notification', "You have entered an invalid useremail or password.");
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
	function activate($activation_key="")
	{
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
		    redirect('member/dashboard');
		}
		if($activation_key != "")
		{
			$user = $this->member_model->get_user_by_key($activation_key);
			//echo "<pre>"; print_r($user); exit;
			if(isset($user[0]['id']) && $user[0]['id'] > 0)
			{
				if(isset($user[0]['is_active']) && $user[0]['is_active'] > 0)
				{
					$newkey = md5(rand(100,10000));
					$user_id = $user[0]['id'];
					$data = array('activation_key'=> $newkey);
					$this->member_model->update_user($user_id, $data);
					redirect('member/login');
				}
			}else{
				$this->template['stat'] = 0; 
				$this->session->set_flashdata('notification', "Seems this link has expired, please contact contact Admin.");
				$this->layout->load($this->template, 'activateuser');//$this->layout->load($this->template, 'activate');
			}
		}else{
			$this->template['stat'] = 0;
			$this->session->set_flashdata('notification', "You seems opening a wrong link.");
			$this->layout->load($this->template, 'activateuser');
		}
	}
	function dashboard()
	{	
		$this->template['selectpage'] = 1;
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		  {
		     
			  //if($_SESSION['is_paid']==1){
				$this->template['userdetail']=$this->member_model->get_user_by_id($_SESSION['user_id']);	
				$this->template['myplans']=$this->member_model->get_admin_approve($_SESSION['user_id']);	
				$this->template['totalinvested']=$this->member_model->get_user_total_invested($_SESSION['user_id']);	
				$this->template['totalwithdrawn']=$this->member_model->get_user_total_withdrawn($_SESSION['user_id']);		 
				$this->template['totalwallet']=$this->member_model->get_user_total_wallet($_SESSION['user_id']); 
				  //if(isset($userdata[0]['is_confirmed']) && ($userdata[0]['is_confirmed'] == 0)){
				   //  $this->session->set_flashdata('notification',"You already requested for transaction apporval. Please wait untill admin approve your transaction.");
			        // redirect('member/package');
				  //}	
				          
		     // }
			  $this->template['user_detail'] = $this->member_model->get_user_by_id($_SESSION['user_id']);
		     $this->layout->load($this->template, 'dashboard');
		   
		  }else{
		   $this->session->set_flashdata('notification',"You are not login.");
		   redirect('member/login');
		
		} 
		
	}
	function editprofile() 
	{
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id'];
			$this->template['userdetail'] = $this->member_model->get_user_by_id($user_id);

			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'member';
			$this->form_validation->set_rules('first_name','First Name',"trim|required");
			$this->form_validation->set_rules('last_name','Last Name',"trim|required");
			$this->form_validation->set_rules('phone', "Mobile","trim|required");	//|callback__verify_mail
			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');	

			if ($this->form_validation->run() == FALSE)
			{	 
				$this->layout->load($this->template, 'editprofile');
			}
			else
			{
				$data = array(
				'fname' => $this->input->post('first_name'),
				'lname' => $this->input->post('last_name'),
				'countrycode' => $this->input->post('countryCode'),
				'phone' => $this->input->post('phone'),
				'modified_date' => date('Y-m-d H:i:s')
				);
				$_SESSION['first_name'] = $this->input->post('first_name');
				$_SESSION['last_name'] = $this->input->post('last_name');
				$this->member_model->update_user($user_id, $data);	
				$this->template['userdetail'] = $this->member_model->get_user_by_id($user_id);
				$this->session->set_flashdata('notification', "Profile edited successfully.");
				redirect("member/editprofile");
			}
		
		}else{
			redirect("member/login");
		}

	}
	function payout()
	{
		$today = date('Y-m-d');
		$user_plans = $this->member_model->get_user_active_plans(); //echo "<pre>"; print_r($user_plans); exit;
		for($i=0;$i<count($user_plans);$i++)
		{
			$plan_end_date = $user_plans[$i]['plan_end_date'];
			if($today > $plan_end_date){ // If Plans end date is crossed, then we closing the Plan
				$data=array('is_close'=>1);
				$this->member_model->end_user_plans($user_plans[$i]['user_id'], $data);
				echo "Plan Ended successfully, User Plan ID: ".$user_plans[$i]['user_id']; echo "</br>";
			}else{ 
				// CODE TO PAY PAYOUT START HERE
				$today_updated = $this->member_model->get_today_updated_payout($user_plans[$i]['id'], $user_plans[$i]['user_id']);
				if($today_updated == 0) // Checking if payout of this plan is paid today or not
				{
					//Checking total payout+commission paid to this user today 
					$sum_paid_today_to_user = $this->member_model->total_paid_to_user_today($user_plans[$i]['user_id']);

					$pay_amount = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
					$expected_amount = $sum_paid_today_to_user + $pay_amount; //Adding commision + the amout which user has earned today.
					if($expected_amount <= $user_plans[$i]['payment_amount']) //If amount is less to the limit that he can earn per day.
					{
						$amt = $pay_amount;
					}else{
						$amt = ($sum_paid_today_to_user + $pay_amount) - $user_plans[$i]['payment_amount']; //Making 
						if($amt < 0){ $amt = 0; }
					}

					$data=array(
						'user_id' => $user_plans[$i]['user_id'],
						'trans_type ' => 'credit',
						'amount' => $amt,
						'would_be_amount' => $pay_amount, 
						'payout_plan_id' => $user_plans[$i]['id'],
						'trans_reason' => 'payout',
						'date_created' => $today
					); 
					$payout_id = $this->member_model->insert_payout($data);
					if($payout_id > 0)
					{
						$this->member_model->update_user_transaction($user_plans[$i]['user_id'], $amt);
						echo "Payout Added for User_id: ".$user_plans[$i]['user_id']; echo "<br/>";
					}
				}
				
				//CODE TO PAY FOR LEVEL ONE START HERE.
				$userdetail1 = $this->member_model->get_user_by_id($user_plans[$i]['user_id']);
				if(isset($userdetail1['ref_code_used']) && $userdetail1['ref_code_used'] != "")
				{ 
					$userlevel1 = $this->member_model->get_user_by_refcode($userdetail1['ref_code_used']);
					if(isset($userlevel1['user_plan']) && $userlevel1['user_plan'] > 0 && ($userlevel1['is_paid'] > 0 ))
					{	
						$today_updated_level1 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel1['id']); 
						if($today_updated_level1 == 0) // Checking if payout of this plan is paid today or not
						{
							$user_plan_price_level1 = $this->member_model->get_user_plan_amount_by_id($userlevel1['user_plan']);

							$sum_paid_today_to_user_level1 = $this->member_model->total_paid_to_user_today($userlevel1['id']);
							$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
							$plan_perday_level1 = ($plan_per_day_payout * 5)/100; 

							$expected_amount_level1 = $sum_paid_today_to_user_level1 + $plan_perday_level1;
							if($expected_amount_level1 <= $user_plan_price_level1) //If amount is less to the limit that he can earn per day.
							{
								$amt1 = $plan_perday_level1;
							}else{
								$amt1 = ($sum_paid_today_to_user_level1 + $plan_perday_level1) - $user_plan_price_level1; //Making 
								if($amt1 < 0){ $amt1 = 0; }
							}
							$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
							$data1=array(
								'user_id' => $userlevel1['id'],
								'trans_type ' => 'credit',
								'amount' => $amt1,
								'would_be_amount' => $plan_perday_level1, 
								'comm_by_plan_id' => $user_plans[$i]['id'],
								'comm_by_level' => 1,
								'comm_by_user_id' => $userdetail1['id'],
								'comm_by_username' => $comm_by_username,
								'trans_reason' => 'commission',
								'date_created' => $today
							); 
							$payout_id_level1 = $this->member_model->insert_payout($data1);
							if($payout_id_level1 > 0)
							{
								$this->member_model->update_user_transaction($userlevel1['id'], $amt1);
								echo "Payout Added for User_id: ".$userlevel1['id']; echo "<br/>";
							}
						}

						//CODE TO PAY FOR LEVEL SECOND HERE.
						if(isset($userlevel1['ref_code_used']) && $userlevel1['ref_code_used'] != "")
						{
							$userlevel2 = $this->member_model->get_user_by_refcode($userlevel1['ref_code_used']);
							if(isset($userlevel2['user_plan']) && $userlevel2['user_plan'] > 0 && ($userlevel2['is_paid'] > 0 ))
							{
								$user_level2_active_downline = $this->member_model->get_num_active_downline($userlevel2['id']);
								if($user_level2_active_downline >= 2)
								{
									$today_updated_level2 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel2['id']);
									if($today_updated_level2 == 0)
									{
										$user_plan_price_level2 = $this->member_model->get_user_plan_amount_by_id($userlevel2['user_plan']);
										$sum_paid_today_to_user_level2 = $this->member_model->total_paid_to_user_today($userlevel2['id']);
										$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
										$plan_perday_level2 = ($plan_per_day_payout * 4)/100; 

										$expected_amount_level2 = $sum_paid_today_to_user_level2 + $plan_perday_level2;
										if($expected_amount_level2 <= $user_plan_price_level2) //If amount is less to the limit that he can earn per day.
										{
											$amt2 = $plan_perday_level2;
										}else{
											$amt2 = ($sum_paid_today_to_user_level2 + $plan_perday_level2) - $user_plan_price_level2; //Making 
											if($amt2 < 0){ $amt2 = 0; }
										}	
										$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
										$data2=array(
											'user_id' => $userlevel2['id'],
											'trans_type ' => 'credit',
											'amount' => $amt2,
											'would_be_amount' => $plan_perday_level2, 
											'comm_by_plan_id' => $user_plans[$i]['id'],
											'comm_by_level' => 2,
											'comm_by_user_id' => $userdetail1['id'],
											'comm_by_username' => $comm_by_username,
											'trans_reason' => 'commission',
											'date_created' => $today
										);
										$payout_id_level2 = $this->member_model->insert_payout($data2);
										if($payout_id_level2 > 0)
										{
											$this->member_model->update_user_transaction($userlevel2['id'], $amt2);
											echo "Payout Added for User_id: ".$userlevel2['id']; echo "<br/>";
										}
									}
								}
							}

							//CODE TO PAY FOR LEVEL THIRD HERE.
							if(isset($userlevel2['ref_code_used']) && $userlevel2['ref_code_used'] != "")
							{
								$userlevel3 = $this->member_model->get_user_by_refcode($userlevel2['ref_code_used']);
								if(isset($userlevel3['user_plan']) && $userlevel3['user_plan'] > 0 && ($userlevel3['is_paid'] > 0 ))
								{
									$user_level3_active_downline = $this->member_model->get_num_active_downline($userlevel3['id']);
									if($user_level3_active_downline >= 3)
									{
										$today_updated_level3 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel3['id']);
										if($today_updated_level3 == 0)
										{
											$user_plan_price_level3 = $this->member_model->get_user_plan_amount_by_id($userlevel3['user_plan']);
											$sum_paid_today_to_user_level3 = $this->member_model->total_paid_to_user_today($userlevel3['id']);
											$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
											$plan_perday_level3 = ($plan_per_day_payout * 3)/100; 

											$expected_amount_level3 = $sum_paid_today_to_user_level3 + $plan_perday_level3;
											if($expected_amount_level3 <= $user_plan_price_level3) //If amount is less to the limit that he can earn per day.
											{
												$amt3 = $plan_perday_level3;
											}else{
												$amt3 = ($sum_paid_today_to_user_level3 + $plan_perday_level3) - $user_plan_price_level3; //Making 
												if($amt3 < 0){ $amt3 = 0; }
											}	
											$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
											$data3=array(
												'user_id' => $userlevel3['id'],
												'trans_type ' => 'credit',
												'amount' => $amt3,
												'would_be_amount' => $plan_perday_level3, 
												'comm_by_plan_id' => $user_plans[$i]['id'],
												'comm_by_level' => 3,
												'comm_by_user_id' => $userdetail1['id'],
												'comm_by_username' => $comm_by_username,
												'trans_reason' => 'commission',
												'date_created' => $today
											);
											$payout_id_level3 = $this->member_model->insert_payout($data3);
											if($payout_id_level3 > 0)
											{
												$this->member_model->update_user_transaction($userlevel3['id'], $amt3);
												echo "Payout Added for User_id: ".$userlevel3['id']; echo "<br/>";
											}
										}
									}

									//CODE TO PAY FOR LEVEL FOURTH HERE.
									if(isset($userlevel3['ref_code_used']) && $userlevel3['ref_code_used'] != "")
									{
										$userlevel4 = $this->member_model->get_user_by_refcode($userlevel3['ref_code_used']);
										if(isset($userlevel4['user_plan']) && $userlevel4['user_plan'] > 0 && ($userlevel4['is_paid'] > 0 ))
										{
											$user_level4_active_downline = $this->member_model->get_num_active_downline($userlevel4['id']);
											if($user_level4_active_downline >= 4)
											{
												$today_updated_level4 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel3['id']);
												if($today_updated_level4 == 0)
												{
													$user_plan_price_level4 = $this->member_model->get_user_plan_amount_by_id($userlevel4['user_plan']);
													$sum_paid_today_to_user_level4 = $this->member_model->total_paid_to_user_today($userlevel4['id']);
													$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
													$plan_perday_level4 = ($plan_per_day_payout * 2)/100; 
		
													$expected_amount_level4 = $sum_paid_today_to_user_level4 + $plan_perday_level4;
													if($expected_amount_level4 <= $user_plan_price_level4) //If amount is less to the limit that he can earn per day.
													{
														$amt4 = $plan_perday_level4;
													}else{
														$amt4 = ($sum_paid_today_to_user_level4 + $plan_perday_level4) - $user_plan_price_level4; //Making 
														if($amt4 < 0){ $amt4 = 0; }
													}	
													$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
													$data4=array(
														'user_id' => $userlevel4['id'],
														'trans_type ' => 'credit',
														'amount' => $amt4,
														'would_be_amount' => $plan_perday_level4, 
														'comm_by_plan_id' => $user_plans[$i]['id'],
														'comm_by_level' => 4,
														'comm_by_user_id' => $userdetail1['id'],
														'comm_by_username' => $comm_by_username,
														'trans_reason' => 'commission',
														'date_created' => $today
													);
													$payout_id_level4 = $this->member_model->insert_payout($data4);
													if($payout_id_level4 > 0)
													{
														$this->member_model->update_user_transaction($userlevel4['id'], $amt4);
														echo "Payout Added for User_id: ".$userlevel4['id']; echo "<br/>";
													}
												}
											}

											//CODE TO PAY FOR LEVEL FIFTH HERE.
											if(isset($userlevel4['ref_code_used']) && $userlevel4['ref_code_used'] != "")
											{
												$userlevel5 = $this->member_model->get_user_by_refcode($userlevel4['ref_code_used']);
												if(isset($userlevel5['user_plan']) && $userlevel5['user_plan'] > 0 && ($userlevel5['is_paid'] > 0 ))
												{
													$user_level5_active_downline = $this->member_model->get_num_active_downline($userlevel5['id']);
													if($user_level5_active_downline >= 5)
													{
														$today_updated_level5 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel4['id']);
														if($today_updated_level5 == 0)
														{
															$user_plan_price_level5 = $this->member_model->get_user_plan_amount_by_id($userlevel5['user_plan']);
															$sum_paid_today_to_user_level5 = $this->member_model->total_paid_to_user_today($userlevel5['id']);
															$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
															$plan_perday_level5 = ($plan_per_day_payout * 1)/100; 
				
															$expected_amount_level5 = $sum_paid_today_to_user_level5 + $plan_perday_level5;
															if($expected_amount_level5 <= $user_plan_price_level5) //If amount is less to the limit that he can earn per day.
															{
																$amt5 = $plan_perday_level5;
															}else{
																$amt5 = ($sum_paid_today_to_user_level5 + $plan_perday_level5) - $user_plan_price_level5; //Making 
																if($amt5 < 0){ $amt5 = 0; }
															}	
															$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
															$data5=array(
																'user_id' => $userlevel5['id'],
																'trans_type ' => 'credit',
																'amount' => $amt5,
																'would_be_amount' => $plan_perday_level5, 
																'comm_by_plan_id' => $user_plans[$i]['id'],
																'comm_by_level' => 5,
																'comm_by_user_id' => $userdetail1['id'],
																'comm_by_username' => $comm_by_username,
																'trans_reason' => 'commission',
																'date_created' => $today
															);
															$payout_id_level5 = $this->member_model->insert_payout($data5);
															if($payout_id_level5 > 0)
															{
																$this->member_model->update_user_transaction($userlevel5['id'], $amt5);
																echo "Payout Added for User_id: ".$userlevel5['id']; echo "<br/>";
															}
														}
													}

													//CODE TO PAY FOR LEVEL SIXTH HERE.
													if(isset($userlevel5['ref_code_used']) && $userlevel5['ref_code_used'] != "")
													{
														$userlevel6 = $this->member_model->get_user_by_refcode($userlevel5['ref_code_used']);
														if(isset($userlevel6['user_plan']) && $userlevel6['user_plan'] > 0 && ($userlevel6['is_paid'] > 0 ))
														{
															$user_level6_active_downline = $this->member_model->get_num_active_downline($userlevel6['id']);
															if($user_level6_active_downline >= 5)
															{
																$today_updated_level6 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel5['id']);
																if($today_updated_level6 == 0)
																{
																	$user_plan_price_level6 = $this->member_model->get_user_plan_amount_by_id($userlevel6['user_plan']);
																	$sum_paid_today_to_user_level6 = $this->member_model->total_paid_to_user_today($userlevel6['id']);
																	$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
																	$plan_perday_level6 = ($plan_per_day_payout * 0.5)/100; 
						
																	$expected_amount_level6 = $sum_paid_today_to_user_level6 + $plan_perday_level6;
																	if($expected_amount_level6 <= $user_plan_price_level6) //If amount is less to the limit that he can earn per day.
																	{
																		$amt6 = $plan_perday_level6;
																	}else{
																		$amt6 = ($sum_paid_today_to_user_level6 + $plan_perday_level6) - $user_plan_price_level6; //Making 
																		if($amt6 < 0){ $amt6 = 0; }
																	}	
																	$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
																	$data6=array(
																		'user_id' => $userlevel6['id'],
																		'trans_type ' => 'credit',
																		'amount' => $amt6,
																		'would_be_amount' => $plan_perday_level6, 
																		'comm_by_plan_id' => $user_plans[$i]['id'],
																		'comm_by_level' => 6,
																		'comm_by_user_id' => $userdetail1['id'],
																		'comm_by_username' => $comm_by_username,
																		'trans_reason' => 'commission',
																		'date_created' => $today
																	);
																	$payout_id_level6 = $this->member_model->insert_payout($data6);
																	if($payout_id_level6 > 0)
																	{
																		$this->member_model->update_user_transaction($userlevel6['id'], $amt6);
																		echo "Payout Added for User_id: ".$userlevel6['id']; echo "<br/>";
																	}
																}
															}

															//CODE TO PAY FOR LEVEL SEVEN HERE.
															if(isset($userlevel6['ref_code_used']) && $userlevel6['ref_code_used'] != "")
															{
																$userlevel7 = $this->member_model->get_user_by_refcode($userlevel6['ref_code_used']);
																if(isset($userlevel7['user_plan']) && $userlevel7['user_plan'] > 0 && ($userlevel7['is_paid'] > 0 ))
																{
																	$user_level7_active_downline = $this->member_model->get_num_active_downline($userlevel7['id']);
																	if($user_level7_active_downline >= 5)
																	{
																		$today_updated_level7 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel7['id']);
																		if($today_updated_level7 == 0)
																		{
																			$user_plan_price_level7 = $this->member_model->get_user_plan_amount_by_id($userlevel7['user_plan']);
																			$sum_paid_today_to_user_level7 = $this->member_model->total_paid_to_user_today($userlevel7['id']);
																			$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
																			$plan_perday_level7 = ($plan_per_day_payout * 0.25)/100; 
								
																			$expected_amount_level7 = $sum_paid_today_to_user_level7 + $plan_perday_level7;
																			if($expected_amount_level7 <= $user_plan_price_level7) //If amount is less to the limit that he can earn per day.
																			{
																				$amt7 = $plan_perday_level7;
																			}else{
																				$amt7 = ($sum_paid_today_to_user_level7 + $plan_perday_level7) - $user_plan_price_level7; //Making 
																				if($amt7 < 0){ $amt7 = 0; }
																			}	
																			$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
																			$data7=array(
																				'user_id' => $userlevel7['id'],
																				'trans_type ' => 'credit',
																				'amount' => $amt7,
																				'would_be_amount' => $plan_perday_level7, 
																				'comm_by_plan_id' => $user_plans[$i]['id'],
																				'comm_by_level' => 7,
																				'comm_by_user_id' => $userdetail1['id'],
																				'comm_by_username' => $comm_by_username,
																				'trans_reason' => 'commission',
																				'date_created' => $today
																			);
																			$payout_id_level7 = $this->member_model->insert_payout($data7);
																			if($payout_id_level7 > 0)
																			{
																				$this->member_model->update_user_transaction($userlevel7['id'], $amt7);
																				echo "Payout Added for User_id: ".$userlevel7['id']; echo "<br/>";
																			}
																		}
																	}

																	//CODE TO PAY FOR LEVEL EIGHT HERE.
																	if(isset($userlevel7['ref_code_used']) && $userlevel7['ref_code_used'] != "")
																	{
																		$userlevel8 = $this->member_model->get_user_by_refcode($userlevel7['ref_code_used']);
																		if(isset($userlevel8['user_plan']) && $userlevel8['user_plan'] > 0 && ($userlevel8['is_paid'] > 0 ))
																		{
																			$user_level8_active_downline = $this->member_model->get_num_active_downline($userlevel8['id']);
																			if($user_level8_active_downline >= 5)
																			{
																				$today_updated_level8 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel8['id']);
																				if($today_updated_level8 == 0)
																				{
																					$user_plan_price_level8 = $this->member_model->get_user_plan_amount_by_id($userlevel8['user_plan']);
																					$sum_paid_today_to_user_level8 = $this->member_model->total_paid_to_user_today($userlevel8['id']);
																					$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
																					$plan_perday_level8 = ($plan_per_day_payout * 0.25)/100; 
										
																					$expected_amount_level8 = $sum_paid_today_to_user_level8 + $plan_perday_level8;
																					if($expected_amount_level8 <= $user_plan_price_level8) //If amount is less to the limit that he can earn per day.
																					{
																						$amt8 = $plan_perday_level8;
																					}else{
																						$amt8 = ($sum_paid_today_to_user_level8 + $plan_perday_level8) - $user_plan_price_level8; //Making 
																						if($amt8 < 0){ $amt8 = 0; }
																					}	
																					$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
																					$data8=array(
																						'user_id' => $userlevel8['id'],
																						'trans_type ' => 'credit',
																						'amount' => $amt8,
																						'would_be_amount' => $plan_perday_level8, 
																						'comm_by_plan_id' => $user_plans[$i]['id'],
																						'comm_by_level' => 8,
																						'comm_by_user_id' => $userdetail1['id'],
																						'comm_by_username' => $comm_by_username,
																						'trans_reason' => 'commission',
																						'date_created' => $today
																					);
																					$payout_id_level8 = $this->member_model->insert_payout($data8);
																					if($payout_id_level8 > 0)
																					{
																						$this->member_model->update_user_transaction($userlevel8['id'], $amt8);
																						echo "Payout Added for User_id: ".$userlevel8['id']; echo "<br/>";
																					}
																				}
																			}

																			//CODE TO PAY FOR LEVEL NINTH HERE.
																			if(isset($userlevel8['ref_code_used']) && $userlevel8['ref_code_used'] != "")
																			{
																				$userlevel9 = $this->member_model->get_user_by_refcode($userlevel8['ref_code_used']);
																				if(isset($userlevel9['user_plan']) && $userlevel9['user_plan'] > 0 && ($userlevel9['is_paid'] > 0 ))
																				{
																					$user_level9_active_downline = $this->member_model->get_num_active_downline($userlevel9['id']);
																					if($user_level9_active_downline >= 5)
																					{
																						$today_updated_level9 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel9['id']);
																						if($today_updated_level9 == 0)
																						{
																							$user_plan_price_level9 = $this->member_model->get_user_plan_amount_by_id($userlevel9['user_plan']);
																							$sum_paid_today_to_user_level9 = $this->member_model->total_paid_to_user_today($userlevel9['id']);
																							$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
																							$plan_perday_level9 = ($plan_per_day_payout * 0.25)/100; 
												
																							$expected_amount_level9 = $sum_paid_today_to_user_level9 + $plan_perday_level9;
																							if($expected_amount_level9 <= $user_plan_price_level9) //If amount is less to the limit that he can earn per day.
																							{
																								$amt9 = $plan_perday_level9;
																							}else{
																								$amt9 = ($sum_paid_today_to_user_level9 + $plan_perday_level9) - $user_plan_price_level9; //Making 
																								if($amt9 < 0){ $amt9 = 0; }
																							}	
																							$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
																							$data9=array(
																								'user_id' => $userlevel9['id'],
																								'trans_type ' => 'credit',
																								'amount' => $amt9,
																								'would_be_amount' => $plan_perday_level9, 
																								'comm_by_plan_id' => $user_plans[$i]['id'],
																								'comm_by_level' => 9,
																								'comm_by_user_id' => $userdetail1['id'],
																								'comm_by_username' => $comm_by_username,
																								'trans_reason' => 'commission',
																								'date_created' => $today
																							);
																							$payout_id_level9 = $this->member_model->insert_payout($data9);
																							if($payout_id_level9 > 0)
																							{
																								$this->member_model->update_user_transaction($userlevel9['id'], $amt9);
																								echo "Payout Added for User_id: ".$userlevel9['id']; echo "<br/>";
																							}
																						}
																					}

																					//CODE TO PAY FOR LEVEL TENTH HERE.
																					if(isset($userlevel9['ref_code_used']) && $userlevel9['ref_code_used'] != "")
																					{
																						$userlevel10 = $this->member_model->get_user_by_refcode($userlevel9['ref_code_used']);
																						if(isset($userlevel10['user_plan']) && $userlevel10['user_plan'] > 0 && ($userlevel10['is_paid'] > 0 ))
																						{
																							$user_level10_active_downline = $this->member_model->get_num_active_downline($userlevel10['id']);
																							if($user_level10_active_downline >= 5)
																							{
																								$today_updated_level10 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel10['id']);
																								if($today_updated_level10 == 0)
																								{
																									$user_plan_price_level10 = $this->member_model->get_user_plan_amount_by_id($userlevel10['user_plan']);
																									$sum_paid_today_to_user_level10 = $this->member_model->total_paid_to_user_today($userlevel10['id']);
																									$plan_per_day_payout = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
																									$plan_perday_level10 = ($plan_per_day_payout * 0.25)/100; 
														
																									$expected_amount_level10 = $sum_paid_today_to_user_level10 + $plan_perday_level10;
																									if($expected_amount_level10 <= $user_plan_price_level10) //If amount is less to the limit that he can earn per day.
																									{
																										$amt10 = $plan_perday_level10;
																									}else{
																										$amt10 = ($sum_paid_today_to_user_level10 + $plan_perday_level10) - $user_plan_price_level10; //Making 
																										if($amt10 < 0){ $amt10 = 0; }
																									}	
																									$comm_by_username = $userdetail1['fname']." ".$userdetail1['lname'];
																									$data10=array(
																										'user_id' => $userlevel10['id'],
																										'trans_type ' => 'credit',
																										'amount' => $amt10,
																										'would_be_amount' => $plan_perday_level10, 
																										'comm_by_plan_id' => $user_plans[$i]['id'],
																										'comm_by_level' => 10,
																										'comm_by_user_id' => $userdetail1['id'],
																										'comm_by_username' => $comm_by_username,
																										'trans_reason' => 'commission',
																										'date_created' => $today
																									);
																									$payout_id_level10 = $this->member_model->insert_payout($data10);
																									if($payout_id_level10 > 0)
																									{
																										$this->member_model->update_user_transaction($userlevel10['id'], $amt10);
																										echo "Payout Added for User_id: ".$userlevel10['id']; echo "<br/>";
																									}
																								}
																							}
																						}
																					}
																				}

																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}

								}

							}

						}

					}

				}

			}
		}
		echo "Successfully Done.<br/>";
	}

/*	function payout()
	{
		$user_plans = $this->member_model->get_user_active_plans(); //echo "<pre>"; print_r($user_plans); exit;
		for($i=0;$i<count($user_plans);$i++)
		{
			$today_updated = $this->member_model->get_today_updated_payout($user_plans[$i]['id'], $user_plans[$i]['user_id']);
			if($today_updated == 0)
			{
				$today = date('Y-m-d');
				$amt = $user_plans[$i]['price']*$user_plans[$i]['payout']/100;
				$data=array(
					'user_id' => $user_plans[$i]['user_id'],
					'trans_type ' => 'credit',
					'amount' => $amt,
					'payout_plan_id' => $user_plans[$i]['id'],
					'trans_reason' => 'payout',
					'date_created' => $today
				);
				$payout_id = $this->member_model->insert_payout($data);
				if($payout_id > 0)
				{
					$this->member_model->update_user_transaction($user_plans[$i]['user_id'], $amt);
					echo "Payout Added for User_id: ".$user_plans[$i]['user_id']; echo "<br/>";
				}

			}
		}
		echo "Successfully Done.";
	}   */
	function mytransactions($start = 0, $limit =20)
	{	$this->template['selectpage'] = 3;
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$this->template['user_trans'] = $this->member_model->get_user_transaction_by_id($_SESSION['user_id'], $start, $limit);	

			$this->load->library('pagination');
			$config['uri_segment'] = 3;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/mytransactions');
			$config['total_rows'] = $this->member_model->get_user_transaction_by_id_count($_SESSION['user_id']);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;

			$this->layout->load($this->template,'mytransactions');
		}else{
			$this->session->set_flashdata('notification',"You are not login.");
			redirect('member/login');
		} 
	}

	function withdrawrequests()
	{	$this->template['selectpage'] = 4;
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$this->template['user_withdraws'] = $this->member_model->get_user_withdraws($_SESSION['user_id']);	
			$this->layout->load($this->template,'withdrawrequests');
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

	
	function mydownline()
	{
		$this->template['selectpage'] = 6;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$downline_com = $this->member_model->get_my_total_ref($_SESSION['user_id']); //echo "<pre>"; print_r($downline_com); exit;
			$this->template['totalref'] = $downline_com[0]['com'];
			$this->template['total_could_be_com'] = $downline_com[0]['could_be_com'];
			$this->template['mydownline'] = $this->member_model->get_my_downline($_SESSION['user_id']);
			$this->layout->load($this->template, 'mydownline');
			
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
	function forgotpassword()
	{	
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('member/dashboard');
		}else{
			$user_id = $_SESSION['user_id'];
			
				//$this->template['title'] = "Change your password" ;
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('email','Email',"trim|required");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
				if ($this->form_validation->run() == FALSE)
				{
						$this->layout->load($this->template, 'forgotpassword');
				}
				else
				{	
					$email = $this->input->post('email');
					$user = $this->member_model->get_user_by_email($email);
					if(isset($user[0]['id']) && $user[0]['id'] > 0){
						$key = $user[0]['activation_key'];
						$link = site_url('member/updatepassword/'.$key);

						$from = 'CrypGrow <support@crypgrow.com>';
						$name = $user[0]['first_name'];
						$lname = $user[0]['last_name'];
						$to = $this->input->post('email');
						$subject = 'CrypGrow: Password Reset';
						$message ='<p>We received a request to reset the password associated with this e-mail address. If you made this request, please click on the link below.</p>
						<p><a href="'.$link.'">'.$link.'</a></p>
						<p>Thank you again,</p>
						<p>Team CrypGrow</p>';
						$headers = "From: $from";
						$alldata='Hello '.$name.' '.$lname.', '.$message ;
						$semi_rand = md5(time());
						$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
						$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
						$message1='<!DOCTYPE HTML><html>
									<head>
									<meta charset="utf-8">
									<title>index</title>
									<meta name="description" content="" />
									<meta name="keywords" content="" />
									</head>
									<body style="margin:0px; padding:0px; background:#efefef;">
									<table width="100%" border="0" style="background:#efefef;" cellspacing="0" cellpadding="0">
									<tr>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0">
											<tr>
											<td><table width="100%" border="0" style="background-color:rgb(72, 54, 191);" cellspacing="0" cellpadding="0">
												<tr>
													<td align="left" style="padding:10px; text-align:center;"><img src="'.base_url().'application/views/themes/vjpro/img/logo.png" alt=""/></td>
												</tr>
												</table></td>
											</tr>
											<tr>
											<td style=" background-color:rgb(72, 54, 191);"><table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td style="width:20%; padding-top:10px;"><hr style="color:rgb(255,255,255)" width="100%" size="1" align="left"></td>
													<td style="width:60%; padding-top:10px; font-size:16px; font-weight:bold; text-align:center; line-height:24px; color:#fff; text-transform:uppercase; font-family:Arial, Helvetica, sans-serif;">'.$subject.'</td>
													<td style="width:20%; padding-top:10px;"><hr style="color:rgb(255,255,255)" width="100%" size="1" align="right"></td>
												</tr>
												</table></td>
											</tr>
											<tr>
											<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td align="left"><img src="'.base_url().'application/views/themes/vjpro/img/emailbanner.jpg" alt=""/></td>
												</tr>
												</table></td>
											</tr>
											<tr>
											<td style=" background-color:rgb(255, 255, 255);" align="center">&nbsp;</td>
											</tr>
											<tr>
											<td style=" background-color:rgb(255, 255, 255);" align="center"><table width="550" border="0" cellspacing="10" cellpadding="10">
												<tr>
													<td align="left" style="border:1px solid #000; font-size:13px; color:#000; font-family:Arial, Helvetica, sans-serif; padding:10px;">'. $alldata.'
													</td>
												</tr>
												</table></td>
											</tr>
											<tr>
											<td style=" background-color:rgb(255, 255, 255);" align="center">&nbsp;</td>
											</tr>
											<tr>
											<td><table width="100%" border="0" cellspacing="0" cellpadding="4">
												<tr>
													<td align="center" style="background:rgb(60, 60, 61);">&nbsp;</td>
												</tr>
												<tr>
													<td align="center" style="background:rgb(60, 60, 61); font-size:13px; color:#fff; font-family:Arial, Helvetica, sans-serif;">COPYRIGHT &copy; CrypGrow '.date('Y').' ALL RIGHTS RESERVED</td>
												</tr>
												<tr>
													<td align="center" style="background:rgb(60, 60, 61);">&nbsp;</td>
												</tr>
												</table></td>
											</tr>
										</table>
										<!--template end-->
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
									</table>
									</body>
									</html>';
						$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" .$message1 . "\n\n";
						$message .= "--{$mime_boundary}\n";
						mail($to, $subject, $message, $headers);

						$this->session->set_flashdata('notification', "We have sent an email on your registered email address, Please follow the instruction given in email to reset your password.");
						$this->layout->load($this->template, 'forgotpassword');
						return FALSE;
					}else{
						$this->session->set_flashdata('notification', "We do not have any user with this email address in our database.");
						$this->layout->load($this->template, 'forgotpassword');
						return FALSE;
					}
				}
		}
	}

	function updatepassword($key="")
	{
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('member/dashboard');
		}else{
			if($key != "")
			{
				$this->session->set_flashdata('notification', "");
				$this->template['key'] = $key;
				$user = $this->member_model->get_user_by_key($key);
				$this->template['user'] = $user; 
				if(isset($user[0]['id']) && $user[0]['id'] > 0){
					$this->session->set_flashdata('notification', "");
					$this->template['stat'] = 1;
					$this->load->library('form_validation');
					$this->form_validation->CI =& $this;
					$this->form_validation->set_rules('password','New Password',"trim|matches[passconf]|required");
					$this->form_validation->set_rules('passconf', "Confirm Password", "trim|required");
					$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
					$this->form_validation->set_message('required', 'The %s field is required');
					$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
					$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
					if ($this->form_validation->run() == FALSE)
					{
							$this->layout->load($this->template, 'updatepassword');
					}
					else
					{	
						$newkey = md5(rand(100,10000));
						$user_id = $user[0]['id'];
						$display_key = $this->user->encryptval($this->input->post('password'));
						$data = array('password' => $this->user->_prep_password($this->input->post('password')), 'activation_key'=> $newkey, 'display_key'=>$display_key);
							$this->member_model->update_user($user_id, $data);
							$this->session->set_flashdata('notification', "Password Changed Successfully !");
							redirect('member/login');
					}
				
				}else{
					$this->template['stat'] = 0;
					$this->session->set_flashdata('notification', "Seems this link has expired, please goto forgot password again.");
					$this->layout->load($this->template, 'updatepassword');
					//return FALSE;
				}
			}else{
				redirect('member/login');
			}
		}
	}
	function transfer()
	{	$this->template['selectpage'] = 7;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id']; 
			$amount_in_wallet=$this->member_model->get_user_total_wallet($user_id); 
			$this->template['plans'] = $this->member_model->get_all_plans();
			$this->template['totalwallet'] = $amount_in_wallet;
				//$this->template['title'] = "Change your password" ;
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('email','Recipient Email',"trim|required");
				$this->form_validation->set_rules('amount','Amount',"trim|required");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'transfer');
				}
				else
				{	
					$amount = $this->input->post('amount');
					if($amount > $amount_in_wallet)
					{
						$this->session->set_flashdata('notification', "You do not sufficient amount in your wallet.");
						redirect('member/transfer');
					}else{
						$rec_user = $this->member_model->get_user_by_email($this->input->post('email'));
						if(isset($rec_user[0]['id']) && $rec_user[0]['id'] > 0)
						{
							if($rec_user[0]['id'] != $user_id)
							{
								/*$data_user_trans = array(
									'user_id' => $user_id,
									'trans_type' => 'debit',
									'amount' => $amount,
									'trans_reason' => 'withdraw',  
									'date_created' => $today
								);  
								$user_transaction_id = $this->member_model->insert_user_transaction($data_user_trans);
								$this->member_model->debit_user_wallet($user_id,$amount); */
							}else{
								$this->session->set_flashdata('notification', "Please enter recipient email address, not your own.");
								redirect('member/transfer');
							}
						}else{
							$this->session->set_flashdata('notification', "We did not find any user with this email address.");
							redirect('member/transfer');
						}
					}
					
				}
			
		}else{
			redirect('member/login');
		}
	}
	/*change password*/
	function changepassword()
	{	$this->template['selectpage'] = 5;
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
							$display_key = $this->user->encryptval($this->input->post('password'));
							//$data = array('password' => $this->user->_prep_password($this->input->post('password')));
							$data = array('password' => $this->user->_prep_password($this->input->post('password')), 'display_key'=>$display_key);
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