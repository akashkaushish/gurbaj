<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Page extends MX_Controller {
		
		var $template = array();
		
		function __construct()
		{
			parent::__construct();
			//$this->output->enable_profiler(true);
			$this->template['module'] = "page";
			$this->load->model('page_model', 'pages');
			//$this->user->lang = $this->session->userdata('lang');
		}
		
		//all available blocks
		function blocks () {
			
		}

		function comment()
		{
			//settings
			$page = $this->pages->get_page($this->input->post('uri'));
			
			if (!$this->user->logged_in && !$this->input->post('captcha'))
			{
				$this->session->set_flashdata('notification', __("You must submit the security code that appears in the image", $this->template['module']));
				redirect($this->input->post('uri'));
			}
			
			if(!$this->user->logged_in)
			{
				$expiration = time()-7200; // Two hour limit
				$this->db->where("captcha_time <", $expiration);
				$this->db->delete('captcha');

				// Then see if a captcha exists:
				$this->db->where('word', $this->input->post('captcha'));
				$this->db->where('ip_address', $this->input->ip_address());
				$this->db->where('captcha_time >', $expiration);
				$query = $this->db->get('captcha');
				$row = $query->row();
				

				if ($query->num_rows() == 0)
				{

					$this->session->set_flashdata('notification', __("You must submit the security code that appears in the image", $this->template['module']));
					redirect($this->input->post('uri'));
				}
				$fields = array('author', 'email', 'website');
				$data = array();
				foreach ($fields as $field)
				{
					$data[$field] = $this->input->post($field);
				}
				
				//since we don't know if registered or not
				$data['author'] .= " (" . __("guest", $this->template['module']) . ")";
			}
			else
			{
				$data = array();
				$data['author'] = $this->user->username;
				$data['email'] = $this->user->email;
				
			}
			$data['body'] = $this->input->post('body');
			$data['page_id'] = $page['id'];
			$data['ip'] = $this->input->ip_address();
			$data['date'] = mktime();
			
			
			if ($this->system->page_approve_comments && $this->system->page_approve_comments = 1)
			{
				$data['status'] = 1;
				if (isset($page['option']['notify']) && $page['option']['notify'] == 1 && $page['email'])
				{
					$this->load->library('email');

					$this->email->from($page['email'], $this->system->site_name );
					$this->email->to($page['email']);

					$this->email->subject('[' . $this->system->site_name . '] '. __("Comment Notification", $this->template['module']));
					
					$smsg = __("
Hello,

A new comment has been sent to the page
%s


If you don't want to receive other notification, go to
%s

and disable notification.
", "page");
					$msg = sprintf($smsg, 
							site_url( $page['uri']),
							site_url('admin/page/create/' . $page['id'])
						);
						
					$this->email->message($msg);

					$this->email->send();
					
					//notify admin
				
				}

				if (isset($this->system->page_notify_admin) && $this->system->page_notify_admin == 1)
				{
					$this->load->library('email');

					$this->email->from($page['email'], $this->system->site_name );
					

					$this->email->subject('[' . $this->system->site_name . '] '. __("Comment Notification", $this->template['module']));
					$msg = __("
							Hello,

							A new comment has been sent to the page
							%s


							If you don't want to receive other notification, go to
							%s

							and disable notification.
							", "page");
					$msg = sprintf($msg,
							site_url($page['uri']),
							site_url('admin/page/settings#two')
						);
					$this->email->to($this->system->admin_email);
					$this->email->message($msg);
					$this->email->send();
				}
				
			}
			else
			{
				
				if ($page['email'] != '')
				{
					$this->load->library('email');

					$this->email->from($page['email'], $this->system->site_name );
					$this->email->to($page['email']);

					$this->email->subject('[' . $this->system->site_name . '] '. __("Comment to approve", $this->template['module']));
					
					$msg = __("
						Hello,

						A new comment has been sent to the page
						%s
						To approve it click the link below 
						%s

						If you don't want to receive other notification, go to
						%s

						and set to approve comments automatically.
						", "page");
					$msg = sprintf($msg, 
							site_url($news['uri']),
							site_url('admin/page/comments/approve/' . $page['id']),
							site_url('admin/page/settings#two')
						);
						
					$this->email->message($msg);

					$this->email->send();

				}
				
				$this->session->set_flashdata('notification', __("Thank you for your comment. In this site, the comments need to be approved by the administrator. Once approved, you will see it listed here.", $this->template['module']));
			}
			
			$data = $this->plugin->apply_filters('comment_filter', $data);
			
			
			$this->db->insert('page_comments', $data);
			
			redirect( $this->input->post('uri'), 'refresh');
		}
		
		
		function sendmail()
		{
			// Define some constants
			define( "RECIPIENT_NAME", "Admin CrypGrow" );
			define( "RECIPIENT_EMAIL", "support@crypgrow.com" );

			// Read the form values
			$success = false;
			$name = isset( $_POST['name'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name'] ) : "";
			$senderEmail = isset( $_POST['email'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email'] ) : "";
			$phone = isset( $_POST['phone'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone'] ) : "";
			$services = isset( $_POST['services'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['services'] ) : "";
			$subject = isset( $_POST['subject'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject'] ) : "";
			$website = isset( $_POST['website'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['website'] ) : "";
			$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";

			$mail_subject = 'A contact request send by ' . $name;

			$body = 'Name: '. $name . "\r\n";
			$body .= 'Email: '. $senderEmail . "\r\n";


			if ($phone) {$body .= 'Phone: '. $phone . "\r\n"; }
			if ($services) {$body .= 'services: '. $services . "\r\n"; }
			if ($subject) {$body .= 'Subject: '. $subject . "\r\n"; }
			if ($website) {$body .= 'Website: '. $website . "\r\n"; }

			$body .= 'message: ' . "\r\n" . $message;



			// If all values exist, send the email
			if ( $name && $senderEmail && $message ) {
			$recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
			$headers = "From: " . $name . " <" . $senderEmail . ">";  
			$success = mail( $recipient, $mail_subject, $body, $headers );
			echo "<div class='inner success'><p class='success'>Thanks for contacting us. We will contact you ASAP!</p></div><!-- /.inner -->";
			//$this->session->set_flashdata('notification', "Thanks for contacting us. We will contact you ASAP!");	
			}else {
				echo "<div class='inner error'><p class='error'>Something went wrong. Please try again.</p></div><!-- /.inner -->";
				//$this->session->set_flashdata('notification', "Something went wrong. Please try again.");
			}
			
			//$this->layout->load($this->template, 'sendemail');
		}
		
		function index()
		{ 
			//session_start();
			
			if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0)){
			    redirect('member/dashboard');
			}
			
		/*	if ( $this->uri->segment(1) )
			{
				$num = 1;
				$built_uri = '';
				
				while ( $segment = $this->uri->segment($num))
				{
					$built_uri .= $segment.'/';
					$num++;
				}
				
				$new_length = strlen($built_uri) - 1;
				$built_uri = substr($built_uri, 0, $new_length);
			}
			else
			{
				$built_uri = $this->system->page_home;
			}
			
			if ( $page = $this->pages->get_page(array('uri' => $built_uri, 'lang' => $this->user->lang)) )
			{
				
				$page = $this->plugin->apply_filters('page_item', $page);
				
				//can view?
				if(!in_array($page['g_id'], $this->user->groups))
				{
					$this->output->set_header("HTTP/1.0 403 Forbidden");
					if($this->user->logged_in)
					{
						$this->template['message'] = __("Your are already logged in but not allowed to see this page. If it is an error then contact the administrators of the site.", "page");
					}
					else
					{
						$this->template['message'] = __("Your are not allowed to see this page.", "page") . "<br />" . anchor('member/login', __("Please try to sign in here", "page"));
					}
					
					$this->layout->load($this->template, '403');
					return;
				}
				
				if ($page['active'] != 0)
				{
					
					$this->template['comments'] = $this->pages->get_comments(array('where' => array('page_id' => $page['id'], 'status' => 1), 'order_by' => 'id'));
					$this->template['page'] = $page;
					$view = 'index';
					
					if($parent = $this->pages->get_page(array('id' => $page['parent_id'])))
					{
						$this->template['breadcrumb'][] = 	array(
						'title'	=> (strlen($parent['title']) > 20 )? substr($parent['title'], 0, 20) . '...': $parent['title'],
						'uri'	=> $parent['uri']
						);
					}
					
					if ($page['uri'] != $this->system->page_home)
					{
						$this->template['breadcrumb'][] = 	array(
						'title'	=> (strlen($page['title']) > 20 )? substr($page['title'], 0, 20) . '...': $page['title'],
						'uri'	=> $page['uri']
						);
					}
					
					$this->template['title'] = $this->template['page']['title'];
														
					$this->template['meta_keywords'] 	= $this->template['page']['meta_keywords'];
					$this->template['meta_description'] = $this->template['page']['meta_description'];
					//page hit
					if ($this->session->userdata('page'.$page['id']) != $page['id'])
					{
						$this->session->set_userdata('page'.$page['id'], $page['id']);
						$this->db->where('id', $page['id']);
						$this->db->set('hit', 'hit+1', FALSE);
						$this->db->update('pages');
						$this->cache->remove('pagelist'.$this->user->lang, 'page');
					}
					
					if (isset($page['options']['allow_comments']) && $page['options']['allow_comments'] == 1)
					{
						if(!$this->user->logged_in)
						{
							//generate captcha
							
							$pool = '0123456789';

							$str = '';
							for ($i = 0; $i < 6; $i++)
							{
								$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
							}
							
							$word = $str;
				
				
							$this->load->helper('captcha');
							$vals = array(
								'img_path'	 => './media/captcha/',
								'img_url'	 => site_url('media/captcha'). '/',
								'font_path'	 => APPPATH . 'modules/news/fonts/Fatboy_Slim.ttf',
								'img_width'	 => 150,
								'img_height' => 30,
								'expiration' => 1800,
								'word' => $word
							);
			
							$cap = create_captcha($vals);
							
							$data = array(
								'captcha_id'	=> '',
								'captcha_time'	=> $cap['time'],
								'ip_address'	=> $this->input->ip_address(),
								'word'			=> $cap['word']
							);

							$this->db->insert('captcha', $data);
							
							
							$this->template['captcha'] = $cap['image'];
						}
					
					}
					
				}
				else
				{
					
					$this->template['message'] = __("The page you're looking for is not active!", "page");
					$view = '403';
				}
			}
			elseif( $page = $this->pages->get_page(array('uri' => $built_uri)) )
			{
				//the page exists but in another language, so change the language and go to the page
				redirect($page['lang'] . '/' . $page['uri']);
			}
			else
			{
				// Make sure we send a 404 header
				
				
				$view = '404';
			}*/
			//$this->template['plans']  = $this->pages->get_all_plans();
			
			$view='index';
	
			$this->layout->load($this->template, $view);
		}
		
		function body($uri)
		{

			$data['uri'] = $uri;
			//if(!is_null($lang)) $data['lang'] = $lang;
			if ( $page = $this->pages->get_page($data))
			{
				echo $page['body'];
				exit;
			}
		}
		
        function children($parent_id = 0, $start = 0)
        {
            
            $params['where'] = array('parent_id' => $parent_id);		
            $params['order_by'] = 'weight';
            $search_id = $this->pages->save_params(serialize($params));

            $this->results($search_id, $start);
            return;            
        }
        function results($search_id = 0, $start = 0)
        {
            $params = array();

            //sorting
            if ($search_id != '0' && $tmp = $this->pages->get_params($search_id))
            {
                $params = unserialize( $tmp);
            }
            if(isset($params['where']['parent_id']))
            {
                $parent_id = $params['where']['parent_id'];
            }            
            $params['where']['active'] = 1;
            $params['where']['lang'] = $this->user->lang;
            $wheres = array();
            foreach($params['where'] as $key => $val)
            {
                $wheres[] = $key . " = " . $this->db->escape($val) . " ";
            }
            
            $where = join(' AND ', $wheres);
            $where .= " AND g_id IN " . "('"  . join("', '", $this->user->groups) . "') ";
            $params['where'] = $where ;

            $per_page = 20;
            $params['start'] = $start;

            $params['limit'] = $per_page;


            $this->template['rows'] = $this->pages->get_page_list($params);

            $this->template['title'] = __("Page list", "page");
            $config['first_link'] = __('First', 'page');
            $config['last_link'] = __('Last', 'page');
            $config['total_rows'] = $this->pages->get_total($params);
            $config['per_page'] = $per_page;
            $config['base_url'] = base_url() . 'page/results/' . $search_id;
            $config['uri_segment'] = 4;
            $config['num_links'] = 20;
            $this->load->library('pagination');

            $this->pagination->initialize($config);

            $this->template['pager'] = $this->pagination->create_links();
            $this->template['start'] = $start;
            $this->template['total'] = $config['total_rows'];
            $this->template['per_page'] = $config['per_page'];
            $this->template['total_rows'] = $config['total_rows'];
            $this->template['search_id'] = $search_id;

            $this->layout->load($this->template, 'results');

        }
		/*aboutus*/
	
	function payment()
	{   
	   $this->layout->load($this->template, 'payment');	
	}		
		
	function services()
	{   
	   $this->layout->load($this->template, 'services');	
	}
	
	function dealsin()
	{
	   //session_start();
	   
	//   $this->template['member'] = $this->pages->get_user_by_id(2);
	   $this->layout->load($this->template, 'dealsin');
		
	}
	
		function typesofincome()
	{
	   //session_start();
	   
	 //  $this->template['member'] = $this->pages->get_user_by_id(2);
	   $this->layout->load($this->template, 'typesofincome');
		
	}
	
		function cyryptocurrency()
	{
	   //session_start();
	   
	  // $this->template['member'] = $this->pages->get_user_by_id(2);
	   $this->layout->load($this->template, 'cyryptocurrency');
		
	}
		
		
function overview()
	{
	   //session_start();
	   
	  // $this->template['help'] = $this->pages->get_user_by_id(7);
	   $this->layout->load($this->template, 'overview');
		
	}
	function aboutus()
	{
	   //session_start();
	   
	  // $this->template['member'] = $this->pages->get_user_by_id(2);
	   $this->layout->load($this->template, 'aboutus');
		
	}
	function help()
	{
	   //session_start();
	   
	   $this->template['help'] = $this->pages->get_user_by_id(7);
	   $this->layout->load($this->template, 'help');
		
	}
	function faq()
	{
	   //session_start();
	   
	   $this->template['faq'] = $this->pages->get_user_by_id(8);
	   $this->layout->load($this->template, 'faq');
		
	}
	
	function sharedmedia1($media_id=0) 
	{
		if($media_id > 0)
		{    
		 
		    $proejctdata= $this->pages->get_media_by_id($media_id);
			$project_details=$this->pages->get_project_by_id($proejctdata['project_id']);			
			$this->template['media'] = $this->pages->get_media_by_id($media_id);
			$this->template['mediaid'] = $media_id;
			$this->template['logo'] = $project_details['project_logo'];			
		}
		$this->layout->load($this->template, 'shared1');
	}
	
	function sharedmedia($media_id=0)
	{
		if($media_id > 0)
		{   
		
		    $proejctdata= $this->pages->get_media_by_id($media_id);
			$project_details=$this->pages->get_project_by_id($proejctdata['project_id']);		
			$this->template['media'] = $this->pages->get_media_by_id($media_id);
			$this->template['mediaid'] = $media_id;
			$this->template['logo'] = $project_details['project_logo'];
			$this->template['project_name'] = $project_details['project_name'];		
			
					
		}
		$this->layout->load($this->template, 'shared');
	}
	
	function policy()
	{
	   //session_start();
	   //$this->template['policy'] = $this->pages->get_user_by_id(9);
	   $this->layout->load($this->template, 'policy');
		
	}
	
	function terms()
	{
	   //session_start();
	 //  $this->template['policy'] = $this->pages->get_user_by_id(9);
	   $this->layout->load($this->template, 'terms');
		
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
	function contactus()
	{
		//session_start();
		// 
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;

	
			    $this->form_validation->set_rules('first_name','First Name',"trim|required|max_length[15]");
				$this->form_validation->set_rules('last_name','last Name',"trim|required|max_length[15]");
				$this->form_validation->set_rules('email', "Email","trim|required|valid_email");
				$this->form_validation->set_rules('phone','Phone',"trim|required"); 
				$this->form_validation->set_rules('company','Company',"trim|required"); 
				$this->form_validation->set_rules('msg','Message',"trim|required"); 
	
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				$this->form_validation->set_message('min_length', 'The %s field is required');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');
				if ($this->form_validation->run() == FALSE)
				{	
					$this->layout->load($this->template, 'contactus'); 
				}
				else
				{
					                $email=$this->input->post('email');
					                $confirmlink = '';
									$from = 'BitFxCo <bitfxcohelp@gmail.com>';
									$name = $this->input->post('first_name');
									$lname = $this->input->post('last_name');
									$phone = $this->input->post('phone');
									$email = $this->input->post('email');
									$company = $this->input->post('company');
									$msg = $this->input->post('msg');
									
									$to = 'bitfxcohelp@gmail.com';
									$subject = 'BitFxCo Contact Us';								
									$headers = "From: $from" ."\n";
									$namedata='Hello Admin , ';
									
									$message='A user want to contact you. User details are given below<br><br>';
									if($name){
									  $message.='<br> Name :  '.$name.' '.$lname; 
									}
									if($company){
									  $message.='<br> Company Name :  '.$company; 
									}
									if($email){
									  $message.='<br> Email :  '.$email; 
									}
									if($phone){
									  $message.='<br> Phone :  '.$phone; 
									}
									
									if($msg){
									  $message.='<br> Message :  '.$msg; 
									}
																		
									$fullname=$name.' '.$lname;
								
									$message1= $this->emailtemplate($namedata, $subject, $message, $confirmlink);
						
									
								 if($this->sendemail($to, $subject, $message1, $fullname)){
									  $this->session->set_flashdata('success', "Your email sent successfully, Admin will contact you soon.");
									  redirect('page/contactus');
									}else{
									$this->session->set_flashdata('error', "There is some issue, please try after some time.");
									  redirect('page/contactus');
									}
					 
				              }
		
	           }
			   
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

		//view by id
		function view($id = 0)
		{
			$data['id'] = $id;
			$page = $this->pages->get_page($data);
			if($page)
			{
				redirect($page['uri']);
				return;
			}
			else
			{
				$this->layout->load($this->template, '404');
				return;
			}
		}
		
	}

?>
