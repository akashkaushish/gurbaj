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
	
	function sendemail($to,$subject,$message,$name){
	        
			include ROOTURLPATH.'cron/phpmailer/src/SMTP.php';
			include ROOTURLPATH.'cron/phpmailer/src/PHPMailer.php';
			include ROOTURLPATH.'cron/phpmailer/src/POP3.php';
			include ROOTURLPATH.'cron/phpmailer/src/OAuth.php';
			$mail = new PHPMailer(true);



try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'bitfxcoinfo@gmail.com';                     // SMTP username
    $mail->Password   = 'Q!W@E#R$T%';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('bitfxcoinfo@gmail.com', 'Bitfx-co');
    $mail->addAddress($to, $name);     // Add a recipient
    $mail->addReplyTo('bitfxcoinfo@gmail.com', 'Bitfx-co');
   // $mail->addCC('cc@example.com');
  //  $mail->addBCC('bcc@example.com');

    // Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
	
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

   if( $mail->send()){
     return true;
   }
   
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	} 
	
	
	
	function _member_signup_header()
	{
		echo '<script src="' .  base_url() . 'application/views/' . $this->system->theme . '/javascript/jquery.validate.pack.js" type="text/javascript"></script>';
	}
	
	function paybywallet($planid=NULL)
	{
		$this->template['selectpage'] = 2;
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){
			$user_plan_id=$this->member_model->get_userplan_by_user_id($_SESSION['user_id']);
			$this->template['activeplan']  = $user_plan_id;
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;	
			$plandata=$this->member_model->get_package_licence_price($planid);
			$this->template['plandata']=$plandata	;
			$this->template['planid']=$planid;
			$userdata = $this->member_model->get_user_by_id($_SESSION['user_id']);
			
			$this->template['userdata']=$userdata;
	    
			  if(isset($planid) && ($planid == 0 )){	
					 $this->session->set_flashdata('error', "You are not a paid member, Please buy any package.");
					 redirect('member/package');	
			   }
			    /*Get Plan Key*/
				
			//user open the direct URL
			if( $plandata['price'] > $userdata['wallet_total']){
			   $this->session->set_flashdata('error', "You don't have sufficient balance in your BitFxCo wallet, You have to use Bitcoin wallet to purchase plan. .");
			    redirect('member/buyplan/'.$planid );
			}	
					
				$this->form_validation->set_rules('transaction_id','Transaction Id',"trim|required"); //|alpha_numeric|min_length[32]|max_length[32]
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				if ($this->form_validation->run() == FALSE)
				{	
					$this->layout->load($this->template, 'paybywallet'); 
				}
				else
				{
					 if($plandata){ 
						 
						
						if($user_plan_id == 0)
						{
							$data = array(
										'plan_id' => $planid,
										'user_id' => $_SESSION['user_id'],
										'transaction_id' => 'Using BitFxCo Wallet',
										'payment_amount' => $plandata['price'],
										'payment_date' => @date('Y-m-d')										
								); 
								$insertplan = $this->member_model->insert_plan($data); 
								
						// enter data in ci_user_transactions
						  
						  
						      $usertransctiondata = array(
										'user_id' => $_SESSION['user_id'],
										'trans_type' => 'debit',
										'purchase_plane_id' => $planid,
										'trans_reason' => 'Plan Purchase',
										'date_created' => @date('Y-m-d')										
								); 
								
								$inserttransction = $this->member_model->insert_user_transaction($usertransctiondata);	
								
								$by_user = $this->member_model->get_user_by_id($_SESSION['user_id']);
								$by_user_id = $by_user['id'];
								$by_user_name = $by_user['fname'].' '.$by_user['lname'];
								$by_ID = $by_user['username'];
								$parent_id = $by_user['ref_id'];
								$plan_id = $planid;
								$amt = $plandata['price'];
								$this->add_business_new($by_user_id, $by_user_name, $by_ID, $parent_id, $plan_id, $amt, 1);
								
								
								if($insertplan)
								{
									
									//update User wallet
								     $updateuserwallet = array('wallet_total' =>$userdata['wallet_total']-$plandata['price']);
							         $this->member_model->update_user($_SESSION['user_id'], $updateuserwallet);
								   //end update User wallet					
									
									$from = 'BitFxCo <support@bitfxco.com>';
									$name = $userdata['fname'];
									$lname = $userdata['lname'];
									$to = $userdata['email'];
									$subject = 'Congrats, for starting a investment plan';
									//$message ='<p>You have successfully started a investment plan on BitFxCo. Now, BitFxCo Admin will confirm your payment transaction number you entered and activate your plan . We will show the way to successive.</p>';
									$headers = "From: $from";
									$alldata='Hello '.$name.' '.$lname.', '.$message ;
									//$semi_rand = md5(time());
									//$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
							    	//$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
									$namedata = 'Hello '.$name.' '.$lname.',';
									$fullname = $name.' '.$lname;
									$subject = 'Congratulations !!';
									$message = 'You have successfully started a investment plan on BitFxCo. Now, BitFxCo Admin will confirm your payment transaction number you entered and activate your plan . We will show the way to successive.';
									$confirmlink = '';
									$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);

									//$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" .$message1 . "\n\n";
									//$message .= "--{$mime_boundary}\n";
									//mail($to, $subject, $message, $headers);
									
									if($this->sendemail($to, $subject, $message1, $fullname)){
										$this->session->set_flashdata('success', "You have successfully started a investment plan on BitFxCo, Please wait untill Admin approve your payment.");                             redirect('member/thanks');
									}else{
									$this->session->set_flashdata('error', "There is some issue, please try after some time.");
									redirect('member/paybywallet');
									}
								   
								}else {
									$this->session->set_flashdata('error', "There is some problem to save your data, please try again");
									redirect('member/paybywallet/'.$planid);
								}
					 		}else{
								$this->session->set_flashdata('error', "You have already purchased this plan, One ID can have only one active plan.");
								redirect('member/paybywallet/'.$planid);
							}
								
					 }else{		     
						$this->session->set_flashdata('error', "You have selected invalid package.");
						redirect('member/package');		  
		              }			
					 
				}
		}else{
				redirect('member/login');
		}	
	}
	
	function getparentuserinfo() 
	{
		
			$userinfo='';
		     $code=$_POST['code'];			 
			 $userinfo=$this->member_model->get_user_by_refcode($code);
			
			 if(isset($userinfo) && ($userinfo !='')){
				echo $userinfo['fname'].' '.$userinfo['lname'].' ('.$userinfo['email'].')'; exit; 
			 }else{
			    echo "0"; exit;
			 }		
	}		
	
	function transferrequest()
	{	$this->template['selectpage'] = 7;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id']; 
			$amount_in_wallet=$this->member_model->get_user_total_wallet($user_id); 
			$today = date('Y-m-d');
			$this->template['plans'] = $this->member_model->get_all_plans();
			$this->template['totalwallet'] = $amount_in_wallet;
				//$this->template['title'] = "Change your password" ;
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('email','Recipient Email',"trim|required");
				$this->form_validation->set_rules('amount','Amount',"trim|required");
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
						$this->session->set_flashdata('error', "You do not have sufficient amount in your wallet.");
						redirect('member/transfer');
					}else{
						
						$receiver_email= $this->input->post('email');
						$rec_user = $this->member_model->get_user_by_ref_code_new($receiver_email);
						
						
						//check user exist in database 
						if(!isset($rec_user[0]['id'])){
						$this->session->set_flashdata('error', "Recipient is not exists in our database.");
							redirect('member/transfer');
						}
						//End check user exist in database  

						date_default_timezone_set('Asia/Kolkata');
						$day_date = date('d'); 
					 	//check If Date is less than 6 
					 	if($day_date > 5){
							$this->session->set_flashdata('error', "You can only tranfer funds between 1st and 5th date of the month.");
							redirect('member/transfer');
						}
						//End check If Date is less than 6
						if($user_id != $rec_user[0]['id'])
						{
					   
					      $data_user_trans_request = array(
									'sender_id' => $user_id,
									'receiver_id' => $rec_user[0]['id'],
									'amount_transfer' => $this->input->post('amount'),
									'is_approved' => 0,
									'created_date' => $today
								);  
						
							$transaction_request_id = $this->member_model->insert_user_transaction_request($data_user_trans_request);
						
							//sent email with approval code
							 if($transaction_request_id){
								$userdata = $this->member_model->get_user_by_id($_SESSION['user_id']); 
								$from = 'BitFxCo <support@bitfxco.com>';
								$name = $userdata['fname'];
								$lname = $userdata['lname'];
								$fullname = $name .' '.$lname;
								$to = $userdata['email'];
								//$key=md5($name.' '.$lname.' '.time());
								$key = rand(1000,10000);;
								$key = $_SESSION['user_id'].$key;
								$subject = 'Congrats, you process a transfer request';
							
								$headers = "From: $from";
							
								$namedata = 'Hello '.$name.' '.$lname.',';
								$subject = 'Verification Code For Transfer !!';
								$message = 'You have initiated a transfer of amount $'.$amount.' to '.$rec_user[0]['fname'].$rec_user[0]['lname'].' ('.$receiver_email.')'.'. <br>The OTP for this transaction is <br><br>'.$key.'. <br><br>To verify your transfer please click in the button below';
								
								//$confirmlink = site_url('member/verifytransfer/'.$key);
								$confirmlink ='';
								$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);
								
								if($this->sendemail($to, $subject, $message1, $fullname)){
								
								   //update the table with key
								   $keydata = array(
									'approvalcode' => $key
								);  
						
						        $update_request = $this->member_model->update_transaction_request($transaction_request_id,$keydata);
								
								    $this->session->set_flashdata('success', "You will receive a verification code (OTP) via email. Please enter that verification code to complete this transaction.");
								    redirect('member/verifytransfer');
								}else{
								
								    $this->session->set_flashdata('error', "Some issue, please try again.");
								    redirect('member/transfer');
								}
								   
						    }else{
						            $this->session->set_flashdata('error', "Request is not saved, please try again.");
								    redirect('member/transfer');
							}
						}else{
							$this->session->set_flashdata('error', "Sender and receiver can not be same.");
							redirect('member/transfer');
						}
				
					}
					
				}
			
		}else{
			redirect('member/login');
		}
	}	
	
	
	
	function pay($planid=NULL)
	{	 
		$this->template['selectpage'] = 2;
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){  
			$user_plan_id=$this->member_model->get_userplan_by_user_id($_SESSION['user_id']);
			$this->template['activeplan']  = $user_plan_id;
	     	$this->load->library('form_validation');
		 	$this->form_validation->CI =& $this;	
		
		 		 
	    
			  if(isset($planid) && ($planid == 0 )){	
					 $this->session->set_flashdata('error', "You are not a paid member, Please buy any package.");
					 redirect('member/package');	
			   }
			    /*Get Plan Key*/
			      $this->template['planid']=$planid;
				
					$add=array("3CAuAWW1Nd43QpvFstGMEY9W2w84m9t7wA","3N5wBmZbz2c3a1PvLup4Cd4bb6aJzNaRoa","3Nc8X6twMgu4mAUDS4GXEMKvFoFLNfyRyJ","3GmE5oSSCF2QxqdcbnMfhmn4f7MHZ2ePdM","3MeYZXqhAwC6rPLXjP8pm3hxQ5nFXhmDKJ", "3AQ2Y7yHkZ4jjUVbp5wx9c3s8LANAjVpZy", "3MHEGkKtTXKFFkjmJisGDQGb6YQ4YFj3UF", "3ByFcVwDT3rizjWM5oxcr41jyhKYpuotEQ", "36vhNV5nVeN53QWcq6zJZeCWmvGMzyyF82", "3BiJucP6ztdXR8VE7eYavbh2cxWppRM9NB");
					$random_address=array_rand($add,1); 
					$this->template['account_address'] = $add[$random_address];
					
				$this->form_validation->set_rules('transaction_id','Transaction Id',"trim|required"); //|alpha_numeric|min_length[32]|max_length[32]
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				if ($this->form_validation->run() == FALSE)
				{	
					$this->layout->load($this->template, 'pay'); 
				}
				else
				{
					 if($plandata=$this->member_model->get_package_licence_price($planid)){ 
						
						if($user_plan_id == 0)
						{
							$data = array(
										'plan_id' => $planid,
										'user_id' => $_SESSION['user_id'],
										'transaction_id' => $this->input->post('transaction_id'),
										'payment_amount' => $plandata['price'],
										'payment_date' => @date('Y-m-d')										
								); 
								$insertplan = $this->member_model->insert_plan($data);
								//$this->add_business($_SESSION['user_id'], $planid, $plandata['price']); 

								$by_user = $this->member_model->get_user_by_id($_SESSION['user_id']);
								$by_user_id = $by_user['id'];
								$by_user_name = $by_user['fname'].' '.$by_user['lname'];
								$by_ID = $by_user['username'];
								$parent_id = $by_user['ref_id'];
								$plan_id = $planid;
								$amt = $plandata['price'];
								$this->add_business_new($by_user_id, $by_user_name, $by_ID, $parent_id, $plan_id, $amt, 1);

								//echo  $this->db->last_query();  exit;
								if($insertplan)
								{
									//$plandata = $this->member_model->get_plan_by_id($insertplan);
									$userdata = $this->member_model->get_user_by_id($_SESSION['user_id']); // echo "<pre>"; print_r($plandata); exit;
									
									$from = 'BitFxCo <support@bitfxco.com>';
									$name = $userdata['fname'];
									$lname = $userdata['lname'];
									$to = $userdata['email'];
									$subject = 'Congrats, for starting a investment plan';
									$message = 'You have successfully started a investment plan on BitFxCo. Now, BitFxCo Admin will confirm your payment transaction number you entered and activate your plan . We will show the way to successive.';
									$headers = "From: $from";
									
									//$semi_rand = md5(time());
									//$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
							    	//$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
									$namedata = 'Hello '.$name.' '.$lname.',';
									$fullname = $name.' '.$lname;
									$subject = 'Congratulations !!';
									
									$confirmlink = '';
									$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);

									

									if($this->sendemail($to, $subject, $message1, $fullname)){
									 $this->session->set_flashdata('success', "You have successfully started a investment plan on BitFxCo, Please wait untill Admin approve your payment.");
									redirect('member/thanks');
									}else{
									  $this->session->set_flashdata('error', "There is some issue, please try after some time.");
									  redirect('member/thanks');
									}
									

									
								   
								}else {
								  $this->session->set_flashdata('error', "There is some problem to save your data, please try again");
									redirect('member/pay/'.$planid);
								}
					 		}else{
								$this->session->set_flashdata('error', "You have already purchased this plan, One ID can have only one active plan.");
								redirect('member/pay/'.$planid);
							}
								
					 }else{		     
						$this->session->set_flashdata('error', "You have selected invalid package.");
						redirect('member/package');		  
		              }			
					 
				}
		}else{
				redirect('member/login');
		}	
	}
	
