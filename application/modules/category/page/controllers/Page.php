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
			$this->template['plans']  = $this->pages->get_all_plans();
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
		
	function aboutus()
	{
	   //session_start();
	   
	   $this->template['member'] = $this->pages->get_user_by_id(2);
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
	   $this->template['policy'] = $this->pages->get_user_by_id(9);
	   $this->layout->load($this->template, 'policy');
		
	}
	
	function terms()
	{
	   //session_start();
	   $this->template['policy'] = $this->pages->get_user_by_id(9);
	   $this->layout->load($this->template, 'terms');
		
	}
	
	function contactus()
	{
		//session_start();
		// 
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;

		if ( !$this->input->post('submit') )
		{
			$this->layout->load($this->template, 'contactus');
		}
		else
		{
			if ($this->input->post('submit') == 'Send')
			{
			
			
				
			
				$this->form_validation->set_rules('name',__('Name', $this->template['module']),"trim|required|xss_clean");
				$this->form_validation->set_rules('email', __("Email", $this->template['module']),"trim|required|valid_email|callback__verify_mail");	
				$this->form_validation->set_rules('subject',__('Subject', $this->template['module']),"trim|required");
				$this->form_validation->set_rules('message',__('Message', $this->template['module']),"trim|required");
				
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

				$this->form_validation->set_message('min_length', __('The %s field is required'));
				$this->form_validation->set_message('required', __('The %s field is required'));
				$this->form_validation->set_message('matches', __('The %s field does not match the %s field'));
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');			
								

							
				if ($this->form_validation->run() == FALSE)
				{
					//$this->plugin->add_action('header', array(&$this, '_member_signup_header'));
					$this->layout->load($this->template, 'contactus');
				}
				else
				{       
					
					$this->load->library('email');
					//send password
				/*	$this->email->from($this->system->admin_email, $this->system->site_name);
					$this->email->to($this->input->post('email'));
					$this->email->subject(sprintf(__("Your password for %s", $this->template['module']), $this->system->site_name));
					$customized_message = "";
					$customized_message = $this->plugin->apply_filters('member_registered_msg', $customized_message);
					$message = sprintf(__("Hello %s,\n\nThank you for registering to %s.\nNow you can enter in the site with these information.\n\nUsername: %s\nPassword: %s\n\n", $this->template['module']), $this->input->post('username'), $this->system->site_name, $this->input->post('username'), $password);
					$message .= $customized_message;
					$message .= "\n\n";
					$message .= __("\nThank you.\nThe administrator", $this->template['module']);
					$this->email->message($message);*/

					//$this->email->send();
					//notify admin
					
					mail('rajrohit30@gmail', 'My Subject', 'hello');
				   //  $this->system->admin_email='rajrohit30@gmail.com';
					$this->email->from($this->system->admin_email, $this->system->site_name);
					//echo $this->system->admin_email; exit;
					$this->email->to($this->system->admin_email);
					$this->email->subject(sprintf(__("Contact Form %s", $this->template['module']), $this->system->site_name));
					$this->email->message(sprintf(__("Hello admin,\n\nA new user has just send you the enquery about your site. These are the submitted information.\n\nName: %s\Subject: %s\Email: %s\Message:%s\nThank you.\nThe administrator", $this->template['module']), $this->input->post('name'), $this->input->post('subject'),$this->input->post('email'), $this->input->post('message')));

					$this->email->send(); 
					
					
					//$this->template['title'] = __("User registered", "member");
					//$this->template['message'] = nl2br(sprintf(__("Thank you for registering with this site.\n\nPlease check your email %s and get there your password, then turn back to log in.", "member"), "<b>" . $this->input->post('email') . "</b>"));
					//$this->template['message'] = nl2br(sprintf(__("Thank you for registering with this site.\n\nNow you are able to Log in your account with email address %s. Please go to Login section", "member"), "<b>" . $this->input->post('email') . "</b>"));
					
					$this->session->set_flashdata('notification', __("Email has been sent successfully.", $this->template['module']));
					redirect('page/contactus'); //
					
				}
				
			}
			else
			{
				$this->layout->load($this->template, 'contactus');
			}
		
		}

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
