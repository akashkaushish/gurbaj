<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
       ob_start();
	class Admin extends MX_Controller {

		var $template = array();

		function __construct()

		{
			parent::__construct();
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
			redirect('member/admin/listall');
		}

		function _init() 
		{
			if (!isset($this->system->login_signup_enabled)) 
			{
				$this->system->login_signup_enabled = 1;
			}
		}
		
		
  function admincommission($start = 0, $limit = 20, $order = 'id') 
      {

			$where = array();
		

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
				//$where = array('fname' => $mfilter, 'lname' => $mfilter,'phone' => $mfilter, 'email' => $mfilter);
			}
			$this->template['commission'] = $this->member_model->admincommission($mfilter, array('start' => $start,'limit' => $limit, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/admin/admincommission');
			$config['total_rows'] = $this->member_model->admincommission_count($mfilter);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;	
			$this->layout->load($this->template, 'admincommission');
			return;

		}			
		
  function royaltypayment($start = 0, $limit = 20, $order = 'id') 
      {

			$where = array();
		

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
				//$where = array('fname' => $mfilter, 'lname' => $mfilter,'phone' => $mfilter, 'email' => $mfilter);
			}
			$this->template['members'] = $this->member_model->royaltypayment($mfilter, array('start' => $start,'limit' => $limit, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/admin/royaltypayment');
			$config['total_rows'] = $this->member_model->royaltypayment_count($mfilter);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;	
			$this->layout->load($this->template, 'royaltypayment');
			return;

		}		
		

  function listall($start = 0, $limit = 10, $order = 'id') 
      {

			$where = array();
			if ($this->input->post('sorting')){
				$order=$this->input->post('sorting');
			}

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
				//$where = array('fname' => $mfilter, 'lname' => $mfilter,'phone' => $mfilter, 'email' => $mfilter);
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
  
  function payrotalty($id = null) 
		{			
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this; 
			$this->template['module']	= 'member';
			$this->form_validation->set_rules('amount','Amount',"trim|required");	
			$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
			$this->form_validation->set_message('min_length', 'The %s field is required');
			$this->form_validation->set_message('required', 'The %s field is required');
			$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
			$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');	
			

			if ( $id == 0 || $id == '' )
			{
				$this->session->set_flashdata("error", "This transaction doesn't exist");
				redirect("admin/member/royaltypayment");

			}

			$this->template['id'] = $id;			
			if ($this->template['member'] = $this->member_model->get_royaltypayment_by_id($id))
			{				

				if ($this->form_validation->run() == FALSE)
				{	 
					$this->layout->load($this->template, 'payroyalty');
				}
				else
				{
				
				 $userid=$this->template['member']['user_id'];
					$amount=$this->input->post('amount');
					//update royalty_payment table
					$data = array(
					    'amount' => $amount,
						'status' =>1,
						'paid_date' => $today
					);
					
					$paid=$this->member_model->update_royalty_payment($id, $data);
					
					if($paid){
					   
					 //update user transaction table
					    $today = date('Y-m-d');
					 	$royaltydata=array(
								'user_id' => $userid,
								'trans_type ' => 'credit',
								'amount' => $amount,
								'would_be_amount' => 0, 
								'comm_by_plan_id' => 0,
								'comm_by_level' => 0,
								'comm_by_user_id' => 0,
								'comm_by_username' => 0,
								'trans_reason' => 'royalty',
								'date_created' => $today
							); 
					    $payout = $this->member_model->insert_payout($royaltydata);
					
					//update user wallet
						$userdata= $this->member_model->get_user_by_id($userid);
						$walletamount=$userdata['wallet_total']+$amount;
						$walletupdate = array('wallet_total' =>  $walletamount);						
						$updateuserwallet=$this->member_model->update_user($userid, $walletupdate);
						
						
					//update user wallet
					
					}else{
					
						/*	$data = array(
							  'transaction_id' => $this->input->post('transaction_id'),
							  'amount' => $this->input->post('amount'),
							  'status' =>2
							);
							
							$paid=$this->member_model->update_royalty_payment($user_id, $data);*/
					}
				
					
						
					$this->session->set_flashdata('success', "Pay rotalty is given to user");
					redirect("member/admin/royaltypayment");
				}

			}
			else 
			{
				$this->session->set_flashdata("error", "This transaction doesn't exist");
				redirect("member/admin/royaltypayment");
			}				

		}
  function payrotalty123($id)
	    {
		        $this->load->library('form_validation');
				$this->form_validation->CI =& $this;
				$this->form_validation->set_rules('oldpassword','Old Password',"trim|required");
				$this->form_validation->set_rules('passconf', "Confirm Password", "trim|required");
				$this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');
				$this->form_validation->set_message('required', 'The %s field is required');
				$this->form_validation->set_message('matches', 'The %s field does not match the %s field');
				$this->form_validation->set_message('valid_email', 'The email address you entered is not valid.');	
						
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'payroyalty');
				}
				else
				{	
					$oldpassword = $this->user->_prep_password($this->input->post('oldpassword'));
					if($oldpassword != '')
					{
						if ($this->member_model->exists(array('password' => $oldpassword, 'id' =>1))) 
						{
							$data = array('password' => $this->user->_prep_password($this->input->post('password')));
							$this->member_model->update_user(1, $data);
							$this->session->set_flashdata('success', "Password Changed Successfully !");
							redirect('member/admin/changepassword');
						}else{
							$this->session->set_flashdata('error', "Please enter correct Old password.");
							redirect('member/admin/changepassword');
						}
					}else{
						$this->session->set_flashdata('error', "Please enter correct Old paswword.");
						$this->layout->load($this->template, 'adminchangepassword');
						return FALSE;
					}
				}
		}
  
  function changepassword()
	    {
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
					$this->layout->load($this->template, 'adminchangepassword');
				}
				else
				{	
					$oldpassword = $this->user->_prep_password($this->input->post('oldpassword'));
					if($oldpassword != '')
					{
						if ($this->member_model->exists(array('password' => $oldpassword, 'id' =>1))) 
						{
							$data = array('password' => $this->user->_prep_password($this->input->post('password')));
							$this->member_model->update_user(1, $data);
							$this->session->set_flashdata('success', "Password Changed Successfully !");
							redirect('member/admin/changepassword');
						}else{
							$this->session->set_flashdata('error', "Please enter correct Old password.");
							redirect('member/admin/changepassword');
						}
					}else{
						$this->session->set_flashdata('error', "Please enter correct Old paswword.");
						$this->layout->load($this->template, 'adminchangepassword');
						return FALSE;
					}
				}
		}

function buildtree($id,$all=array())
{
    
	$src_arr=$this->member_model->get_user_by_id1($id);
	$alldata=$all;
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
		
  function mynew($id,$planid,$amount,$planactivedate){
  
   $level=array('1'=>2,'2'=>1,'3'=>1,'4'=>.5,'5'=>.5,'6'=>.25,'7'=>.25);
	
	$data=$this->member_model->get_user_by_id1($id);
	
	//print_r($data[0]); exit;
	$child["$id"]=$id;
	$hiData = $this->buildtree($id,$child);
	
	$removed = array_shift($hiData);
	$username=$data[0]['fname'].' '.$data[0]['lname'];
	$userid=$data[0]['id'];

    $i=1;
	$percentage=0;	
	$hiData1=array_slice($hiData,0,6);
	
		
	foreach($hiData1 as $ids){
		//break after 7 level  
		/*if($i > 7){
		   break;
		}*/
		
   $userdata=$this->member_model->get_user_by_id1($ids);
		
	if($userdata[0]['level_bonus'] >= $i){
		
	   $commissionamount=($amount/100)*$level[$i];
		
		for($j=1;$j<=4;$j++){
		
			$userdata1=$this->member_model->get_user_by_id1($ids);
			$monthdate='';		
			$monthdate = date('Y-m-d', strtotime('+'.$j.' month', strtotime($planactivedate)));
		 
		   //enter data in  ci_point_user_transaction
		  $userpoint_transaction = array('user_id' =>$ids, 'commission_amount' =>$commissionamount,'commission_month' =>$monthdate,'commission_percentage'=>$level[$i],'is_paid' =>0,'comm_by_user_id' =>$id,'comm_by_username' =>$data[0]['fname'].' '.$data[0]['lname'],'comm_by_plan_id' =>$planid,'comm_by_level' =>$i,'date_created' =>@date("Y-m-d"));
		  $insert_point_transaction=$this->member_model->insert_bonus_level($userpoint_transaction);
		
		
		//add data to the parnt user wallet
		   if($insert_point_transaction)
		    {
		      $updateuserdata = array('show_bonus' =>$userdata1[0]['show_bonus']+$commissionamount);
			  $this->member_model->update_user($ids, $updateuserdata);
		    }
	     }
	   } else{}
	  $i++;
    }
  }

 function bonuslevel($id){

   $plandetails = $this->member_model->get_userpayment_by_id($id);
  
   if(isset($plandetails['user_id']) && ($plandetails['user_id'])){ 
   
		  $userdata = $this->member_model->get_user_by_id($plandetails['user_id']);
		  
		  //check alraedy paid
		  if($userdata['is_level_bonus_paid']==1){
		         $this->session->set_flashdata('error', "Show commission is already set !");
				 redirect('member/admin/userpayment');
		  }//
		  
		  
		  if(isset($userdata['ref_id']) && ($userdata['ref_id'] !='')){
		        $this->mynew($plandetails['user_id'],$plandetails['plan_id'],$plandetails['payment_amount'],$plandetails['plan_activation_date']);
				
				//
				 $updateuser = array('is_level_bonus_paid' =>1);
				 $this->member_model->update_user($userdata['id'], $updateuser);
				 
			     $this->session->set_flashdata('success', "Show commission is set !");
				 redirect('member/admin/userpayment');
			  
		  }else{
		  
		  
		  }
   
   }else{
   
   
   }
}		
		
		
 function showbonus($start = 0, $limit = 20, $order = 'id') 
      {

			$where = array();

			if ($this->input->post('sorting')){
				$order=$this->input->post('sorting');
			}
			//for searching
		
            $filter='';
		
			if ($this->template['filter'] !='')
			{
				$where = array('fname' => $mfilter, 'lname' => $mfilter,'phone' => $mfilter, 'email' => $mfilter);
			}
			$this->template['members'] = $this->member_model->get_user_payment_bonus($filter, array('start' => $start,'limit' => $limit, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/admin/showbonus');
			//$config['total_rows'] = $this->member_model->get_user_payment_total($filter);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;	
			$this->layout->load($this->template, 'showbonus');
			return;
		}		
  function userpayment($start = 0, $limit = 20, $order = 'id') 
      {

			$where = array();

			if ($this->input->post('sorting')){
				$order=$this->input->post('sorting');
			}
			//for searching
		
            $filter='';
		
			if ($this->template['filter'] !='')
			{
				$where = array('fname' => $mfilter, 'lname' => $mfilter,'phone' => $mfilter, 'email' => $mfilter);
			}
			$this->template['members'] = $this->member_model->get_user_payment($filter, array('start' => $start,'limit' => $limit, 'order_by' => $order));
			//echo "<pre>"; print_r($this->template['members']); exit;
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] ='First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('member/admin/userpayment');
			$config['total_rows'] = $this->member_model->get_user_payment_total($filter);
			$config['per_page'] = $limit; 
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;	
			$this->layout->load($this->template, 'userpayment');
			return;
		}	

		function add_months($months, DateTime $dateObject) 
		{
			$next = new DateTime($dateObject->format('Y-m-d'));
			$next->modify('last day of +'.$months.' month');
	
			if($dateObject->format('d') > $next->format('d')) {
				return $dateObject->diff($next);
			} else {
				return new DateInterval('P'.$months.'M');
			}
		}
	
	function endCycle($d1, $months)
		{
			$date = new DateTime($d1);
	
			// call second function to add the months
			$newDate = $date->add($this->add_months($months, $date));
	
			// goes back 1 day from date, remove if you want same day of month
			$newDate->sub(new DateInterval('P1D')); 
	
			//formats final date to Y-m-d form
			$dateReturned = $newDate->format('Y-m-d'); 
	
			return $dateReturned;
		}

	function testdate()
	{
		$today = date('Y-m-d');
		echo $plan_activation_date = '2020-06-21'; echo "<br/>";
		echo $last = date("Y-m-t", strtotime($plan_activation_date)); echo "<br/>";
		
		for($i=1;$i<26;$i++)
		{
			//$nextmonth = date('Y-m-d', strtotime('+'.$i.' month', strtotime($last)));
			$nextmonth = $this->endCycle($last, $i);
			echo $nextmonthend = date("Y-m-t", strtotime($nextmonth));  echo "<br/>";
		}
	}
	function addupcomingpayout($user_plan_id)
	{	
		if($user_plan_id > 0)
		{
			$plandetails = $this->member_model->get_userpayment_by_id($user_plan_id);
			$user_id = $plandetails['user_id'];
			$plan_id = $plandetails['plan_id'];
			$user = $this->member_model->get_user_by_id($user_id);
			if($user['is_paid'] > 0 && $user['user_plan'] > 0 && $user['user_plan'] == $plan_id)
			{
				$plan_activation_date = $plandetails['plan_activation_date'];
				if($plan_id > 0)
				{
					$plan = $this->member_model->get_plan_by_id($plan_id);
					if(count($plan) > 0)
					{
						$plan_price = $plan['price'];
						$months = $plan['months'];
						for($i=0;$i<$months;$i++)
						{
							$pay_month = $i+1;
							$month_paid_status = $this->member_model->get_month_upcoming_payout_paid_status($user_id, $plan_id, $pay_month);
							if($month_paid_status == 0)
							{
								$payout_month_detail = $this->member_model->get_payout_detail_by_month($pay_month);
								if($payout_month_detail && $payout_month_detail['percent'] > 0)
								{
									$today = date('Y-m-d');
									$last = date("Y-m-t", strtotime($plan_activation_date)); 

									if($pay_month ==1)
									{
										$todal_days_in_month = cal_days_in_month(CAL_GREGORIAN,date("m", strtotime($plan_activation_date)),date("Y", strtotime($plan_activation_date))); 
										$earlier = new DateTime($plan_activation_date);
										$later = new DateTime($last);
										$days = $later->diff($earlier)->format("%a"); 
										

										$paid_amount = $plan_price*$payout_month_detail['percent']/100; 
										$paid_amount_days = ($paid_amount/$todal_days_in_month)*$days; 
										$data = array(
											'user_id' => $user_id,
											'plan_id' => $plan_id,
											'plan_price' => $plan_price,
											'pay_amount' => $paid_amount_days,
											'month' => $pay_month,
											'percentage' => $payout_month_detail['percent'],
											'pay_date' => $last,
											'days' => $days,
											'created_date' => $today	
											);
										
									}else{
										
										//$nextmonth = date('Y-m-d', strtotime('+'.$i.' month', strtotime($last)));
										$nextmonth = $this->endCycle($last, $i);
										$nextmonthend = date("Y-m-t", strtotime($nextmonth));

										$paid_amount = $plan_price*$payout_month_detail['percent']/100; 

										$data = array(
											'user_id' => $user_id,
											'plan_id' => $plan_id,
											'plan_price' => $plan_price,
											'pay_amount' => $paid_amount,
											'month' => $pay_month,
											'percentage' => $payout_month_detail['percent'],
											'pay_date' => $nextmonthend,
											'created_date' => $today	
											);
									}
									
									$upcoming_payout_id = $this->member_model->insert_upcoming_payout($data);
									
								}
							}

						}

						$data_user = array(
							'is_upcoming_payout_paid' => 1
							);
						$this->member_model->update_user($user_id, $data_user);

					}
				}
			}

			$this->session->set_flashdata("success", "Upcoming Payout added successfully.");
			redirect('member/admin/userpayment');
		}
	}
	function userdownline($user_id) 
	{
		if ( isset($user_id) &&  $user_id > 0)
		{
			
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
			
			if($this->template['member'] = $this->member_model->get_user_by_id($user_id))
			{
				$downline = $this->member_model->get_my_downline_admin($mfilter, $user_id);
				$downline_array = array();
				$this->template['downline'] = $downline;
				$this->layout->load($this->template, 'userdownline');
				return;
			}
		}
	}		
	
		function userdownline_old($user_id) 
		{
			if ( isset($user_id) &&  $user_id > 0)
			{
				if($this->template['member'] = $this->member_model->get_user_by_id($user_id))
				{
					$downline = $this->member_model->get_my_downline($user_id);
					$downline_array = array();
					foreach($downline as $downline)
					{
						$downline_array[] = $downline;
						if($downline['id'] > 0)
						{
							$downline1 = $this->member_model->get_my_downline($downline['id']);
							foreach($downline1 as $downline1)
							{
								$downline_array[] = $downline1;
							}
						}
						
					}
					//echo "<pre>"; print_r($downline_array); exit;
					$this->template['mydownline'] = $downline_array;
					$this->layout->load($this->template, 'userdownline');
					return;
				}
			}
		}


		function withdrawrequests($start = 0, $limit = 20, $order = 'id') 
		{
  			  $this->template['withdraw'] = $this->member_model->get_user_withdraw_requests();
			 
			  $this->layout->load($this->template, 'userwithdraw');
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
					$this->session->set_flashdata('error', "We already have this User id in our database.");
					$this->layout->load($this->template, 'create'); 
					return FALSE;
				}

				if ($this->member_model->exists(array('email' => $this->input->post('email'))))
				{	
					$this->session->set_flashdata('error', "We already have this email address in our database.");
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
				$this->session->set_flashdata('success', "User registered successfully !");
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
				$this->session->set_flashdata("error", "This member doesn't exist");
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

						$this->session->set_flashdata('error', "We already have this User id in our database.");

						$this->layout->load($this->template, 'edit'); 

						return FALSE;

					}

					if ($this->member_model->exists(array('email' => $this->input->post('email'), 'id !=' => $user_id)))
					{
						$this->session->set_flashdata('error', "We already have this email address in our database.");
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
					$this->session->set_flashdata('success', "User saved");
					redirect("member/admin/listall");
				}

			}
			else 
			{
				$this->session->set_flashdata("error", "This member doesn't exist");
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
				$this->session->set_flashdata("error", "This member doesn't exist");
				redirect("member/admin/listall");
			}
		}

 function deleteuser($user_id)
   {
      
			if ($user_id > 0)
             {
				$this->db->delete('users', array('id' => $user_id));
				$this->db->delete('user_roles', array('user_id' => $user_id));
				$this->session->set_flashdata("success", "User deleted");
				redirect("member/admin/listall");
			}
			else
			{
				$this->session->set_flashdata("error", "User does not exist.");
				redirect("member/admin/listall");
			}
   }
   function activateuser($user_id)
   {
		$data=array('is_active'=>1);
		$userdata=$this->member_model->update_user($user_id,$data);
		$this->session->set_flashdata("success", "User activated successfully.");
		redirect("member/admin/");
   }
   function confirmwithdraw($waithdraw_id)
   {
		
		$wdata=$this->member_model->get_withdraws_by_id($waithdraw_id);
		
		$amount=$wdata[0]['amount'];
		$transferamount=($amount*5)/100;
		$amount_after_deduction=$amount-$transferamount;
		
		//update withdrawl table
		$data=array('is_active'=>1,'amount_after_deduction'=>$amount_after_deduction,'transfer_charge'=>$transferamount);
		
		$userdata=$this->member_model->update_withdraw_request($waithdraw_id,$data);
		
		//enter the date into ci_admin_commission
		$date = date('Y-m-d');
		$withdrawsdata=array('user_id'=>$wdata[0]['id'],'total_amount'=>$amount,'amount_after_discount'=>$amount_after_deduction,'discounted_amount'=>$transferamount,'commission_percentage'=>5,'commission_reason'=>'Withdrawal Charges','date_created'=>$date );
		$admin_commission=$this->member_model->insert_admin_commission($withdrawsdata);
		
      //enter data indo user transection
			$data_user_trans1 = array(
						'user_id' => $wdata[0]['id'],
						'trans_type' => 'debit',
						'amount' => $amount,
						'transfer_by' => 0,
						'transfer_by_id' => 0,
						'trans_reason' => 'Withdrawal Amount', 
						'is_transfer' => 1,  
						'date_created' => $date
			     );  
			$user_transaction_id1 = $this->member_model->insert_user_transaction($data_user_trans1);
	  
	  
	  
	  
	  
		$this->session->set_flashdata("success", "Request paid successfully.");
		redirect("member/admin/withdrawrequests");
   }


   function confiruserplan($userplanid)
   {	
		if ($userplanid > 0)
		{
			$userplandata=$this->member_model->get_userpayment_by_id($userplanid);
			if(isset($userplandata['user_id']) && $userplandata['user_id'] > 0)
			{ 
				$plan_id = $userplandata['plan_id'];
				$userdata = $this->member_model->get_user_by_id($userplandata['user_id']); 
				
				
				$plandata = $this->member_model->get_plan_by_id($plan_id); 
				$bonus=($plandata['price']-100)/100;
			
				if(isset($userdata['is_paid']) && $userdata['is_paid'] > 0 && isset($userdata['user_plan']) && $userdata['user_plan'] > 0)
				{ 
				 
					$todaydate = date('Y-m-d');
					//$days =  762;
					$onday = 1;
					$next_day_date = date('Y-m-d', strtotime($todaydate. ' + '.$onday.' days')); 
					$next_day_date1 = strtotime($next_day_date);
					$enddate = date('Y-m-d', strtotime('+25 month', $next_day_date1));
					$data=array('is_confirmed'=>1,'plan_activation_date'=>$next_day_date, 'plan_end_date'=>$enddate);
					$user_plandata=$this->member_model->user_plan_data($userplanid,$data);
					
					 if($userdata['level_bonus'] < 7 ){
					  
						$data=array('user_plan'=> $plan_id, 'is_paid'=>1,'level_bonus'=>$bonus);
						$userdataupdate=$this->member_model->update_user($userdata['id'],$data);
					  }
					//update parent user level
				   if(isset($userdata['ref_code_used']) && ($userdata['ref_code_used'] !='')){
					//get parent user data
					  $parentdata = $this->member_model->get_user_by_id($userdata['ref_id']);
					    //max level 7
					  if($parentdata['level_bonus'] < 7){
					     $parentbonus=array('level_bonus'=>$parentdata['level_bonus']+1);
					     $updateparentdata=$this->member_model->update_user($parentdata['id'],$parentbonus);
					  }
					}
					$data_business = array('is_confirmed'=>1);
					$this->member_model->update_user_business($plan_id, $data_business);
					$this->session->set_flashdata("success", "Plan activated successfully.");
					redirect("member/admin/userpayment");
									
				}else{  
				  
					$todaydate = date('Y-m-d');
					//$days =  762;
					$onday = 1;
					$next_day_date = date('Y-m-d', strtotime($todaydate. ' + '.$onday.' days')); 
					$next_day_date1 = strtotime($next_day_date);
					$enddate = date('Y-m-d', strtotime('+25 month', $next_day_date1));
					$data=array('is_confirmed'=>1,'plan_activation_date'=>$next_day_date, 'plan_end_date'=>$enddate);
					$user_plandata=$this->member_model->user_plan_data($userplanid,$data);
					 
					 if($userdata['level_bonus'] < 7){
					    $data=array('user_plan'=> $plan_id, 'is_paid'=>1,'level_bonus'=>$bonus);
					    $userdataupdate=$this->member_model->update_user($userdata['id'],$data);
					   }
					//update parent user level
				   if(isset($userdata['ref_code_used']) && ($userdata['ref_code_used'] !='')){
					//get parent user data
					  $parentdata = $this->member_model->get_user_by_id($userdata['ref_id']);
					  //max level 7
					  if($parentdata['level_bonus'] < 7){
						  $parentbonus=array('level_bonus'=>$parentdata['level_bonus']+1);
						  $updateparentdata=$this->member_model->update_user($parentdata['id'],$parentbonus);
					  }
					//  echo $this->db->last_query(); exit;
					
					}
					$data_business = array('is_confirmed'=>1);
					$this->member_model->update_user_business($plan_id, $data_business);
					
					$this->session->set_flashdata("success", "Plan activated successfully.");
					redirect("member/admin/bonuslevel/".$userplanid);					
					//redirect("member/admin/userpayment");
					
				}
			}else{
				$this->session->set_flashdata("error", "User Plan seems invalid.");
				redirect("member/admin/userpayment");
			}
		}else{
			$this->session->set_flashdata("error", "User plan data does not exist.");
			redirect("member/admin/userpayment");
		}
   }
   function confiruserplanOLD($userplanid)
   {
		if ($userplanid > 0)
		{
			$userplandata=$this->member_model->get_userpayment_by_id($userplanid);
			//echo "<pre>"; print_r($userplandata); exit;
			if(isset($userplandata['user_id']) && $userplandata['user_id'] > 0)
			{
				$userdata = $this->member_model->get_user_by_id($userplandata['user_id']); 
				if(isset($userdata['is_paid']) && $userdata['is_paid'] == 0)
				{
					//$data=array('is_paid'=>1);
					//$userdata=$this->member_model->update_user($userdata['user_id'],$data);
					$plandata = $this->member_model->get_plan_by_id($userplandata['plan_id']); 
					if(isset($plandata['days']) && $plandata['days'] > 0)
					{ 
						$days = $plandata['days'];
						$todaydate = date('Y-m-d');
						$enddate = date('Y-m-d', strtotime($todaydate. ' + '.$days.' days')); 
						$data=array('is_confirmed'=>1,'plan_activation_date'=>$todaydate, 'plan_end_date'=>$enddate);
						$user_plandata=$this->member_model->user_plan_data($userplanid,$data);
						if(isset($userdata['ref_code_used']) && $userdata['ref_code_used'] != "")
						{
							// First Level Commission
							$user1 = $this->member_model->get_user_by_refcode($userdata['ref_code_used']); 
							if(isset($user1['is_paid']) && $user1['is_paid'] > 0)
							{	 
								$amt1 = ($plandata['price']*10)/100;
								$comm_by_name = $userdata['fname']." ".$userdata['lname']; 
								$data_user_trans1 = array(
									'user_id' => $user1['id'],
									'trans_type' => 'credit',
									'amount' => $amt1,
									'comm_by_user_id' => $userdata['id'],
									'comm_by_username' => $comm_by_name,
									'comm_by_plan_id' => $userplanid,
									'comm_by_level' => 1,
									'trans_reason' => 'commission',  
									'date_created' => date('Y-m-d H:i:s')
									);  
								$user_transaction_id1 = $this->member_model->insert_user_transaction($data_user_trans1);
								$this->member_model->update_user_transaction($user1['id'], $amt1);

								// Second Level Commission
								if(isset($user1['ref_code_used']) && $user1['ref_code_used'] != "")
								{
									$user2 = $this->member_model->get_user_by_refcode($user1['ref_code_used']); 
									if(isset($user2['is_paid']) && $user2['is_paid'] > 0)
									{	 
										$amt2 = ($plandata['price']*4)/100;
										$data_user_trans2 = array(
											'user_id' => $user2['id'],
											'trans_type' => 'credit',
											'amount' => $amt2,
											'comm_by_user_id' => $userdata['id'],
											'comm_by_username' => $comm_by_name,
											'comm_by_plan_id' => $userplanid,
											'comm_by_level' => 2,
											'trans_reason' => 'commission',  
											'date_created' => date('Y-m-d H:i:s')
											);  
										$user_transaction_id2 = $this->member_model->insert_user_transaction($data_user_trans2);
										$this->member_model->update_user_transaction($user2['id'], $amt2);

										//Third Level Commission 
										if(isset($user2['ref_code_used']) && $user2['ref_code_used'] != "")
										{
											$user3 = $this->member_model->get_user_by_refcode($user2['ref_code_used']);
											if(isset($user3['is_paid']) && $user3['is_paid'] > 0)
											{
												$amt3 = ($plandata['price']*3)/100;
												$data_user_trans3 = array(
													'user_id' => $user3['id'],
													'trans_type' => 'credit',
													'amount' => $amt3,
													'comm_by_user_id' => $userdata['id'],
													'comm_by_username' => $comm_by_name,
													'comm_by_plan_id' => $userplanid,
													'comm_by_level' => 3,
													'trans_reason' => 'commission',  
													'date_created' => date('Y-m-d H:i:s')
													);  
												$user_transaction_id3 = $this->member_model->insert_user_transaction($data_user_trans3);
												$this->member_model->update_user_transaction($user3['id'], $amt3);

												//Fourth Level Commission
												if(isset($user3['ref_code_used']) && $user3['ref_code_used'] != "")
													{
														$user4 = $this->member_model->get_user_by_refcode($user3['ref_code_used']);
														if(isset($user4['is_paid']) && $user4['is_paid'] > 0)
														{
															$amt4 = ($plandata['price']*2)/100;
															$data_user_trans4 = array(
																'user_id' => $user4['id'],
																'trans_type' => 'credit',
																'amount' => $amt4,
																'comm_by_user_id' => $userdata['id'],
																'comm_by_username' => $comm_by_name,
																'comm_by_plan_id' => $userplanid,
																'comm_by_level' => 4,
																'trans_reason' => 'commission',  
																'date_created' => date('Y-m-d H:i:s')
																);  
															$user_transaction_id4 = $this->member_model->insert_user_transaction($data_user_trans4);
															$this->member_model->update_user_transaction($user4['id'], $amt4);

															// Fifth Level Commission
															if(isset($user4['ref_code_used']) && $user4['ref_code_used'] != "")
															{
																$user5 = $this->member_model->get_user_by_refcode($user4['ref_code_used']);
																if(isset($user5['is_paid']) && $user5['is_paid'] > 0)
																{
																	$amt5 = ($plandata['price']*1)/100;
																	$data_user_trans5 = array(
																		'user_id' => $user5['id'],
																		'trans_type' => 'credit',
																		'amount' => $amt5,
																		'comm_by_user_id' => $userdata['id'],
																		'comm_by_username' => $comm_by_name,
																		'comm_by_plan_id' => $userplanid,
																		'comm_by_level' => 5,
																		'trans_reason' => 'commission',  
																		'date_created' => date('Y-m-d H:i:s')
																		); 
																	$user_transaction_id5 = $this->member_model->insert_user_transaction($data_user_trans5);
																	$this->member_model->update_user_transaction($user5['id'], $amt5); 

																	//Sixth Level Commission
																	if(isset($user5['ref_code_used']) && $user5['ref_code_used'] != "")
																	{
																		$user6 = $this->member_model->get_user_by_refcode($user5['ref_code_used']);
																		if(isset($user6['is_paid']) && $user6['is_paid'] > 0)
																		{
																			$amt6 = ($plandata['price']*0.5)/100;
																			$data_user_trans6 = array(
																				'user_id' => $user6['id'],
																				'trans_type' => 'credit',
																				'amount' => $amt6,
																				'comm_by_user_id' => $userdata['id'],
																				'comm_by_username' => $comm_by_name,
																				'comm_by_plan_id' => $userplanid,
																				'comm_by_level' => 6,
																				'trans_reason' => 'commission',  
																				'date_created' => date('Y-m-d H:i:s')
																				); 
																			$user_transaction_id6 = $this->member_model->insert_user_transaction($data_user_trans6);
																			$this->member_model->update_user_transaction($user6['id'], $amt6); 
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

								$data=array('is_paid'=>1);
								$userdata=$this->member_model->update_user($userdata['id'],$data);
								$this->session->set_flashdata("success", "Plan activated successfully.");
								redirect("member/admin/userpayment");
							}
						}else{ 
							$data_user=array('is_paid'=>1); 
							$userdata=$this->member_model->update_user($userdata['id'],$data_user);
							$this->session->set_flashdata("success", "Plan activated successfully.");
							redirect("member/admin/userpayment");
						}

					}else{
						$this->session->set_flashdata("error", "Invalid plan.");
						redirect("member/admin/userpayment");
					}
				
				}else{

					$plandata = $this->member_model->get_plan_by_id($userplandata['plan_id']); 
					if(isset($plandata['days']) && $plandata['days'] > 0)
					{
						$days = $plandata['days'];
						$todaydate = date('Y-m-d');
						$enddate = date('Y-m-d', strtotime($todaydate. ' + '.$days.' days')); 
						$data_plan=array('is_confirmed'=>1,'plan_activation_date'=>$todaydate, 'plan_end_date'=>$enddate);
						$user_plandata=$this->member_model->user_plan_data($userplanid,$data_plan);

						$this->session->set_flashdata("success", "Plan activated successfully.");
						redirect("member/admin/userpayment");
					}else{
						$this->session->set_flashdata("error", "Plan is not valid.");
						redirect("member/admin/userpayment");
					}
					
				}
			}else{
				$this->session->set_flashdata("error", "User does not exist.");
				redirect("member/admin/userpayment");
			}

		}else{
			$this->session->set_flashdata("error", "User plan data does not exist.");
			redirect("member/admin/userpayment");
		}
   }
 function confirmed($paymentid)
   {
   
			if ($paymentid > 0)
             {
				$userdata=$this->member_model->get_userpayment_by_id($paymentid);
				if(isset($userdata['is_confirmed']) && ($userdata['is_confirmed'] ==0)){
				      $userid=$userdata['user_id'];
					  $data=array('is_paid'=>1,'user_plan'=>$userdata['plan_id']);
					  $userdata=$this->member_model->update_user($userdata['user_id'],$data);
					  //update usertable
					  $data=array('is_confirmed'=>1,'plan_activation_date'=>@date('Y-m-d'));
					  $userdata=$this->member_model->user_plan_data($paymentid,$data);
				
				}else{
				     $userid=$userdata['user_id'];
					  $data=array('is_paid'=>0,'user_plan'=>0);
					  $userdata=$this->member_model->update_user($userdata['user_id'],$data);
					  //update usertable
					  $data=array('is_confirmed'=>0,'plan_activation_date'=>'0000-00-00');
					  $userdata=$this->member_model->user_plan_data($paymentid,$data);
					  
				
				}	
				$this->session->set_flashdata("success", "User payment data updated successfully.");
			    redirect("member/admin/userpayment");
				
			}else{
				$this->session->set_flashdata("error", "User payment data does not exist.");
				redirect("member/admin/userpayment");
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
				$this->session->set_flashdata("success", "User updated successfully");
				redirect("member/admin/listall");

			}
			else
			{
				$this->session->set_flashdata("error", "User does not exist.");
				redirect("member/admin/listall");
			}
		}

		

		function delete($username = null, $confirm = 0)

		{

			$this->user->check_level('member', LEVEL_DEL);
			if (is_null($username))
			{
				$this->session->set_flashdata("error", "Username and status required");
				redirect("member/admin/listall");
			}

			if ($username == $this->session->userdata("username"))
			{
				$this->session->set_flashdata("error", "You cannot remove yourself");
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
				$this->session->set_flashdata("success", "User deleted");
				redirect("member/admin/listall");
			}

		}

		

		function status($user_id = null, $fromstatus = null)

		{

			if (is_null($user_id) || is_null($fromstatus))

			{

				$this->session->set_flashdata("error", "User Id and status required");

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

			$this->session->set_flashdata("error", __("User status updated", $this->template['module']));

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

								$this->session->set_flashdata('error', "We already have this brand in our database.");

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

										$this->session->set_flashdata('success', "Brand added successfully !");

										redirect('member/admin/brandlist');

							}else{

								$this->session->set_flashdata('error', "Please upload logo image of the correct file type.");

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

									$this->session->set_flashdata('error', "Please upload logo image of the correct file type.");

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

							$this->session->set_flashdata('success', "Brand updated successfully !");

							redirect('member/admin/brandlist');



				}

			



		}else{

			$this->session->set_flashdata("error", "This brand doesn't exist");

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

				 

				$this->session->set_flashdata("success", "Brand deleted");

				redirect('member/admin/brandlist');

			}

			else

			{

				$this->session->set_flashdata("error","Brand does not exist.");

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
				return FALSE;
			}
		}	

	}

?>