function editprofileimage($adsid=NULL)
	{
		session_start();    
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		 {

		     $userdata = $this->member_model->get_user_by_id($_SESSION['user_id']);  
			  
			 if(isset($_POST['submit']) &&($_POST['submit'] =='submit')){
			 
			// print_r($_FILES); exit;
			 
			       if ($_FILES['Image']['name'] != '')
				    {
					$allowed_types = array('image/bmp', 'image/x-windows-bmp', 'image/gif', 'image/x-icon', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/tiff');	
					$fileType = $_FILES['Image']['type'];
					$findExt = explode(".",$_FILES['Image']['name']);
					$ext = $findExt[count($findExt)-1];
				    $type=explode('/', $fileType);
						   if (in_array($fileType, $allowed_types)){
										$name = time();
										$imgname = $name.'.'.$ext;
										$filename = 'media/'.$imgname;
										@chmod($filename , 777);
										copy($_FILES['Image']['tmp_name'], $filename);
										$targetPath = 'media/thumb/'.$imgname;
										$this->createThumbnail($_FILES['Image']['tmp_name'], $targetPath, 200 ,$ext); 
										/*delete previous data*/
										$unlinkthumb='/home/bitfeeup/public_html/media/thumb/'.$userdata['photo'];
										$unlinkimage='/home/bitfeeup/public_html/media/'.$userdata['photo'];
										unlink($unlinkthumb);
										unlink($unlinkimage);
										
							}else{
							  $this->template['msg'] = "File type is not correct.";  
							}

			          }else{
						  $imgname=$userdata['photo'];						
					  }
					  
				      $imageupdate = array('photo' => $imgname);	  
				      $userupdate = $this->member_model->update_user($userdata['id'],$imageupdate);	
					  $_SESSION['photo']=$imgname;
					   $this->session->set_flashdata('success', "Your profile image has been updated successfully.");
					  redirect('member/editprofileimage');	  
					  
					  
			 }
		    
			
		
		
			
		$this->layout->load($this->template, 'editprofileimage');	
		}else{
			 redirect('member/login');
	    }	
	}	
	
	
	function withdrawrequest()
	{	$this->template['selectpage'] = 4;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id'];
			$this->template['wallet_total'] = $this->member_model->get_user_total_wallet($user_id);
			$userdata = $this->member_model->get_user_by_id($_SESSION['user_id']); 
			
			
			$alreadyrequestsent = $this->member_model->get_user_withdrawscount($_SESSION['user_id']); 
			
			if($alreadyrequestsent[0]['num'] > 0 ){
			  $this->session->set_flashdata('error', "You already sent a withdraw request to admin, you have to wait untill admin will approve your previous request. Make sure you have done the self verification.");
			  redirect('member/withdrawrequests');
			}
			
			
			
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			$this->form_validation->set_rules('account','Account',"trim|required|alpha_numeric");
			$this->form_validation->set_rules('amount','Amount',"trim|required");
			$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
			if ($this->form_validation->run() == FALSE)
			{
					$this->layout->load($this->template, 'withdrawrequest');
			}
			else
			{	
					$amount = $this->input->post('amount');
					//$amount munts be multi oof 5
					if($amount%5 !=0){
					  $this->session->set_flashdata('error', "You can't withdraw such amount. Its should be multiple of 5");
					  redirect('member/withdrawrequest');
					}
					
					$account = $this->input->post('account');
					if($amount > $this->template['wallet_total'])
					{
						$this->session->set_flashdata('error', "Amount entered is greater that your wallet amount.");
						$this->layout->load($this->template, 'withdrawrequest');
					}else{
						$today = date('Y-m-d');
						//$key=md5($user_id.''.time());
						$key = rand(1000,10000); 
						$pay_amount = ($amount * 95)/100;
						$fee = $amount - $pay_amount;
						$data = array(
							'user_id' => $user_id,
							'amount' => $amount,
							'trans_fee' => $fee,
							'pay_amount' => $pay_amount,
							'account' => $account,
							'approvalcode' => $key,
							'date_created' => $today,
							'is_active' => 0
						); 
						$request_id = $this->member_model->insert_withdraw_request($data);
						if($request_id > 0)
						{
							        
									$from = 'BitFxCo <support@bitfxco.com>';
									$name = $userdata['fname'];
									$lname = $userdata['lname'];
									$to = $userdata['email'];
									
								
									$namedata = 'Hello '.$name.' '.$lname.',';
									$fullname = $name.' '.$lname;
									$subject = 'Withdraw Request Verification Code !!';
									
									$message = 'You have initiated a withdrawrequest of amount $'.$amount.'. <br><br>The OTP for this withdrawrequest is <br><br>'.$key.' <br><br>To Proceed with your withdrawrequest please enter this OTP and verify your transaction.';
									
									$confirmlink = '';
									$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);
									
									if($this->sendemail($to, $subject, $message1, $fullname)){
									 	
                                    $this->session->set_flashdata('success', "You have to verify your withdraw request, check your email for OTP .");
							        redirect('member/withdrawrequests');
									}else{
									$this->session->set_flashdata('error', "There is some issue, please try after some time.");
									  redirect('member/withdrawrequests');
									}
									
								
						}
					}
				
			}
			
		}else{
			redirect('member/login');
		}

	}
	
	function withdraw($id)
	{	
	    $this->template['selectpage'] = 4;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id'];
			$this->template['wallet_total'] = $this->member_model->get_user_total_wallet($user_id);
			$this->template['id'] = $id;
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			$this->form_validation->set_rules('verificationcode','Verification Code',"trim|required");
			$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
			if ($this->form_validation->run() == FALSE)
			{
					$this->layout->load($this->template, 'withdraw');
			}
			else
			{	
				
					
				    $verificationcode = $this->input->post('verificationcode');
					$withdrawdata=$this->member_model->get_user_withdraws_by_code($verificationcode,$id);
				    $amount=$withdrawdata[0]['amount'];
					
					
					if(!is_array($withdrawdata[0])){
					   $this->session->set_flashdata('error', "Your OTP has been expired or may be wrong OTP ");
					   redirect('member/withdrawrequests');
					}
				
				
					if($amount > $this->template['wallet_total'])
					{
						$this->session->set_flashdata('error', "Requested Amount is greater that your wallet amount.");
						$this->layout->load($this->template, 'withdraw');
					}else{
						
						//update the withdraws table
						$withdraw_user_trans = array('is_approved' =>1);  
						$user_transaction_id = $this->member_model->update_withdraws($id,$withdraw_user_trans);
						
						//	
						    $today = date('Y-m-d');					
							$data_user_trans = array(
								'user_id' => $user_id,
								'trans_type' => 'debit',
								'amount' => $amount,
								'trans_reason' => 'withdraw',  
								'date_created' => $today
								);  
							$user_transaction_id = $this->member_model->insert_user_transaction($data_user_trans);
							$this->member_model->debit_user_wallet($user_id,$amount);
							$this->session->set_flashdata('success', "Withdraw request verify successfully.");
							redirect('member/withdrawrequests');
					}
				
			}
			
		}else{
			redirect('member/login');
		}

	}
		
	function withdraw_old()
	{	$this->template['selectpage'] = 4;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id'];
			$this->template['wallet_total'] = $this->member_model->get_user_total_wallet($user_id);
			//$this->template['title'] = "Change your password" ;
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			$this->form_validation->set_rules('account','Account',"trim|required|alpha_numeric");
			$this->form_validation->set_rules('amount','Amount',"trim|required");
			$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
						$this->session->set_flashdata('error', "Amount entered is greater that your wallet amount.");
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
							$this->session->set_flashdata('success', "Withdraw request sent successfully.");
							redirect('member/withdrawrequests');
						}
					}
				}else{
					$this->session->set_flashdata('error', "You do not have enough amount in your wallet to withdraw.");
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
		//if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){	
			//get advertiser data
			$user = $this->member_model->get_user_by_id($_SESSION['user_id']); 
			$this->template['plans']  = $this->member_model->get_all_plans();
			$this->template['activeplan']  = $_SESSION['user_plan'];
			/*if(isset($user['is_paid']) && ($user['is_paid'] ==1)){
				$this->session->set_flashdata('notification', "You are a paid member, no need to buy any package.");
				redirect('member/dashboard');	
			}*/
	
			$this->layout->load($this->template, 'package');
		/*}else{
			redirect('member/login');
		}*/
	}
	
	
	function buyplan($planid) 
	{	
		$this->template['selectpage'] = 2;
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){	
			//get advertiser data
			$user = $this->member_model->get_user_by_id($_SESSION['user_id']); 
			
			$this->template['plans']  = $this->member_model->get_package_licence_price($planid);
			$this->template['planid']  = $planid;
			$this->template['userdata']  = $user;
			$this->template['activeplan']  = $_SESSION['user_plan'];
			
			/*if($this->template['plans']['price'] > $user['wallet_total']){ 
			  $this->session->set_flashdata('error', "You don't have sufficient balance in your BitFxCo wallet, You have to use Bitcoin wallet to purchase plan.");
			}*/
			
	
			$this->layout->load($this->template, 'buyplan');
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
	
	
	function signup_old($ref_code_link='') {

		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;		 
		$this->template['ref_code_link'] = $ref_code_link;	 
		
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('member/login');
		}
		
				$this->form_validation->set_rules('first_name','First Name',"trim|required|max_length[15]");
				$this->form_validation->set_rules('last_name','last Name',"trim|required|max_length[15]");
				$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
				$this->form_validation->set_rules('phone','Phone',"trim|required"); //|numeric|min_length[4]|max_length[10]
				$this->form_validation->set_rules('password','Password',"trim|matches[passconf]|required");
				$this->form_validation->set_rules('passconf', "Confirm", "trim");
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
					      $this->session->set_flashdata('error', "User Already exist, Please try with another email");
					      redirect('member/signup');
				     }
					 else{
					     //Upload company Logo
						   $activation_key = md5(rand(100,10000));
						   $display_key = $this->user->encryptval($this->input->post('password'));
						   $ref_code = $this->input->post('ref_code');
						   $email = $this->input->post('email');
						   $email_data = explode("@",$email);
						   $my_ref_num = $email_data[0].substr(time(),0,2).rand(10000 , 99999);
						   if($ref_code != "")
						   {
								$ref_user = $this->member_model->get_user_by_ref_code($ref_code);
								if(isset($ref_user['id']) && $ref_user['id'] > 0)  
								{
									$ref_id = $ref_user['id'];
								}else{
									$this->session->set_flashdata('error', "The Refferal Code that you entered is not correct, please enter valid Refferal Code.");
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
									$confirmlink = base_url()."index.php?/member/activate/".$user['activation_key'];
									$from = 'BitFxCo <support@bitfxco.com>';
									$name = $this->input->post('first_name');
									$lname = $this->input->post('last_name');
									$to = $this->input->post('email');
									$subject = 'Welcome to BitFxCo';
									$message ='Congratulations! and welcome to the Real World of BitFxCo. BitFxCo bring the right people together to challenge established thinking and drive transformation. We will show the way to successive. We hope you have a blast with the app and please be sure to tell all of your friends so they can join you. Please click the link below to confirm your account.';
									
								
									$headers = "From: $from" ."\n";
									$namedata='Hello '.$name.' '.$lname.', ';
									$fullname=$name.' '.$lname;
									$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);
									
								 if($this->sendemail($to, $subject, $message1, $fullname)){
									  $this->session->set_flashdata('success', "Your account created successfully, Please check your email to proceed further.");
									  redirect('member/signup');
									}else{
									$this->session->set_flashdata('error', "Your account created successfully, But there is some issue with email verification contact to Admin.");
									  redirect('member/signup');
									}
								    
								}else {
								  $this->session->set_flashdata('error', "Some problem to save data, please try again");
									redirect('member/signup'); //
								}
					 }
				}
			
	}	
	
	function random_string_old($length) {
   
    $key = '';
	$keys='';
	$ref_user=false;

    $keys = array_merge(range(0, 9),range(0, 9));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

	
	$ref_user = $this->member_model->get_user_refcode_exits($key);
	
	
	if($ref_user){
	
		$finalkey= $this->random_string($length);
		return $finalkey;
	}else{
	  
	    return $key;
	}
 }
	function random_string($user_id,$mykey) {
   

    $key = $mykey;
	
	$ref_user = $this->member_model->get_user_refcode_exits($key);
	
	
	if($ref_user){
	    $my_ref_num = 'BF'.''.$user['id'].''.date('d').''.date('m');
		$finalkey= $this->random_string($user_id,$my_ref_num);
		return $my_ref_num;
	}else{
	  
	    return $key;
	}
 }
	
	function signup($ref_code_link='') {

		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;		 
		$this->template['ref_code_link'] = $ref_code_link;	 
		
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			redirect('member/login');
		}
		
				$this->form_validation->set_rules('first_name','First Name',"trim|required|max_length[15]");
				$this->form_validation->set_rules('last_name','last Name',"trim|required|max_length[15]");
				$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
				//$this->form_validation->set_rules('phone','Phone',"trim|required|numeric|max_length[10]|min_length[10]"); //
				
	$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[10]|min_length[10]', array('required' => 'Phone is required.','max_length' => 'Phone Number should be numeric and 10 digit long','min_length' => 'Phone Number should be numeric and 10 digit long'));
				//$this->form_validation->set_rules('password','Password',"trim|matches[passconf]|required|min_length[4]");				
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]', array('required' => 'Password is required.','min_length' => 'Password should be of minimum 4 digit or character.'));
				
				$this->form_validation->set_rules('passconf', "Confirm", "trim");
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				$this->form_validation->set_message('min_length', 'The %s field is required');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');
				//$this->form_validation->set_message('max_length', '%s: should be of %s digit long');
				//$this->form_validation->set_message('min_length', '%s: should be of %s digit long. ');
				if ($this->form_validation->run() == FALSE)
				{	
					$this->layout->load($this->template, 'signup'); 
				}
				else
				{
					 $email=$this->input->post('email');
					 
					
					     //Upload company Logo
						   $activation_key = md5(rand(100,10000));
						   $display_key = $this->user->encryptval($this->input->post('password'));
						   $ref_code = $this->input->post('ref_code');
						   $email = $this->input->post('email');
						   $email_data = explode("@",$email);
						 
						   if($ref_code != "")
						   {
								$ref_user = $this->member_model->get_user_by_ref_code($ref_code);
								if(isset($ref_user['id']) && $ref_user['id'] > 0)  
								{
									$ref_id = $ref_user['id'];
								}else{
									$this->session->set_flashdata('error', "The Refferal Code that you entered is not correct, please enter valid Refferal Code.");
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
										'lname' => $this->input->post('last_name'),
										'email' => $this->input->post('email'),
										'countrycode' => $this->input->post('countryCode'),
										'phone' => $this->input->post('phone'),
										'password' => $this->user->_prep_password($this->input->post('password')),
										'display_key' => $display_key,
										'ref_code_used' =>  $ref_code,
										'ref_id' => $ref_id,
										'activation_key' => $activation_key,
										'created_date' => $today_date,
										'status' => 'active',
										'is_active' => 0
										
								); 
								$user_id = $this->member_model->insert_user($data);
								$user = $this->member_model->get_user_by_id($user_id);
								
														
								if(isset($user['id']) && $user['id'] > 0)
								{
									
									//update Ref Code
								
									//$my_ref_num = 'BF'.''.str_pad($user['id'], 5, '0', STR_PAD_LEFT);;
									if(strlen($user_id ) > 5){
									  $length = strlen($user_id)+1;
									}else{
									  $length=5; 
									}
									
									//$final_key = $this->random_string($length);
								
									//$my_ref_num = 'BF'.''.str_pad($user['id'], 5, '0', STR_PAD_LEFT);;
									
									$my_ref_num = 'BF'.''.$user['id'].''.date('d');
									
									$finalkey = $this->random_string($user['id'],$my_ref_num);
									
									if($finalkey){
									   	$refcode = array(
										  'my_ref_code' => $my_ref_num,
										  'username' => $my_ref_num
								         );
								       $userupdate = $this->member_model->update_user($user['id'],$refcode);	
									
									}
									
									//Update user table usmh ref code and user name
									
									$confirmlink = base_url()."index.php?/member/activate/".$user['activation_key'];
									$from = 'BitFxCo <support@bitfxco.com>';
									$name = $this->input->post('first_name');
									$lname = $this->input->post('last_name');
									$to = $this->input->post('email');
									$subject = 'Welcome to BitFxCo';
									$message ='Congratulations! and welcome to the Real World of BitFxCo. BitFxCo bring the right people together to challenge established thinking and drive transformation. We will show the way to successive. We hope you have a blast with the app and please be sure to tell all of your friends so they can join you. Please click the link below to confirm your account. After confirmation you can login using the credentials given below<br><br> Username : '.$my_ref_num .'<br>' .'Password : '.$this->input->post('password');
									
								
									$headers = "From: $from" ."\n";
									$namedata='Hello '.$name.' '.$lname.', ';
									$fullname=$name.' '.$lname;
									$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);
									
								 if($this->sendemail($to, $subject, $message1, $fullname)){
									  $this->session->set_flashdata('success', "Your account created successfully, Please check your email to proceed further.");
									  redirect('member/signup');
									}else{
									$this->session->set_flashdata('error', "Your account created successfully, But there is some issue with email verification contact to Admin.");
									  redirect('member/signup');
									}
								    
								}else {
								  $this->session->set_flashdata('error', "Some problem to save data, please try again");
									redirect('member/signup'); //
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
		unset($_SESSION['photo']);
		session_destroy();

		$this->session->set_flashdata('success',"You are now logged out.");
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
					$this->form_validation->set_rules('email', "Username","trim|required");	
						//$this->form_validation->set_rules('email', "Email","trim|required|valid_email");	
					$this->form_validation->set_rules('password','Password',"trim|required");
					$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
						$user = $this->member_model->validate_ref_login($email, $password);
						
						//echo "<pre>"; print_r($user); exit;
						if(isset($user['id']) && $user['id'] > 0)
						{
							$_SESSION['user_id'] = $user['id'];
							$_SESSION['first_name'] = $user['fname'];
							$_SESSION['last_name'] = $user['lname'];
							$_SESSION['user_plan'] = $user['user_plan'];
							$_SESSION['level_bonus'] = $user['level_bonus'];
							$_SESSION['is_paid'] = $user['is_paid'];
							$_SESSION['logged_in_user_ref_id'] = $user['my_ref_code'];
							$_SESSION['photo']= $user['photo'];
							redirect('member/dashboard');
						}
						else
						{
							$this->session->set_flashdata('error', "You have entered an invalid username or password.");
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
				if(isset($user[0]['is_active']) && $user[0]['is_active'] == 0)
				{
					$newkey = md5(rand(100,10000));
					$user_id = $user[0]['id'];
					$data = array('is_active'=> 1,'activation_key'=> $newkey);
					$this->member_model->update_user($user_id, $data);
					$this->session->set_flashdata('success', "You successfully activate your account.");
					redirect('member/login');
				}
			}else{
				$this->template['stat'] = 0; 
				$this->session->set_flashdata('error', "Seems this link has expired, please contact to Admin.");
				$this->layout->load($this->template, 'activateuser');//$this->layout->load($this->template, 'activate');
			}
		}else{
			$this->template['stat'] = 0;
			$this->session->set_flashdata('error', "You seems opening a wrong link.");
			$this->layout->load($this->template, 'activateuser');
		}
	}
	
	
	function requestdelete($id){

		if($id > 0){	
			 $this->member_model->deleterequest($id);
			 $this->session->set_flashdata('success',"Record delete sucessufully.");
			 redirect('member/withdrawrequests');
			}else{
			 $this->member_model->delete_send($id);
			 $this->session->set_flashdata('error',"No record found.");
			 redirect('member/withdrawrequests');
			}
	}
	
