<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MX_Controller {
		
		var $template = array();
		
		function __construct()
		{
			
			parent::__construct();
			//$this->output->enable_profiler(true);
						
			$this->load->library('administration');
			$this->load->model('email_model');
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->template['module']	= 'email';
			$this->template['admin']		= true;
			$this->_init();
		}
		
		function index()
		{
			//redirect('admin/member/listall');
			redirect('email/admin/listall');
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
				//$where = array('first_name' => $filter, 'last_name' => $filter, 'ref_number' => $filter, 'email' => $filter);
				$where = array('name' => $filter, 'email' => $filter);

			}
			
			if ($this->input->post('sorting')){
			
			     $order=$this->input->post('sorting');
			}
			
			/*else{
			
			$this->input->post('sorting')
			
			}*/
			$this->template['members'] = $this->member_model->get_users($where, array('start' => $start, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('email/admin/listall');
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
		
		function save()
		{
			echo "Not Yet Implemented";
		}

		function createemail()
		{
			// $this->template['pack'] = $this->db->get('package')->result_array();
			// $this->template['start'] = 0;
			$this->layout->load($this->template, 'mail');
		}

		function editemail($para)
		{
			$this->template['m'] = $this->db->get_where('mail',array('id'=>$para))->row_array();
			$this->layout->load($this->template, 'email');
		}

		function editschedule($para)
		{
			$this->template['m'] = $this->db->get_where('schedules',array('id'=>$para))->row_array();
			$this->layout->load($this->template, 'editschedule');
		}

		function deletemail($para)
		{
			$this->db->where('id', $para);
  			$this->db->delete('mail');
  			redirect('/email/admin/mails', 'refresh');
		}

		function deleteschedule($para)
		{
			$this->db->where('id', $para);
  			$this->db->delete('schedules');
  			redirect('/email/admin/scehule', 'refresh');
		}

		function deleteevent($para)
		{
			$this->db->where('id', $para);
  			$this->db->delete('event');
  			redirect('/email/admin/events', 'refresh');
		}

		function mails()
		{
			$this->template['mailtmp'] = $this->db->get('mail')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'mailtmp');
		}

		function events()
		{
			$this->template['mailtmp'] = $this->db->get('event')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'event');
		}

		function scehule()
		{
			$this->template['mailtmp'] = $this->db->get('schedules')->result_array();
			$this->template['start'] = 0;
			$this->layout->load($this->template, 'scehule');
		}

		function addmails(){
			if(isset($_POST) && isset($_POST['savemail'])){
				$subject = $_POST['subject'];
				$body = $_POST['body'];
				$event = $_POST['event'];
				$att_url = '';

				if(isset($_FILES['attachment'])  && !empty($_FILES['attachment'])) {

					if(!isset($_FILES) && isset($HTTP_POST_FILES)){ 
						$_FILES=$HTTP_POST_FILES; 
					}
					$ext = explode('.', $_FILES['attachment']['name'])[1];
					$filename = rand().'_'.time().'.'.$ext;
					//$filename = $_FILES['attachment']['name'];
					if(empty($error)){
						$original= FCPATH.'media/mail_attach/'.$filename;							
						$result= move_uploaded_file($_FILES['attachment']['tmp_name'], $original);
						if($result){ 
							$att_url = base_url().'media/mail_attach/'.$filename;
						}
					}
				}


				$this->db->insert('mail', array('subject'=>$subject, 'body'=>$body, 'attachment'=>$att_url, 'event'=>$event));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Template Added Successfully.');
					$this->layout->load($this->template, 'mail');
				}else{
					$this->session->set_flashdata('notification', 'Template Insertion Failed.');
					$this->layout->load($this->template, 'mail');
				}
			}else{
				$this->layout->load($this->template, 'mail');
			}
		}

		function addschedule(){
			if(isset($_POST) && isset($_POST['savesche'])){
				$mailtemplate = $_POST['mailtemplate'];
				$event = $_POST['event'];
				$evname = $this->db->get_where('event', array('id'=>$event))->row_array()['event'];
				$remark = $_POST['remark'];
				if(!empty($_POST['datetime'])){
					$datetime = $_POST['datetime'];
				}else{
					$datetime = $_POST['days'];
				}
				if(!empty($_POST['users'])){
					$users = implode(',',$_POST['users']);
				}else{
					$users = '0';
				}				
				$this->db->insert('schedules', array('mailtemp'=>$mailtemplate, 'event'=>$event, 'stime'=>$datetime, 'usermails'=>$users, 'remark'=>$remark, 'descr'=>'every '.$datetime.' days after " '.$evname.' "'));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Schedule Added Successfully.');
					redirect('/email/admin/scehule', 'refresh');
				}else{
					$this->session->set_flashdata('notification', 'Schedule Insertion Failed.');
					$this->layout->load($this->template, 'addschedule');
				}
			}else{
				$this->layout->load($this->template, 'addschedule');
			}
		}

		function addevent(){
			if(isset($_POST) && isset($_POST['savesche'])){
				$eventname = $_POST['eventname'];
				$this->db->insert('event', array('event'=>$eventname));
				if($this->db->insert_id()){
					$this->session->set_flashdata('notification', 'Event Added Successfully.');
					$this->layout->load($this->template, 'addevent');
				}else{
					$this->session->set_flashdata('notification', 'Event Insertion Failed.');
					$this->layout->load($this->template, 'addevent');
				}
			}else{
				$this->layout->load($this->template, 'addevent');
			}
		}

		function updatemails(){
			if(isset($_POST) && isset($_POST['savemail'])){
				$subject = $_POST['subject'];
				$body = $_POST['body'];
				$event = $_POST['event'];
				$para = $_POST['para'];
				$att = $_POST['att'];
				$att_url = '';

				if(isset($_FILES['attachment'])  && !empty($_FILES['attachment']) && !empty($_FILES['attachment']['name'])) {
					if(!isset($_FILES) && isset($HTTP_POST_FILES)){ 
						$_FILES=$HTTP_POST_FILES; 
					}
					$ext = explode('.', $_FILES['attachment']['name'])[1];
					$filename = rand().'_'.time().'.'.$ext;
					//$filename = $_FILES['attachment']['name'];
					if(empty($error)){
						$original= FCPATH.'media/mail_attach/'.$filename;							
						$result= move_uploaded_file($_FILES['attachment']['tmp_name'], $original);
						if($result){ 
							$att_url = base_url().'media/mail_attach/'.$filename;
						}
					}
				}else{
					$att_url = $att;
				}
				$this->db->trans_start();
				$this->db->where('id', $para);
				$this->db->update('mail', array('subject'=>$subject, 'body'=>$body, 'attachment'=>$att_url, 'event'=>$event));
				$this->db->trans_complete();
				if($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('notification', 'Template Updation Failed.');
					$this->template['m'] = $this->db->get_where('mail',array('id'=>$para))->row_array();
					$this->layout->load($this->template, 'email');
				}else{
					$this->session->set_flashdata('notification', 'Template Updation Successfully.');
					$this->template['m'] = $this->db->get_where('mail',array('id'=>$para))->row_array();
					$this->layout->load($this->template, 'email');
				}
			}else{
				$this->layout->load($this->template, 'mail');
			}
		}

		function updateschedule(){
			if(isset($_POST) && isset($_POST['savesche'])){
				$mailtemplate = $_POST['mailtemplate'];
				$event = $_POST['event'];
				$remark = $_POST['remark'];
				$evname = $this->db->get_where('event', array('id'=>$event))->row_array()['event'];
				if(!empty($_POST['datetime'])){
					$datetime = $_POST['datetime'];
				}else{
					$datetime = $_POST['days'];
				}
				$para = $_POST['para'];
				if(!empty($_POST['users'])){
					$users = implode(',',$_POST['users']);
				}else{
					$users = '0';
				}

				$this->db->trans_start();
				$this->db->where('id', $para);
				$this->db->update('schedules', array('mailtemp'=>$mailtemplate, 'event'=>$event, 'stime'=>$datetime, 'usermails'=>$users, 'remark'=>$remark, 'descr'=>'every '.$datetime.' days after " '.$evname.' "'));
				$this->db->trans_complete();
				if($this->db->trans_status() === FALSE) {
					$this->session->set_flashdata('notification', 'Schedule Updation Failed.');
					$this->template['m'] = $this->db->get_where('schedules',array('id'=>$para))->row_array();
					$this->layout->load($this->template, 'editschedule');
				}else{
					$this->session->set_flashdata('notification', 'Schedule Updation Successfully.');
					$this->template['m'] = $this->db->get_where('schedules',array('id'=>$para))->row_array();
					$this->layout->load($this->template, 'editschedule');
				}
			}else{
				$this->layout->load($this->template, 'scehule');
			}
		}

		function bulkmail($start = 0, $limit = 20, $order = 'id') 
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
			$this->template['mails'] = $this->db->get('mail')->result_array();
			$this->template['members'] = $this->email_model->get_users($where, array('start' => $start, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('email/admin/listall');
			$config['total_rows'] = $this->email_model->member_total;
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;			
			$this->layout->load($this->template, 'bulkmail');
			return;
		}

		function sendbulkmail($para){
			if(implode(',',$_POST['emails']) == 'all'){   
				$e = array();
				$p = $this->db->query('SELECT email FROM ci_users')->result_array();
				foreach ($p as $pa) {
					$e[] = $pa['email'];
				}
				$d['email'] = implode(',',$e);
			}else{
				$d['email'] = implode(',',$_POST['emails']);
			}	
			$d['mailn'] = $this->db->get_where('mail', array('id'=>$para))->row_array();

			$to = $d['email'];
			$subject = $d['mailn']['subject'];
			$message = $d['mailn']['body'];

			$attachment = $d['mailn']['attachment'];
			$ext = explode('.', $d['mailn']['attachment']);
		    $from = 'Greg <Greg@blabeey.com>';
		    $headers = "From: $from";

		    $semi_rand = md5(time());
		    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
		    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
		    $message .= "--{$mime_boundary}\n";
	        $data = chunk_split(base64_encode(file_get_contents($attachment)));
	        $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"Blabeey.$ext[3]\"\n" .
	        "Content-Disposition: attachment;\n" . " filename=\"Blabeey.$ext[3]\"\n" .
	        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
	        $message .= "--{$mime_boundary}\n";

			mail($to, $subject, $message, $headers);
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
					   $this->email_model->insert_user($data);
					   $this->session->set_flashdata('notification', "User registered");
					   redirect('email/admin/listall');
				   
				
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