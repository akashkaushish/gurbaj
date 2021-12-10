<?php     if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rest extends MX_Controller {
	var $template = array();
	function __construct()
	{
		parent::__construct();
		$this->template['module']	= 'rest';
		$this->load->model('rest_model');
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
	function todate()
	{
		echo $today = date('Y-m-d h:i:s A');
	}
	
	function payreward()
	{
		
		//$today = '2020-11-30'; 
		
		echo $today = date('Y-m-d'); exit;
		$member_more_6k = $this->rest_model->get_member_6k_business(); //echo "<pre>"; print_r($member_more_6k); exit;
		for($i=0;$i<count($member_more_6k);$i++)
		{
			$user_id = $member_more_6k[$i]['user_id'];
			//if($user_id == 33){
			$user_total = $this->rest_model->get_user_total_business($user_id);
			
			$downline = $this->rest_model->get_level_one_downline($user_id); //echo "<pre>"; print_r($downline); exit;
			
			if(count($downline) > 1)
			{	
				$reward_paid = $this->rest_model->get_last_reward_paid($user_id); 
				if(count($reward_paid) > 0){ $step = $reward_paid[0]['step']+1;  }else{ $step=1; }  
				if($step < 8) //As max value of reward is 7
				{
					$step_paid_id = $this->rest_model->get_step_paid_status($user_id, $step);
					if($step_paid_id == 0)
					{
						$reward = $this->rest_model->get_reward_by_step($step);
						if(count($reward) > 0)
						{
							$business_limit = $reward[0]['business'];  
							$reward = $reward[0]['reward'];
							//$reward_step = $reward[0]['step'];
							if($user_total >= $business_limit)
							{

								$rest_member_amount = 0;
								for($j=0;$j<count($downline); $j++)
								{
									if($j > 0 ) //&& $downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0
									{	
										if($downline[$j]['price'] > 0){
											$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
										}else{
											$rest_member_amount = $rest_member_amount + $downline[$j]['tot'];
										}
									}
								}
								$val = $business_limit; 
								$sixty_percent = $val*60/100;  
								$forty_percent = $val*40/100;
								if($downline[0]['price'] > 0)
								{
									$left_business = $downline[0]['tot'] + $downline[0]['price'];
								}else{
									$left_business = $downline[0]['tot'];
								}
								//echo $left_business."==".$rest_member_amount; exit;
								if( $left_business >= $sixty_percent && $rest_member_amount >= $forty_percent)
								{
									$first_chain_business = $downline[0]['tot'];
									$first_chain_user_id = $downline[0]['id'];
									$data=array(
										'user_id' => $user_id,
										'amount ' => $reward,
										'first_chain_business ' => $left_business,
										'rest_chain_business ' => $rest_member_amount,
										'first_chain_user_id ' => $first_chain_user_id,
										'step' => $step,
										'date' => date('Y-m-d'),
										'is_confirmed' => 1
									); 
									
									$reward_id = $this->rest_model->insert_reward($data); 
									if($reward_id > 0)
									{
										$data_trans =array(
													'user_id' => $user_id,
													'trans_type' => 'credit',
													'amount ' => $reward,
													'trans_reason' => 'reward',
													'date_created' => date('Y-m-d')
												); 
										$trans_id = $this->rest_model->insert_transaction($data_trans); 

										if($trans_id > 0)
										{
											$this->rest_model->update_user_wallet($user_id, $reward);  

											echo $user_id."==<br/>";
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

	function payreward_1()
	{
		
		//$today = date('Y-m-d'); 
		$today = '2021-05-31';
		$member_more_6k = $this->rest_model->get_member_6k_business();  //echo "<pre>"; print_r($member_more_6k); exit;
		
		//echo "i am here"; exit;
		for($i=0;$i<count($member_more_6k);$i++)
		{
			$user_id = $member_more_6k[$i]['user_id'];
			//if($user_id == 113){
			$user_total = $this->rest_model->get_user_total_business($user_id);
			
			$downline = $this->rest_model->get_level_one_downline($user_id); //echo "<pre>"; print_r($downline); exit;
			
			if(count($downline) > 1)
			{	
				$reward_paid = $this->rest_model->get_last_reward_paid($user_id); 
				if(count($reward_paid) > 0){ $step = $reward_paid[0]['step']+1;  }else{ $step=1; }  
				if($step < 8) //As max value of reward is 7
				{ 
					$step_paid_id = $this->rest_model->get_step_paid_status($user_id, $step);
					if($step_paid_id == 0)
					{
						$reward = $this->rest_model->get_reward_by_step($step);
						if(count($reward) > 0)
						{ 
							$business_limit = $reward[0]['business'];  
							$reward = $reward[0]['reward'];
							//$reward_step = $reward[0]['step'];
							if($user_total >= $business_limit)
							{

								$rest_member_amount = 0;
								for($j=0;$j<count($downline); $j++)
								{
									if($j > 0 ) //&& $downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0
									{	
										if($downline[$j]['price'] > 0){
											$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
										}else{
											$rest_member_amount = $rest_member_amount + $downline[$j]['tot'];
										}
									}
								}
								$val = $business_limit; 
								$sixty_percent = $val*60/100;  
								$forty_percent = $val*40/100;
								if($downline[0]['price'] > 0)
								{
									$left_business = $downline[0]['tot'] + $downline[0]['price'];
								}else{
									$left_business = $downline[0]['tot'];
								}
								//echo $left_business."==".$rest_member_amount; exit;
								//if( $left_business >= $sixty_percent && $rest_member_amount >= $forty_percent)
								if( ($left_business >= $sixty_percent && $rest_member_amount >= $forty_percent) || ($rest_member_amount >= $sixty_percent && $left_business >= $forty_percent))
								{ 
									$first_chain_business = $downline[0]['tot'];
									$first_chain_user_id = $downline[0]['id'];

									//echo $user_id."==".$step."<br/>"; 
									$data=array(
										'user_id' => $user_id,
										'amount ' => $reward,
										'first_chain_business ' => $left_business,
										'rest_chain_business ' => $rest_member_amount,
										'first_chain_user_id ' => $first_chain_user_id,
										'step' => $step,
										'date' => date('Y-m-d'),
										'is_confirmed' => 1
									); 
									
									$reward_id = $this->rest_model->insert_reward($data); 
									if($reward_id > 0)
									{ 
										$data_trans =array(
													'user_id' => $user_id,
													'trans_type' => 'credit',
													'amount ' => $reward,
													'trans_reason' => 'reward',
													'date_created' => date('Y-m-d')
												); 
										$trans_id = $this->rest_model->insert_transaction($data_trans); 

										if($trans_id > 0)
										{ 
											$this->rest_model->update_user_wallet($user_id, $reward);  

											echo $user_id."==<br/>";
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

	function nextroyalty()
	{
		
		//echo $today = date('Y-m-d'); exit; 
		// $today = '2020-11-30'; 
		$get_last_royalty = $this->rest_model->get_last_royalty_paid();
		for($i=0;$i<count($get_last_royalty);$i++)
		{
			$step = $get_last_royalty[$i]['step']+1;
			$last_step = $get_last_royalty[$i]['step'];
			$user_id = $get_last_royalty[$i]['user_id'];
			$total_business = $get_last_royalty[$i]['total_business']+7000; 
			$first_level = $get_last_royalty[$i]['first_level']+1;

			$user_total = $this->rest_model->get_user_total_business($user_id);
			if($user_total >= $total_business)
			{
				$downline = $this->rest_model->get_level_one_downline($user_id);
				if(count($downline) >= $first_level)
				{
					$rest_member_amount = 0;
					for($j=0;$j<count($downline); $j++)
					{
						if($j > 0 ) //&& $downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0
						{
							if($downline[$j]['price'] > 0)
							{
								$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
							}else{
								$rest_member_amount = $rest_member_amount + $downline[$j]['tot'];
							}
						}
					}
					$val = 50000+$last_step*7000; 
					$sixty_percent = $val*60/100;  
					$forty_percent = $val*40/100;  
					if($downline[0]['price'] > 0)
					{
						$left_business = $downline[0]['tot'] + $downline[0]['price'];
					}else{
						$left_business = $downline[0]['tot'];
					}
					if($left_business >= $sixty_percent && $rest_member_amount >= $forty_percent)
					{
						$max_step_paid = $this->rest_model->get_max_step_paid($user_id); 
						if($max_step_paid < $step)
						{
							$first_chain_business = $downline[0]['tot'];
							$first_chain_user_id = $downline[0]['id'];
							$data=array(
								'user_id' => $user_id,
								'total_business ' => $user_total,
								'first_level' => count($downline), 
								'first_chain_business ' => $left_business,
								'rest_chain_business ' => $rest_member_amount,
								'first_chain_user_id ' => $first_chain_user_id,
								'step' => $step,
								'date' => date('Y-m-d'),
								'status' => 0
							); 
							echo $royalty_id = $this->rest_model->insert_royalty($data); echo "<br/>";
						}

					}	
				}
			}


		}
	} 
	function firstroyalty()
	{
		//echo $today = date('Y-m-d'); exit;
		$today = '2021-05-31';  
		
		$taken_member=array();
		$first_royalty_paid_members = $this->rest_model->get_first_royalty_paid();
		if(count($first_royalty_paid_members) > 0)
		{
			for($i=0;$i<count($first_royalty_paid_members);$i++)
			{
				array_push($taken_member,$first_royalty_paid_members[$i]['user_id']);
			} 
		}  
		$member_50_business = $this->rest_model->get_member_50_business(); //echo "<pre>"; print_r($member_50_business); exit;
		if(count($member_50_business) > 0)
		{
			for($i=0;$i<count($member_50_business);$i++)
			{
				if(!in_array($member_50_business[$i]['user_id'], $taken_member)) //Putting && condition here
				{
					
					$downline = $this->rest_model->get_level_one_downline($member_50_business[$i]['user_id']); //echo "<pre>"; print_r($downline); exit;
					
					if(count($downline) > 1)
					{
						$rest_member_amount = 0;
						for($j=0;$j<count($downline); $j++)
						{
							if($j > 0) //&& $downline[$j]['tot'] != NULL && $downline[$j]['tot'] > 0
							{
								if($downline[$j]['price'] > 0)
								{
									$rest_member_amount = $rest_member_amount + $downline[$j]['tot'] + $downline[$j]['price'];
								}else{
									$rest_member_amount = $rest_member_amount + $downline[$j]['tot'];
								}
							}
						}
						$user_total = $this->rest_model->get_user_total_business($member_50_business[$i]['user_id']); 
						if($user_total > 50000)
						{
							//$sixty_percent = $user_total*60/100;
							$sixty_percent = 50000*60/100;
							$forty_percent = 50000*40/100;
							if($downline[0]['price'] > 0)
							{
								$left_business = $downline[0]['tot'] + $downline[0]['price'];
							}else{
								$left_business = $downline[0]['tot'];
							} 
							//if($left_business >= $sixty_percent && $rest_member_amount >= $forty_percent)
							if( ($left_business >= $sixty_percent && $rest_member_amount >= $forty_percent) || ($rest_member_amount >= $sixty_percent && $left_business >= $forty_percent))
							{
								$first_chain_business = $downline[0]['tot'];
								$first_chain_user_id = $downline[0]['id'];
								$data=array(
									'user_id' => $member_50_business[$i]['user_id'],
									'total_business ' => $user_total,
									'first_level' => count($downline), 
									'first_chain_business ' => $left_business,
									'rest_chain_business ' => $rest_member_amount,
									'first_chain_user_id ' => $first_chain_user_id,
									'step' => 1,
									'date' => date('Y-m-d'),
									'status' => 0
								); 
								echo $royalty_id = $this->rest_model->insert_royalty($data); echo "<br/>"; 
							}
						}
					} 
					
				}
			}
		}
	}

	function paypayout()
	{
		$today = '2021-05-31'; 
		
		//echo $today = date('Y-m-d');  exit;
		
		$upcoming_payout = $this->rest_model->get_today_upcoming_payout($today);
		//echo "<pre>"; print_r($upcoming_payout); exit;  
		if(count($upcoming_payout) > 0)
		{
			for($i=0;$i<count($upcoming_payout); $i++)
			{
				if($upcoming_payout[$i]['pay_amount'] > 0)
				{
					$data_trans =array(
						'user_id' => $upcoming_payout[$i]['user_id'],
						'trans_type' => 'credit',
						'amount ' => $upcoming_payout[$i]['pay_amount'], 
						'trans_reason' => 'payout', 
						'payout_plan_id' => $upcoming_payout[$i]['plan_id'],
						'date_created' => date('Y-m-d')
					); 
					
					$trans_id = $this->rest_model->insert_transaction($data_trans); 

					if($trans_id > 0)
					{
						$this->rest_model->update_user_wallet($upcoming_payout[$i]['user_id'], $upcoming_payout[$i]['pay_amount']); 
						$this->rest_model->update_upcoming_payout($upcoming_payout[$i]['id']); 
						echo "Success, payoutID=".$upcoming_payout[$i]['id']."UserID=".$upcoming_payout[$i]['user_id']."<br/>";
					}

				}

			}
		}
	}

	function paycommission()
	{
				
		//$today = date('Y-m-d'); 
		$today = '2021-05-31'; 
		
		$upcoming_payout = $this->rest_model->get_today_upcoming_commission($today);
		//echo "<pre>"; print_r($upcoming_payout); exit;  
		if(count($upcoming_payout) > 0)
		{
			for($i=0;$i<count($upcoming_payout); $i++)
			{

				$data_trans =array(
					'user_id' => $upcoming_payout[$i]['user_id'],
					'trans_type' => 'credit',
					'amount ' => $upcoming_payout[$i]['commission_amount'], 
					'trans_reason' => 'commission', 
					'comm_by_user_id' => $upcoming_payout[$i]['comm_by_user_id'],
					'comm_by_username' => $upcoming_payout[$i]['comm_by_username'],
					'comm_by_plan_id' => $upcoming_payout[$i]['comm_by_plan_id'],
					'date_created' => $today
				); 
				
				$trans_id = $this->rest_model->insert_transaction($data_trans); 

				if($trans_id > 0)
				{
					$this->rest_model->update_user_wallet($upcoming_payout[$i]['user_id'], $upcoming_payout[$i]['commission_amount']); 
					$this->rest_model->update_upcoming_commission($upcoming_payout[$i]['id']); 
					echo "Success, comID=".$upcoming_payout[$i]['id']."UserID=".$upcoming_payout[$i]['user_id']."<br/>";
				}

			}
		}
	}
	/* 
	function set_levels()
	{
		$users = $this->rest_model->get_less_level_users();
		for($i=0;$i<count($users);$i++)
		{
			if($users[$i]['level_bonus'] < 7)
			{
				$user_id =  $users[$i]['id']; 
				$user_plan =  $users[$i]['user_plan']; 
				$user_level = $users[$i]['level_bonus'];
				if($user_id > 0)
				{
					if($user_plan > 0)
					{
						$plan_details = $this->rest_model->get_plan_by_id($user_plan);
						$user_down_level_sum = $this->rest_model->user_down_level_one($user_id);
						$self_plan_price = @$plan_details[0]['price'];
						$total =  @$plan_details[0]['price'] + $user_down_level_sum; 
						$total_without_id = $total - 100;
						$level_open = $total_without_id/100;
						
						if($level_open > 7)
						{
							$level_open = 7;
						}
						//echo "userID=".$user_id.", Level=".$level_open.", Downline Sum = ".$user_down_level_sum.", Self PLan Price= ".$self_plan_price."<br/>";
						
						$data =array(
							'level_bonus' => $level_open
						);
						$this->rest_model->update_user($user_id, $data);
						echo "userID=".$user_id."<br/>";
					}
				}
			}
		}

	} */


}