function buildtree($id,$all=array())
{
    
	
	$src_arr=$this->member_model->get_user_downline($id);


    if(is_array($src_arr) && !empty($src_arr)){
	$i=0;
		foreach($src_arr as $idx => $row)
		{
			if($row['ref_id'] > 0)
			{
					 array_push($all,$row['ref_id']);
					 $alldata=$this->buildtree($row['ref_id'],$all);
					 //return true;
			}
			$i++;
		}
	}
	
	
    return $alldata; 
}


function getAllDownlines($fathers) {

    $data = $this->member_model->get_userspan($fathers); 
    $new_father_ids = array();
    //$children = array();

if(!empty($data) && (is_array($data))){	
    foreach ($data as $child) { 
		$children[$child] = array(/**/); // etc
		$new_father_ids[] = $child;		
		
    }
  }
  $children = array_merge($children, $this->getAllDownlines($new_father_ids));

    return $childen;
}

		
		
  function alllevel($id){


$children = array();
	$data=$this->member_model->get_user_downline($id);
	$hiData =array();
foreach($data as $ids){ 
		$child_id=$ids['id'];
		$children[$child_id] = array($child_id);
		$children = array_merge($children, $this->getAllDownlines($ids['id']));

}	


print_r($hiData); exit;
	
		

  }
  
/*  function generateTree($items = array(), $parent_id = 0){
    $tree = '<ul>';
    for($i=0, $ni=count($items); $i < $ni; $i++){
    	if($items[$i]['parent_id'] == $parent_id){
    		$tree .= '<li>';
    		$tree .= $items[$i]['name'];
    		$tree .= $this->generateTree($items, $items[$i]['id']);
    		$tree .= '</li>';
    	}
    }
    $tree .= '</ul>';
    return $tree;
  } */
  
 function best(){
 
  $data= $this->alllevel(67);
  print_r($data); exit;
 }
	
	
	function fixedreward()
	{
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$downline=$this->member_model->get_level_one_downline($_SESSION['user_id']); //$this->template['levelone']
			//echo "<pre>"; print_r($downline); exit;
			if(count($downline) > 0)
			{
				if($downline[0]['price'] > 0)
				{
					$this->template['left_business'] = $downline[0]['tot'] + $downline[0]['price'];
				}else{
					$this->template['left_business'] = $downline[0]['tot'];
				}


				$rest_member_amount = 0;
				for($j=0;$j<count($downline); $j++)
				{
					if($j > 0)
					{
						if($downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0){ 
							$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
						}else{ 
							$rest_member_amount = $rest_member_amount + $downline[$j]['price'];
						}
					}
				}
				$this->template['rest_member_amount'] = $rest_member_amount;
				
			}else{
				$this->template['left_business'] = 0;
				$this->template['rest_member_amount'] = 0;
			}	
			$this->template['my_reward']=$this->member_model->get_reward_by_id($_SESSION['user_id'], 'reward');
			$this->template['downline_business']=$this->member_model->get_user_total_business($_SESSION['user_id']);

			$this->layout->load($this->template, 'fixedreward');

		}else{
			$this->session->set_flashdata('error',"You are not login.");
			redirect('member/login');
		} 
	}

	function royalty()
	{
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			//$this->template['levelone']=$this->member_model->get_level_one_downline($_SESSION['user_id']);
			$downline=$this->member_model->get_level_one_downline($_SESSION['user_id']); //$this->template['levelone']
			if(count($downline) > 0)
			{
				if($downline[0]['price'] > 0)
				{
					$this->template['left_business'] = $downline[0]['tot'] + $downline[0]['price'];
				}else{
					$this->template['left_business'] = $downline[0]['tot'];
				}


				$rest_member_amount = 0;
				for($j=0;$j<count($downline); $j++)
				{
					if($j > 0)
					{
						if($downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0){
							$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
						}else{
							$rest_member_amount = $rest_member_amount + $downline[$j]['price'];
						}
					}
				}
				$this->template['rest_member_amount'] = $rest_member_amount;
				
			}else{
				$this->template['left_business'] = 0;
				$this->template['rest_member_amount'] = 0;
			}	

			$this->template['my_royalty']=$this->member_model->get_royalty_by_id($_SESSION['user_id']);
			$this->template['downline_business']=$this->member_model->get_user_total_business($_SESSION['user_id']);

			$this->layout->load($this->template, 'royalty');

		}else{
			$this->session->set_flashdata('error',"You are not login.");
			redirect('member/login');
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
				$this->template['payout']=$this->member_model->get_user_total_payout($_SESSION['user_id']); 
				$this->template['total_upcoming_commission']=$this->member_model->get_user_total_upcoming_commission($_SESSION['user_id']); 
				$this->template['commission']=$this->member_model->get_user_total_commission($_SESSION['user_id']); 
				$this->template['my_reward']=$this->member_model->get_reward_count_by_id($_SESSION['user_id']); 
				$this->template['my_royalty']=$this->member_model->get_royalty_count_by_id($_SESSION['user_id']);
				$this->template['upcoming_payout']=$this->member_model->get_user_total_upcoming_payout($_SESSION['user_id']); 
				$this->template['downline_business']=$this->member_model->get_user_total_business($_SESSION['user_id']); 
			//	$this->template['upcoming_payout_graph']=$this->member_model->get_upcomingpayout($_SESSION['user_id']); 
				$this->template['getpayout']=$this->member_model->get_payout($_SESSION['user_id']); 
				$this->template['get_upcoming_commission_graph']=$this->member_model->get_bussiness_commission_graph($_SESSION['user_id']);				
				$this->template['get_upcoming_royalty_payment']=$this->member_model->get_upcoming_royalty_payment($_SESSION['user_id']); 
				
				
				  //if(isset($userdata[0]['is_confirmed']) && ($userdata[0]['is_confirmed'] == 0)){
				   //  $this->session->set_flashdata('notification',"You already requested for transaction apporval. Please wait untill admin approve your transaction.");
			        // redirect('member/package');
				  //}	
				          
			 // }
			
			  $this->template['user_detail'] = $this->member_model->get_user_by_id($_SESSION['user_id']); 
		     $this->layout->load($this->template, 'dashboard');
		   
		  }else{
		   $this->session->set_flashdata('error',"You are not login.");
		   redirect('member/login');
		
		} 
		
	}
	
function verifyeditprofile()
	{	
	    $this->template['selectpage'] = 7;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
				$user_id = $_SESSION['user_id']; 
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('verificationcode','Verification Code',"trim|required");
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');		
					
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'verifyeditprofile');
				}
				else
				{	
					//$amount = $this->input->post('amount');
					$verificationcode = $this->input->post('verificationcode');
					//get code realted data
					$codedata=$this->member_model->get_user_profile_verification_by_code($verificationcode);				  
					
					if($codedata){								   
							$editprofile = array(
								'fname' => $codedata[0]['fname'],
								'lname' => $codedata[0]['lname'],
								'email' =>$codedata[0]['email'],
								'countrycode' => $codedata[0]['countrycode'],
								'phone' => $codedata[0]['phone']
							);  
							
					$user_transaction_id = $this->member_model->update_user($_SESSION['user_id'],$editprofile);
							
					//update verficatiion table
					
						$editprofile_verify = array('is_approved' => 1);  
						$user_transaction_id = $this->member_model->update_editprofile_request($codedata[0]['id'],$editprofile_verify);
					//done			
							if($user_transaction_id > 0)
							{										
								
								$_SESSION['first_name'] = $codedata[0]['fname'];
								$_SESSION['last_name'] = $codedata[0]['lname'];
								
								$this->session->set_flashdata('success', "Successfully edit the profile.");
								redirect('member/editprofile');
							}else{
								$this->session->set_flashdata('error', "Some error has occured, so your transaction is not completed.");
								redirect('member/verifyeditprofile');
							}
					
					}else{
					    $this->session->set_flashdata('error', "Verification code expired.");
						redirect('member/editprofile');
					
					}
					
				}
			
		}else{
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
			$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
			$this->form_validation->set_rules('phone', "Mobile","trim|required");	//|callback__verify_mail
			$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
				    'user_id' => $_SESSION['user_id'],
					'fname' => $this->input->post('first_name'),
					'lname' => $this->input->post('last_name'),
					'email' => $this->input->post('email'), 
					'countrycode' => $this->input->post('countryCode'),
					'phone' => $this->input->post('phone'),
					'date_created' => date('Y-m-d')
				 );
				/*$_SESSION['first_name'] = $this->input->post('first_name');
				$_SESSION['last_name'] = $this->input->post('last_name');
				$this->member_model->update_user($user_id, $data);	
				$this->template['userdetail'] = $this->member_model->get_user_by_id($user_id);*/
				  
				  $update_request_id = $this->member_model->insert_user_profile_update($data);
				//  echo $this->db->last_query(); exit;
						
						//sent email with approval code
				 if($update_request_id){
						$userdata = $this->template['userdetail'];
						$from = 'BitFxCo <support@bitfxco.com>';
						$name = $userdata['fname'];
						$lname = $userdata['lname'];
						$fullname = $name .' '.$lname;
						$to = $userdata['email'];
						//$key=substr(str_shuffle(md5($name.' '.$lname.' '.time())),0,6);
						$key = rand(1000,10000);
						$subject = 'You process a edit request';
					
						$headers = "From: $from";
					
						$namedata = 'Hello '.$name.' '.$lname.',';
						$subject = 'Verification Code For Edit Profile !!';
						$message = 'You have initiated a profile edit request. <br>The OTP for this profile edit request is <br><br>'.$key.'. <br><br>To proceed, please enter this OTP and verify.';
						
						//$confirmlink = site_url('member/verifyeditprofile/'.$key);
						$confirmlink ="";
						$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);
						
						if($this->sendemail($to, $subject, $message1, $fullname)){
						
						   //update the table with key
						   $keydata = array(
							'verification_code' => $key
						);  
				
						$update_request = $this->member_model->update_editprofile_request($update_request_id,$keydata);
						$this->session->set_flashdata('success', "You will receive a verification code via email and after verification your edit profile request will be approved.");
							redirect('member/verifyeditprofile');
						}else{
						
							$this->session->set_flashdata('error', "Some issue, please try again.");
							redirect('member/editprofile');
						}
						   
					}else{
							$this->session->set_flashdata('error', "Date is not saved, please try again.");
							redirect('member/editprofile');
					 }
				
				$this->session->set_flashdata('success', "request for profile edit send successfully.");
				redirect("member/editprofile");
			}
		
		}else{
			redirect("member/login");
		}

	}	
	
	function editprofile_old() 
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
			$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
			$this->form_validation->set_rules('phone', "Mobile","trim|required");	//|callback__verify_mail
			$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
				'email' => $this->input->post('email'), 
				'countrycode' => $this->input->post('countryCode'),
				'phone' => $this->input->post('phone'),
				'modified_date' => date('Y-m-d H:i:s')
				);
				$_SESSION['first_name'] = $this->input->post('first_name');
				$_SESSION['last_name'] = $this->input->post('last_name');
				$this->member_model->update_user($user_id, $data);	
				$this->template['userdetail'] = $this->member_model->get_user_by_id($user_id);
				$this->session->set_flashdata('success', "Profile edited successfully.");
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
												$today_updated_level4 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel4['id']);
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
														$today_updated_level5 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel5['id']);
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
																$today_updated_level6 = $this->member_model->get_today_updated_commission($user_plans[$i]['id'], $userlevel6['id']);
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
		echo "Successfully Done11.<br/>";
		$data_cron=array(
			'date_created' => $today
		); 
		echo $payout_id_level1 = $this->member_model->insert_cron_log($data_cron); echo "11<br/>";
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
	function mytransactions($start = 0, $limit =20,$order = 'id')
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
			$this->session->set_flashdata('error',"You are not login.");
			redirect('member/login');
		} 
	}
	
   function showlevel($start = 0, $limit = 20, $order = 'id')
	{	$this->template['selectpage'] = 4;
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$this->template['bonus'] = $this->member_model->get_user_showbonus($_SESSION['user_id'],array('limit' => $limit, 'start' => $start, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 3;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/showlevel');
			$config['total_rows'] = $this->member_model->get_user_showbonus_count($_SESSION['user_id']);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;	
			$this->layout->load($this->template,'showlevel');
		}else{
			$this->session->set_flashdata('error',"You are not login.");
			redirect('member/login');
		} 
	}

	function upcomingpayout($start = 0, $limit = 20, $order = 'id')
	{	$this->template['selectpage'] = 4;
		session_start();  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$this->template['upcomingpayout'] = $this->member_model->get_user_upcoming_payout($_SESSION['user_id'],array('limit' => $limit, 'start' => $start, 'order_by' => $order));	
			$this->load->library('pagination');
			$config['uri_segment'] = 3;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/upcomingpayout');
			$config['total_rows'] = $this->member_model->get_user_upcoming_payout_count($_SESSION['user_id']);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;
			$this->layout->load($this->template,'upcomingpayout');
		}else{
			$this->session->set_flashdata('error',"You are not login.");
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
			$this->session->set_flashdata('error',"You are not login.");
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
			$this->session->set_flashdata('error',"You are not login.");
			redirect('member/login');
		} 
	}
	
   	function getnextlevel()
	{
			$userid=$_POST['user_id'];
			$level=$_POST['level']+1;
			$mydownline = $this->member_model->get_my_level_one_downline($userid);	
			$parentdata = $this->member_model->get_user_miniinfo($userid);
			$plandata=array('1'=>'Bronze','2'=>'Silver','3'=>'Gold','4'=>'Platinum');
			
	        $alldata='';
			if(count($mydownline) > 0){
			  foreach($mydownline as $mdata){
			     
			    $alldata.='<tr class="'.$mdata['id'].'">
						  <td>'.$mdata['fname']." ".$mdata['lname'].'</td>
						  <td>'.$mdata['email'].'</td>
						  <td>'.$mdata['my_ref_code'].'</td>
						 
						  <td>'.$mdata['phone'].'</td>
						   <td>'.$parentdata[0]['fname'].' '.$parentdata[0]['fname'].'( '.$parentdata[0]['my_ref_code'].')'.'</td>
						  <td>'.$plandata[$mdata['user_plan']].'</td>
						  <td>'.$level.'</td>
						  <td>'.date('jS M Y',strtotime($mdata['created_date'])).'</td>
						  <td><input type="button" class="nextbutton" onclick="GetNextLevel('.$mdata['id'].','.$level.')"  id="'.$mdata['id'].'" value="+"/></td>
						  </tr>';
			     }
				 
				echo $alldata; exit; 
			
			}else{
			  echo "0"; exit;
			}
			
	}
	
	function mydownline()
	{
		$this->template['selectpage'] = 6;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$downline=$this->member_model->get_level_one_downline($_SESSION['user_id']); //$this->template['levelone']
			//echo "<pre>"; print_r($downline); exit;
			if(count($downline) > 0)
			{
				if($downline[0]['price'] > 0)
				{
					$this->template['left_business'] = $downline[0]['tot'] + $downline[0]['price'];
				}else{
					$this->template['left_business'] = $downline[0]['tot'];
				}


				$rest_member_amount = 0;
				for($j=0;$j<count($downline); $j++)
				{
					if($j > 0)
					{
						if($downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0){
							$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
						}else{
							$rest_member_amount = $rest_member_amount + $downline[$j]['price'];
						}
					}
				}
				$this->template['rest_member_amount'] = $rest_member_amount;
				
			}else{
				$this->template['left_business'] = 0;
				$this->template['rest_member_amount'] = 0;
			}
			$this->template['downline_business']=$this->member_model->get_user_total_business($_SESSION['user_id']);
			

			$downline_com = $this->member_model->get_my_total_ref($_SESSION['user_id']); //
			$this->template['totalref'] = $downline_com[0]['com'];
			$this->template['total_could_be_com'] = $downline_com[0]['could_be_com'];
			$search='';
			$this->template['member'] = $this->member_model->get_user_by_id($_SESSION['user_id']);
			//my level one downline
			//$downline = $this->member_model->get_my_downline($search, $_SESSION['user_id']);	
			$levelone_downline = $this->member_model->get_my_level_one_downline($_SESSION['user_id']);	
			
				
			
			
			$downline_array = array();
			
			
			$this->template['downline'] = $levelone_downline;
			
			$this->load->library('pagination');
			$config['uri_segment'] = 3;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/mydownline');
			$config['total_rows'] = count($levelone_downline);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;

			
			$this->layout->load($this->template, 'mydownline');
			
		}else{
			$this->session->set_flashdata('error',"You are not login.");
			redirect('member/login');
		} 
	}
	
	function mydownline_old()
	{
		$this->template['selectpage'] = 6;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$downline=$this->member_model->get_level_one_downline($_SESSION['user_id']); //$this->template['levelone']
			if(count($downline) > 0)
			{
				if($downline[0]['price'] > 0)
				{
					$this->template['left_business'] = $downline[0]['tot'] + $downline[0]['price'];
				}else{
					$this->template['left_business'] = $downline[0]['tot'];
				}


				$rest_member_amount = 0;
				for($j=0;$j<count($downline); $j++)
				{
					if($j > 0 && $downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0)
					{
						if($downline[$j]['price'] > 0){
							$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[0]['price'];
						}else{
							$rest_member_amount = $rest_member_amount + $downline[$j]['tot'];
						}
					}
				}
				$this->template['rest_member_amount'] = $rest_member_amount;
				
			}else{
				$this->template['left_business'] = 0;
				$this->template['rest_member_amount'] = 0;
			}
			$this->template['downline_business']=$this->member_model->get_user_total_business($_SESSION['user_id']);

			$downline_com = $this->member_model->get_my_total_ref($_SESSION['user_id']); //
			$this->template['totalref'] = $downline_com[0]['com'];
			$this->template['total_could_be_com'] = $downline_com[0]['could_be_com'];
			$search='';
		//	$downline = $this->member_model->get_my_downline($search, $_SESSION['user_id']);
			$this->template['member'] = $this->member_model->get_user_by_id($_SESSION['user_id']);
			$downline = $this->member_model->get_my_downline($search, $_SESSION['user_id']);
			$downline_array = array();
			
			
			$this->template['downline'] = $downline;
			$this->load->library('pagination');
			$config['uri_segment'] = 3;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/mydownline');
			$config['total_rows'] = count($downline);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;

			/*$downline_array = array();
			foreach($downline as $downline)
			{
				$downline_array[] = $downline;
				if($downline['id'] > 0)
				{
					$downline1 = $this->member_model->get_my_downline($search,$downline['id']);
					foreach($downline1 as $downline1)
					{
						$downline_array[] = $downline1;
						$downline2 = $this->member_model->get_my_downline($search,$downline1['id']);
						foreach($downline2 as $downline2)
						{
							$downline_array[] = $downline2;
							$downline3 = $this->member_model->get_my_downline($search,$downline2['id']);
							foreach($downline3 as $downline3)
							{
								$downline_array[] = $downline3;
								$downline4 = $this->member_model->get_my_downline($search,$downline3['id']);
								foreach($downline4 as $downline4)
								{
									$downline_array[] = $downline4;
									$downline5 = $this->member_model->get_my_downline($search,$downline4['id']);
									foreach($downline5 as $downline5)
									{
										$downline_array[] = $downline5;
									}
								}
							}
						}
					}
				}
				
			}
			$this->template['mydownline'] = $downline_array;*/
			$this->layout->load($this->template, 'mydownline');
			
		}else{
			$this->session->set_flashdata('error',"You are not login.");
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
				$this->form_validation->set_rules('userid','Enter Your Id',"trim|required");
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
				if ($this->form_validation->run() == FALSE)
				{
						$this->layout->load($this->template, 'forgotpassword');
				}
				else
				{	
					$userid = $this->input->post('userid');
					$user = $this->member_model->get_user_by_refcode($userid);
					
					if(isset($user['id']) && $user['id'] > 0){
					
						$key = $user['activation_key'];
						$link = site_url('member/updatepassword/'.$key);
						$from = 'BitFxCo <support@bitfx-co.com>';
						$name = $user['fname'];
						$lname = $user['lname'];
						$to = $user['email'];
						$subject = 'BitFxCo: Password Reset';
						$message ='We received a request to reset the password associated with this e-mail address. If you made this request, please click on the link below.';
						
						$headers = "From: $from";
						$alldata='Hello '.$name.' '.$lname.', ';
						//$semi_rand = md5(time());
					//	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
						//$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
						
						$namedata = 'Hello '.$name.' '.$lname.', ';
						$fullname = $name.' '.$lname;
						$message1= $this->emailtemplate($namedata, $subject, $message, $link);

						//$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" .$message1 . "\n\n";
						//$message .= "--{$mime_boundary}\n";
						if($this->sendemail($to, $subject, $message1, $fullname)){
						   $this->session->set_flashdata('success', "We have sent an email on your registered email address, Please follow the instruction given in email to reset your password.");
						   redirect('member/forgotpassword');
						}else{
						   $this->session->set_flashdata('error', "There is some issue, please try after some time.");
						    redirect('member/forgotpassword');
						}						
						$this->layout->load($this->template, 'forgotpassword');
						return FALSE;
					}else{
						$this->session->set_flashdata('error', "We do not have any user with this ID address in our database.");
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
					$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
							$this->session->set_flashdata('success', "Password Changed Successfully !");
							redirect('member/login');
					}
				
				}else{
					$this->template['stat'] = 0;
					$this->session->set_flashdata('error', "Seems this link has expired, please goto forgot password again.");
					$this->layout->load($this->template, 'updatepassword');
					//return FALSE;
				}
			}else{
				redirect('member/login');
			}
		}
	}
	
	function verifytransfer()
	{	$this->template['selectpage'] = 7;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
				$user_id = $_SESSION['user_id']; 
				$amount_in_wallet=$this->member_model->get_user_total_wallet($user_id); 
				$today = date('Y-m-d');
			    
				$this->template['plans'] = $this->member_model->get_all_plans();
			    $this->template['totalwallet'] = $amount_in_wallet;
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('verificationcode','Verification Code',"trim|required");
				
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');		
					
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'verifytransfer');
				}
				else
				{	
					//$amount = $this->input->post('amount');
					$verificationcode = $this->input->post('verificationcode');
					//get code realted data
					$codedata=$this->member_model->get_user_transction_by_code($verificationcode);
				    $amount=$codedata[0]['amount_transfer'];
				
					
					if($codedata){
							if($amount > $amount_in_wallet)
							{ 
								$this->session->set_flashdata('error', "You do not have sufficient amount in your wallet.");
								redirect('member/transfer');
							}else{ 
								$rec_user = $this->member_model->get_user_by_id($codedata[0]['receiver_id']);
								
								if(isset($rec_user['id']) && $rec_user['id'] > 0)
								{
									if($rec_user['id'] != $user_id)
									{	
										//update transaction_request approval status in table
										$approved_user_trans = array('is_approved' => 1);  
										$update_request = $this->member_model->update_transaction_request($codedata[0]['id'],$approved_user_trans);										
										//debut user wallet
										if($update_request)
										{
											$transfer_to = $rec_user['fname']." ".$rec_user['lname'];
											$transfer_to_id = $rec_user['id'];
											$data_user_trans = array(
												'user_id' => $user_id,
												'trans_type' => 'debit',
												'amount' => $amount,
												'transfer_to' => $transfer_to,
												'transfer_to_id' => $transfer_to_id,
												'trans_reason' => 'transfer',  
												'is_transfer' => 1,  
												'date_created' => $today
											);  
											$user_transaction_id = $this->member_model->insert_user_transaction($data_user_trans);
											if($user_transaction_id > 0)
											{
										
												$this->member_model->debit_user_wallet($user_id,$amount); 
				
												$transfer_by = $_SESSION['first_name']." ".$_SESSION['last_name'];
												$transfer_by_id = $_SESSION['user_id'];
				
												$data_user_trans1 = array(
													'user_id' => $transfer_to_id,
													'trans_type' => 'credit',
													'amount' => $amount,
													'transfer_by' => $transfer_by,
													'transfer_by_id' => $transfer_by_id,
													'trans_reason' => 'transfer', 
													'is_transfer' => 1,  
													'date_created' => $today
												);  
												$user_transaction_id1 = $this->member_model->insert_user_transaction($data_user_trans1);
												//
												
												//enter the date into ci_admin_commission
													/*
													$transferamount=($amount*5)/100;
													$amount_after_deduction=$amount-$transferamount;
													$date = date('Y-m-d');
													$withdrawsdata=array('user_id'=>$_SESSION['id'],'total_amount'=>$amount,'amount_after_discount'=>$amount_after_deduction,'discounted_amount'=>$transferamount,'commission_percentage'=>5,'commission_reason'=>'Transfer Charges','date_created'=>$date );
													$admin_commission=$this->member_model->insert_admin_commission($withdrawsdata);
													*/
												//update trander user wallet to trander to  
												$amount_after_deduction = $amount;
												$this->member_model->update_user_transaction($transfer_to_id,$amount_after_deduction);
										
										
												$this->session->set_flashdata('error', "Successfully transfer the amount.");
												redirect('member/mytransactions');
											}else{
												$this->session->set_flashdata('error', "Some error has occured, so your transaction is not completed.");
												redirect('member/verifytransfer');
											}
										}else{
											$this->session->set_flashdata('error', "Some error has occured, so your transaction is not completed.");
											redirect('member/verifytransfer');
										}
									}else{
										$this->session->set_flashdata('error', "Please enter recipient email address, not your own.");
										redirect('member/verifytransfer');
									}
								}else{
									$this->session->set_flashdata('error', "We did not find any user with this email address.");
									redirect('member/verifytransfer');
								}
							}
					
					}else{
					    $this->session->set_flashdata('error', "Verification code expiris invalid.");
						redirect('member/verifytransfer');
					
					}
					
					
					
				}
			
		}else{
			redirect('member/login');
		}
	}
	/*function callbusiness()
	{
		$by_user = $this->member_model->get_user_by_id(117);
		$by_user_id = $by_user['id'];
		$by_user_name = $by_user['fname'].' '.$by_user['lname'];
		$by_ID = $by_user['username'];
		$parent_id = $by_user['ref_id'];
		$plan_id = 2;
		$amt = 200;
		$this->add_business_new($by_user_id, $by_user_name, $by_ID, $parent_id, $plan_id, $amt, 1);
	}*/
	function add_business_new($by_user_id, $by_user_name='', $by_ID=0, $parent_id=0, $plan_id=0, $amount=0, $level=1)
	{
		if($parent_id > 0)
		{
			$today = date('Y-m-d');
			$data = array(
				'user_id' => $parent_id,
				'plan_id' => $plan_id,
				'amount' => $amount,
				'level' => $level,
				'by_user_id' => $by_user_id,
				'by_user_name' => $by_user_name, 
				'by_ID' => $by_ID,  
				'date' => $today
			);  

			$business_id = $this->member_model->insert_user_business($data);  
			
			$next_parent = $this->member_model->get_user_referer_id($parent_id);
			if($next_parent > 0)
			{	$level = $level+1;
				$this->add_business_new($parent_id, $by_user_name, $by_ID, $next_parent, $plan_id, $amount, $level);
			}
		}
	}

	function add_business($by_user_id, $plan_id, $amount)
	{ 
		$by_user = $this->member_model->get_user_by_id($by_user_id);
		//echo "<pre>"; print_r($by_user); exit;
		$by_user_id = $by_user['id'];
		$by_user_name = $by_user['fname'].' '.$by_user['lname'];
		$by_ID = $by_user['username'];
		$today= date('Y-m-d');
		// For Level 1
		$user_id1 = $by_user['ref_id'];
		if($user_id1 > 0){
				$data1 = array(
					'user_id' => $user_id1,
					'plan_id' => $plan_id,
					'amount' => $amount,
					'level' => 1,
					'by_user_id' => $by_user_id,
					'by_user_name' => $by_user_name, 
					'by_ID' => $by_ID,  
					'date' => $today
				);  
				$business_id_1 = $this->member_model->insert_user_business($data1);

				// Level 2
				$user_id2 = $this->member_model->get_user_referer_id($user_id1);
				if($user_id2 > 0){
					$data2 = array(
						'user_id' => $user_id2,
						'plan_id' => $plan_id,
						'amount' => $amount,
						'level' => 2,
						'by_user_id' => $by_user_id,
						'by_user_name' => $by_user_name, 
						'by_ID' => $by_ID,  
						'date' => $today
					);  
					$business_id_2 = $this->member_model->insert_user_business($data2);  
					//Level 3
					$user_id3 = $this->member_model->get_user_referer_id($user_id2);
					if($user_id3 > 0){
						$data3 = array(
							'user_id' => $user_id3,
							'plan_id' => $plan_id,
							'amount' => $amount,
							'level' => 3,
							'by_user_id' => $by_user_id,
							'by_user_name' => $by_user_name, 
							'by_ID' => $by_ID,  
							'date' => $today
						);  
						$business_id_3 = $this->member_model->insert_user_business($data3); 
						//Level 4
						$user_id4 = $this->member_model->get_user_referer_id($user_id3);
						if($user_id4 > 0){
							$data4 = array(
								'user_id' => $user_id4,
								'plan_id' => $plan_id,
								'amount' => $amount,
								'level' => 4,
								'by_user_id' => $by_user_id,
								'by_user_name' => $by_user_name, 
								'by_ID' => $by_ID,  
								'date' => $today
							);  
							$business_id_4 = $this->member_model->insert_user_business($data4); 
							
							//Level 5
							$user_id5 = $this->member_model->get_user_referer_id($user_id4);
							if($user_id5 > 0){
								$data5 = array(
									'user_id' => $user_id5,
									'plan_id' => $plan_id,
									'amount' => $amount,
									'level' => 5,
									'by_user_id' => $by_user_id,
									'by_user_name' => $by_user_name, 
									'by_ID' => $by_ID,  
									'date' => $today
								);  
								$business_id_5 = $this->member_model->insert_user_business($data5);  
								//Level 6
								$user_id6 = $this->member_model->get_user_referer_id($user_id5);
								if($user_id6 > 0){
									$data6 = array(
										'user_id' => $user_id6,
										'plan_id' => $plan_id,
										'amount' => $amount,
										'level' => 6,
										'by_user_id' => $by_user_id,
										'by_user_name' => $by_user_name, 
										'by_ID' => $by_ID,  
										'date' => $today
									);  
									$business_id_6 = $this->member_model->insert_user_business($data6); 
									
									//Level 7
									$user_id7 = $this->member_model->get_user_referer_id($user_id6);
									if($user_id7 > 0){
										$data7 = array(
											'user_id' => $user_id7,
											'plan_id' => $plan_id,
											'amount' => $amount,
											'level' => 7,
											'by_user_id' => $by_user_id,
											'by_user_name' => $by_user_name, 
											'by_ID' => $by_ID,  
											'date' => $today
										);  
										$business_id_7 = $this->member_model->insert_user_business($data7); 
										
										//Level 8
										$user_id8 = $this->member_model->get_user_referer_id($user_id7);
										if($user_id8 > 0){
											$data8 = array(
												'user_id' => $user_id8,
												'plan_id' => $plan_id,
												'amount' => $amount,
												'level' => 8,
												'by_user_id' => $by_user_id,
												'by_user_name' => $by_user_name, 
												'by_ID' => $by_ID,  
												'date' => $today
											);  
											$business_id_8 = $this->member_model->insert_user_business($data8);  

											//Level 9
											$user_id9 = $this->member_model->get_user_referer_id($user_id8);
											if($user_id9 > 0){
												$data9 = array(
													'user_id' => $user_id9,
													'plan_id' => $plan_id,
													'amount' => $amount,
													'level' => 9,
													'by_user_id' => $by_user_id,
													'by_user_name' => $by_user_name, 
													'by_ID' => $by_ID,  
													'date' => $today
												);  
												$business_id_9 = $this->member_model->insert_user_business($data9);  

												//Level 10
												$user_id10 = $this->member_model->get_user_referer_id($user_id9);
												if($user_id10 > 0){
													$data10 = array(
														'user_id' => $user_id10,
														'plan_id' => $plan_id,
														'amount' => $amount,
														'level' => 10,
														'by_user_id' => $by_user_id,
														'by_user_name' => $by_user_name, 
														'by_ID' => $by_ID,  
														'date' => $today
													);  
													$business_id_10 = $this->member_model->insert_user_business($data10);  

													//Level 11
													$user_id11 = $this->member_model->get_user_referer_id($user_id10);
													if($user_id11 > 0){
														$data11 = array(
															'user_id' => $user_id11,
															'plan_id' => $plan_id,
															'amount' => $amount,
															'level' => 11,
															'by_user_id' => $by_user_id,
															'by_user_name' => $by_user_name, 
															'by_ID' => $by_ID,  
															'date' => $today
														);  
														$business_id_11 = $this->member_model->insert_user_business($data11);  

														//Level 12
														$user_id12 = $this->member_model->get_user_referer_id($user_id11);
														if($user_id12 > 0){
															$data12 = array(
																'user_id' => $user_id12,
																'plan_id' => $plan_id,
																'amount' => $amount,
																'level' => 12,
																'by_user_id' => $by_user_id,
																'by_user_name' => $by_user_name, 
																'by_ID' => $by_ID,  
																'date' => $today
															);  
															$business_id_12 = $this->member_model->insert_user_business($data12);  

															//Level 13
															$user_id13 = $this->member_model->get_user_referer_id($user_id12);
															if($user_id13 > 0){
																$data13 = array(
																	'user_id' => $user_id13,
																	'plan_id' => $plan_id,
																	'amount' => $amount,
																	'level' => 13,
																	'by_user_id' => $by_user_id,
																	'by_user_name' => $by_user_name, 
																	'by_ID' => $by_ID,  
																	'date' => $today
																);  
																$business_id_13 = $this->member_model->insert_user_business($data13);  

																//Level 14
																$user_id14 = $this->member_model->get_user_referer_id($user_id13);
																if($user_id14 > 0){
																	$data14 = array(
																		'user_id' => $user_id14,
																		'plan_id' => $plan_id,
																		'amount' => $amount,
																		'level' => 14,
																		'by_user_id' => $by_user_id,
																		'by_user_name' => $by_user_name, 
																		'by_ID' => $by_ID,  
																		'date' => $today
																	);  
																	$business_id_14 = $this->member_model->insert_user_business($data14);  

																	//Level 15
																	$user_id15 = $this->member_model->get_user_referer_id($user_id14);
																	if($user_id15 > 0){
																		$data15 = array(
																			'user_id' => $user_id15,
																			'plan_id' => $plan_id,
																			'amount' => $amount,
																			'level' => 15,
																			'by_user_id' => $by_user_id,
																			'by_user_name' => $by_user_name, 
																			'by_ID' => $by_ID,  
																			'date' => $today
																		);  
																		$business_id_15 = $this->member_model->insert_user_business($data15);  
																		
																		//Level 16
																		$user_id16 = $this->member_model->get_user_referer_id($user_id15);
																		if($user_id16 > 0){
																			$data16 = array(
																				'user_id' => $user_id16,
																				'plan_id' => $plan_id,
																				'amount' => $amount,
																				'level' => 16,
																				'by_user_id' => $by_user_id,
																				'by_user_name' => $by_user_name, 
																				'by_ID' => $by_ID,  
																				'date' => $today
																			);  
																			$business_id_16 = $this->member_model->insert_user_business($data16);  
																			
																			//Level 17
																			$user_id17 = $this->member_model->get_user_referer_id($user_id16);
																			if($user_id17 > 0){
																				$data17 = array(
																					'user_id' => $user_id17,
																					'plan_id' => $plan_id,
																					'amount' => $amount,
																					'level' => 17,
																					'by_user_id' => $by_user_id,
																					'by_user_name' => $by_user_name, 
																					'by_ID' => $by_ID,  
																					'date' => $today
																				);  
																				$business_id_17 = $this->member_model->insert_user_business($data17);  
																				
																				//Level 18
																				$user_id18 = $this->member_model->get_user_referer_id($user_id17);
																				if($user_id18 > 0){
																					$data18 = array(
																						'user_id' => $user_id18,
																						'plan_id' => $plan_id,
																						'amount' => $amount,
																						'level' => 18,
																						'by_user_id' => $by_user_id,
																						'by_user_name' => $by_user_name, 
																						'by_ID' => $by_ID,  
																						'date' => $today
																					);  
																					$business_id_18 = $this->member_model->insert_user_business($data18);  
																					
																					//Level 19
																					$user_id19 = $this->member_model->get_user_referer_id($user_id18);
																					if($user_id19 > 0){
																						$data19 = array(
																							'user_id' => $user_id19,
																							'plan_id' => $plan_id,
																							'amount' => $amount,
																							'level' => 19,
																							'by_user_id' => $by_user_id,
																							'by_user_name' => $by_user_name, 
																							'by_ID' => $by_ID,  
																							'date' => $today
																						);  
																						$business_id_19 = $this->member_model->insert_user_business($data19);  
																						
																						//Level 20
																						$user_id20 = $this->member_model->get_user_referer_id($user_id19);
																						if($user_id20 > 0){
																							$data19 = array(
																								'user_id' => $user_id20,
																								'plan_id' => $plan_id,
																								'amount' => $amount,
																								'level' => 20,
																								'by_user_id' => $by_user_id,
																								'by_user_name' => $by_user_name, 
																								'by_ID' => $by_ID,  
																								'date' => $today
																							);  
																							$business_id_20 = $this->member_model->insert_user_business($data20);  
																							//Level 21
																							$user_id21 = $this->member_model->get_user_referer_id($user_id20);
																							if($user_id21 > 0){
																								$data19 = array(
																									'user_id' => $user_id21,
																									'plan_id' => $plan_id,
																									'amount' => $amount,
																									'level' => 21,
																									'by_user_id' => $by_user_id,
																									'by_user_name' => $by_user_name, 
																									'by_ID' => $by_ID,  
																									'date' => $today
																								);  
																								$business_id_21 = $this->member_model->insert_user_business($data21);  
																								
																								//Level 22
																								$user_id22 = $this->member_model->get_user_referer_id($user_id21);
																								if($user_id22 > 0){
																									$data22 = array(
																										'user_id' => $user_id22,
																										'plan_id' => $plan_id,
																										'amount' => $amount,
																										'level' => 22,
																										'by_user_id' => $by_user_id,
																										'by_user_name' => $by_user_name, 
																										'by_ID' => $by_ID,  
																										'date' => $today
																									);  
																									$business_id_22 = $this->member_model->insert_user_business($data22);  

																									//Level 23
																									$user_id23 = $this->member_model->get_user_referer_id($user_id22);
																									if($user_id23 > 0){
																										$data23 = array(
																											'user_id' => $user_id23,
																											'plan_id' => $plan_id,
																											'amount' => $amount,
																											'level' => 23,
																											'by_user_id' => $by_user_id,
																											'by_user_name' => $by_user_name, 
																											'by_ID' => $by_ID,  
																											'date' => $today
																										);  
																										$business_id_23 = $this->member_model->insert_user_business($data23);  

																										//Level 24
																										$user_id24 = $this->member_model->get_user_referer_id($user_id23);
																										if($user_id24 > 0){
																											$data24 = array(
																												'user_id' => $user_id24,
																												'plan_id' => $plan_id,
																												'amount' => $amount,
																												'level' => 24,
																												'by_user_id' => $by_user_id,
																												'by_user_name' => $by_user_name, 
																												'by_ID' => $by_ID,  
																												'date' => $today
																											);  
																											$business_id_24 = $this->member_model->insert_user_business($data24);  
																											
																											//Level 25
																											$user_id25 = $this->member_model->get_user_referer_id($user_id24);
																											if($user_id25 > 0){
																												$data25 = array(
																													'user_id' => $user_id25,
																													'plan_id' => $plan_id,
																													'amount' => $amount,
																													'level' => 25,
																													'by_user_id' => $by_user_id,
																													'by_user_name' => $by_user_name, 
																													'by_ID' => $by_ID,  
																													'date' => $today
																												);  
																												$business_id_25 = $this->member_model->insert_user_business($data25);  
																												//Level 26
																												$user_id26 = $this->member_model->get_user_referer_id($user_id25);
																												if($user_id26 > 0){
																													$data26 = array(
																														'user_id' => $user_id26,
																														'plan_id' => $plan_id,
																														'amount' => $amount,
																														'level' => 26,
																														'by_user_id' => $by_user_id,
																														'by_user_name' => $by_user_name, 
																														'by_ID' => $by_ID,  
																														'date' => $today
																													);  
																													$business_id_26 = $this->member_model->insert_user_business($data26);  
																													
																													//Level 27
																													$user_id27 = $this->member_model->get_user_referer_id($user_id26);
																													if($user_id27 > 0){
																														$data27 = array(
																															'user_id' => $user_id27,
																															'plan_id' => $plan_id,
																															'amount' => $amount,
																															'level' => 27,
																															'by_user_id' => $by_user_id,
																															'by_user_name' => $by_user_name, 
																															'by_ID' => $by_ID,  
																															'date' => $today
																														);  
																														$business_id_27 = $this->member_model->insert_user_business($data27);  
																														//Level 28
																														$user_id28 = $this->member_model->get_user_referer_id($user_id27);
																														if($user_id28 > 0){
																															$data28 = array(
																																'user_id' => $user_id28,
																																'plan_id' => $plan_id,
																																'amount' => $amount,
																																'level' => 28,
																																'by_user_id' => $by_user_id,
																																'by_user_name' => $by_user_name, 
																																'by_ID' => $by_ID,  
																																'date' => $today
																															);  
																															$business_id_28 = $this->member_model->insert_user_business($data28);  
																															//Level 29
																															$user_id29 = $this->member_model->get_user_referer_id($user_id28);
																															if($user_id29 > 0){
																																$data29 = array(
																																	'user_id' => $user_id29,
																																	'plan_id' => $plan_id,
																																	'amount' => $amount,
																																	'level' => 29,
																																	'by_user_id' => $by_user_id,
																																	'by_user_name' => $by_user_name, 
																																	'by_ID' => $by_ID,  
																																	'date' => $today
																																);  
																																$business_id_29 = $this->member_model->insert_user_business($data29);  
																																//Level 30
																																$user_id30 = $this->member_model->get_user_referer_id($user_id29);
																																if($user_id30 > 0){
																																	$data30 = array(
																																		'user_id' => $user_id30,
																																		'plan_id' => $plan_id,
																																		'amount' => $amount,
																																		'level' => 30,
																																		'by_user_id' => $by_user_id,
																																		'by_user_name' => $by_user_name, 
																																		'by_ID' => $by_ID,  
																																		'date' => $today
																																	);  
																																	$business_id_30 = $this->member_model->insert_user_business($data30);  
																																	//Level 31
																																	$user_id31 = $this->member_model->get_user_referer_id($user_id30);
																																	if($user_id31 > 0){
																																		$data31 = array(
																																			'user_id' => $user_id31,
																																			'plan_id' => $plan_id,
																																			'amount' => $amount,
																																			'level' => 31,
																																			'by_user_id' => $by_user_id,
																																			'by_user_name' => $by_user_name, 
																																			'by_ID' => $by_ID,  
																																			'date' => $today
																																		);  
																																		$business_id_31 = $this->member_model->insert_user_business($data31);  
																																		//Level 32
																																		$user_id32 = $this->member_model->get_user_referer_id($user_id31);
																																		if($user_id32 > 0){
																																			$data32 = array(
																																				'user_id' => $user_id32,
																																				'plan_id' => $plan_id,
																																				'amount' => $amount,
																																				'level' => 32,
																																				'by_user_id' => $by_user_id,
																																				'by_user_name' => $by_user_name, 
																																				'by_ID' => $by_ID,  
																																				'date' => $today
																																			);  
																																			$business_id_32 = $this->member_model->insert_user_business($data32);  
																																			//Level 33
																																			$user_id33 = $this->member_model->get_user_referer_id($user_id32);
																																			if($user_id31 > 0){
																																				$data33 = array(
																																					'user_id' => $user_id33,
																																					'plan_id' => $plan_id,
																																					'amount' => $amount,
																																					'level' => 33,
																																					'by_user_id' => $by_user_id,
																																					'by_user_name' => $by_user_name, 
																																					'by_ID' => $by_ID,  
																																					'date' => $today
																																				);  
																																				$business_id_33 = $this->member_model->insert_user_business($data33);  
																																				//Level 34
																																				$user_id34 = $this->member_model->get_user_referer_id($user_id33);
																																				if($user_id34 > 0){
																																					$data34 = array(
																																						'user_id' => $user_id34,
																																						'plan_id' => $plan_id,
																																						'amount' => $amount,
																																						'level' => 34,
																																						'by_user_id' => $by_user_id,
																																						'by_user_name' => $by_user_name, 
																																						'by_ID' => $by_ID,  
																																						'date' => $today
																																					);  
																																					$business_id_34 = $this->member_model->insert_user_business($data34);  
																																					//Level 35
																																					$user_id35 = $this->member_model->get_user_referer_id($user_id34);
																																					if($user_id35 > 0){
																																						$data35 = array(
																																							'user_id' => $user_id35,
																																							'plan_id' => $plan_id,
																																							'amount' => $amount,
																																							'level' => 35,
																																							'by_user_id' => $by_user_id,
																																							'by_user_name' => $by_user_name, 
																																							'by_ID' => $by_ID,  
																																							'date' => $today
																																						);  
																																						$business_id_35 = $this->member_model->insert_user_business($data35);  
																																						
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
			

		return true;
	}

	function transfer()
	{	$this->template['selectpage'] = 7;
		session_start(); 
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0)
		{
			$user_id = $_SESSION['user_id']; 
			$amount_in_wallet=$this->member_model->get_user_total_wallet($user_id); 
			$today = date('Y-m-d');
			
				$this->template['plans'] = $this->member_model->get_all_plans();
				$this->template['totalwallet'] = $amount_in_wallet;
				$this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('email','Recipient Email',"trim|required");
				$this->form_validation->set_rules('amount','Amount',"trim|required");
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
						$this->session->set_flashdata('error', "You do not have sufficient amount in your wallet.");
						redirect('member/transfer');
					}else{
						$rec_user = $this->member_model->get_user_by_email($this->input->post('email'));
						if(isset($rec_user[0]['id']) && $rec_user[0]['id'] > 0)
						{
							if($rec_user[0]['id'] != $user_id)
							{	$transfer_to = $rec_user[0]['fname']." ".$rec_user[0]['lname'];
								$transfer_to_id = $rec_user[0]['id'];
								$data_user_trans = array(
									'user_id' => $user_id,
									'trans_type' => 'debit',
									'amount' => $amount,
									'transfer_to' => $transfer_to,
									'transfer_to_id' => $transfer_to_id,
									'trans_reason' => 'transfer',  
									'is_transfer' => 1,  
									'date_created' => $today
								);  
								$user_transaction_id = $this->member_model->insert_user_transaction($data_user_trans);
								if($user_transaction_id > 0)
								{
								$this->member_model->debit_user_wallet($user_id,$amount); 

								$transfer_by = $_SESSION['first_name']." ".$_SESSION['last_name'];
								$transfer_by_id = $_SESSION['user_id'];

								$data_user_trans1 = array(
									'user_id' => $transfer_to_id,
									'trans_type' => 'credit',
									'amount' => $amount,
									'transfer_by' => $transfer_by,
									'transfer_by_id' => $transfer_by_id,
									'trans_reason' => 'transfer', 
									'is_transfer' => 1,  
									'date_created' => $today
								);  
								$user_transaction_id1 = $this->member_model->insert_user_transaction($data_user_trans1);
								$this->member_model->update_user_transaction($transfer_to_id,$amount);
								redirect('member/mytransactions');
								}else{
									$this->session->set_flashdata('error', "Some error has occured, so your transaction is not completed.");
								redirect('member/transfer');
								}
							}else{
								$this->session->set_flashdata('error', "Please enter recipient email address, not your own.");
								redirect('member/transfer');
							}
						}else{
							$this->session->set_flashdata('error', "We did not find any user with this email address.");
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
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
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
							$this->session->set_flashdata('success', "Password Changed Successfully !");
							redirect('member/changepassword');
						}else{
							$this->session->set_flashdata('error', "Please enter correct Old password.");
							redirect('member/changepassword');
						}
					}else{
						$this->session->set_flashdata('error', "Please enter correct Old paswword.");
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
	/*function testemail()
	{
		$name="Hello John Doe";
		$subject="WELCOME TO BitFxCo";
		$message="Welcome to the Real World of BitFxCo. BitFxCo bring the right people together to challenge established thinking and drive transformation. We will show the way to successive. We hope you have a blast with the app and please be sure to tell all of your friends so they can join you. Please click the link below to confirm your account.";
		$link="https://BitFxCo.com/index.php?/member/activate/bf0e23a49301411dac67136bde87c1c9";
		echo $this->emailtemplate($name, $subject, $message, $link);
	} */

	function emailtemplate($name, $subject, $message, $link='') //
	{
		$msg='<table id="m_-7023718313215841620m_-4532218898448234469bodyTable" style="margin:0;padding:0;background:#f5f7fa;background-repeat:no-repeat;border-collapse:collapse;height:100%;width:100%" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#F6F7FC">
				<tbody>
					<tr>
		  				<td id="m_-7023718313215841620m_-4532218898448234469bodyCell" style="margin:0;padding:40px 20px;height:100%;width:100%" width="100%" valign="top" height="100%" align="center">
							<table id="m_-7023718313215841620m_-4532218898448234469emailContainer" style="border-collapse:collapse;max-width:498px" cellspacing="0" cellpadding="0" border="0">
								  <tbody>
								  	<tr>
										<td valign="top" align="left">
										<a href="'.base_url().'" rel="noopener noreferrer" style="text-decoration:none;color:#4f6ef7" target="_blank">
											<img src="'.base_url().'application/views/themes/bitfx/assets/img/email-logo.png" alt="BitFxCo" style="font-family:Roboto,sans-serif;font-weight:500;border:0;font-size:42px;line-height:100%;outline:none;text-align:left;text-decoration:none;color:#162a5c;height:auto" width="" height="" class="CToWUd">
										</a>
										</td>
									</tr>
			  						<tr>
										<td style="padding-top:30px;padding-bottom:30px" valign="top" align="center">
										<table id="m_-7023718313215841620m_-4532218898448234469emailBody" style="border-radius:15px;background-color:#ffffff;padding-top:15px;border-collapse:separate" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
										<tbody><tr>
					  							<td style="color:#616471;font-family:Roboto,sans-serif;font-weight:400;font-size:15px;line-height:175%;padding:15px 40px 30px 40px;text-align:left" align="left">
	  											<div style="width:100%;text-align:center;padding:2rem 0;margin-bottom:1rem">
	  											<img src="'.base_url().'application/views/themes/bitfx//assets/img/unnamed.png" alt="Reset Password" width="70" class="CToWUd">
	  											</div>
	  
												<h1 style="font-family:Roboto,sans-serif;font-size:28px;font-weight:bold;line-height:115%;padding:0;text-align:center;margin-bottom:2rem;color:#000000">
												'.$subject.'
												</h1>
	  
	  											<div style="border-bottom:1px solid rgba(32,32,54,0.10);width:498px"></div>
	  
												<br>
												<b>
												'.$name.'
												</b>
												<br> <br>
												'.$message.'
	  
	  
												<table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
												<tbody><tr>
													<td style="padding-top:35px;padding-bottom:35px" valign="middle" align="center">';
								if($link !='')
								{	
								$msg.='<table style="border-radius:5px;background-color:#4f6ef7;width:100%;margin:2rem auto;border-collapse:separate" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#4F6EF7">
										<tbody><tr>
										<td style="border-radius:5px;background-color:#4f6ef7;font-family:Roboto,sans-serif;color:#ffffff;background:#4f6ef7;font-size:18px;line-height:100%;min-width:180px;max-width:300px;margin-bottom:1em" valign="middle" bgcolor="#4F6EF7" align="center">
											<a href="'.$link.'" style="font-weight:500;display:inline-block;padding:20px 13px;color:#ffffff;text-decoration:none" target="_blank" data-saferedirecturl="">Click Here To Proceed</a>
										</td>
										</tr>
									</tbody></table>';
								}
									$msg.='</td>
												</tr>
												</tbody></table>
												
												<br>
												
												Sincerely, <br>
												The BitFxCo Team <br>
												<a href="'.base_url().'" style="text-decoration:none;color:#4f6ef7" target="_blank">'.base_url().'</a> <br>
												
												<br>
									</td>
								</tr>
				
							</tbody></table>
							</td>
						</tr>
						
						</tbody></table>
					</td>
					</tr>
	  			</tbody></table>';

		return $msg;
		
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