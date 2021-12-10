<?php   
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rest_model extends CI_Model 
{

	var $rest_total;
    function __construct()
    {
        parent::__construct();
		//$this->member_total = $this->get_total();
    }
	
	
	function get_first_royalty_paid()
	{
		$sql = "SELECT user_id FROM ci_royalty_payment where step=1"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array(); 
		
	}
	function get_last_royalty_paid()
	{
		$sql = "SELECT * FROM ci_royalty_payment ORDER BY step DESC "; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array(); 
	}
	function get_last_reward_paid($user_id)
	{
		$sql = "SELECT * FROM ci_extra_payment WHERE user_id='".$user_id."' ORDER BY id DESC LIMIT 1"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array(); 
	}
	function get_reward_by_step($step)
	{
		$sql = "SELECT * FROM ci_rewards WHERE step='".$step."' AND is_active=1"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array(); 
	}
	function get_max_step_paid($user_id)
	{
		$sql = "SELECT MAX(step) AS maxstep FROM ci_royalty_payment WHERE user_id=".$user_id; 
		$query = $this->db->query($sql); 
		$result = $query->result_array(); 
		if(isset($result[0]['maxstep'])){ return $result[0]['maxstep']; }else{ return 0; }
	}
	function get_member_6k_business()
	{
		$sql = "SELECT user_id, SUM(amount) AS tb FROM ci_user_business GROUP BY user_id HAVING SUM(amount) >= 6000"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array();
	}
	

	function get_member_50_business()
	{
		$sql = "SELECT user_id, SUM(amount) AS tb FROM ci_user_business GROUP BY user_id HAVING SUM(amount) >= 50000"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array();
	}

	function get_level_one_downline($user_id)
	{
		$sql = "SELECT ci_users.*, SUM(ci_user_business.amount) AS tot, ci_plans.price
		FROM ci_users 
		LEFT JOIN ci_user_business ON ci_user_business.user_id = ci_users.id
		LEFT JOIN ci_plans ON ci_users.user_plan = ci_plans.id
		WHERE ci_users.ref_id='".$user_id."' AND ci_users.is_paid=1 GROUP BY ci_users.id ORDER BY tot DESC"; 
		$query = $this->db->query($sql);
		return $result = $query->result_array();
	}

	function get_user_total_business($userid)
	{
		$sql = "SELECT SUM(amount) as total FROM ci_users, ci_user_business WHERE ci_user_business.user_id = ci_users.id AND ci_user_business.user_id = '".$userid."' AND ci_user_business.is_confirmed=1 AND ci_users.is_paid=1"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['total']) && $result[0]['total'] > 0)
		{
			return $total = @$result[0]['total'];
		}else{
			return 0;
		}
	}
	function get_step_paid_status($userid, $step)
	{
		$sql = "SELECT id FROM ci_extra_payment WHERE user_id='".$userid."' AND step = '".$step."'"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(isset($result[0]['id']) && $result[0]['id'] > 0)
		{
			return $id = @$result[0]['id'];
		}else{
			return 0;
		}
	}

    function insert_royalty($data)
	{
		$this->db->insert('royalty_payment', $data);
		$id = $this->db->insert_id();
		return $id;	
	}

	function insert_reward($data)
	{
		$this->db->insert('extra_payment', $data); 
		$id = $this->db->insert_id();
		return $id;	
	}

	function insert_transaction($data)
	{
		$this->db->insert('user_transactions', $data);
		$id = $this->db->insert_id();
		return $id;	
	}

	function update_user_wallet($id, $amount)
	{
		$sql="UPDATE ci_users SET wallet_total = wallet_total+".$amount." WHERE id =".$id;
		$query = $this->db->query($sql);
		return true;
		
	}
	function update_upcoming_payout($id)
	{
		$sql="UPDATE ci_upcoming_payout SET status = 1 WHERE id =".$id;
		$query = $this->db->query($sql);
		return true;
		
	}
	function update_upcoming_commission($id)
	{
		$today = date('Y-m-d');
		$sql="UPDATE ci_level_bonus_transactions SET is_paid = 1, paid_date='".$today."' WHERE id =".$id;
		$query = $this->db->query($sql);
		return true;
		
	}

	function get_today_upcoming_payout($date)
	{
		$sql = "SELECT * FROM ci_upcoming_payout WHERE pay_date='".$date."' AND status=0"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array();
	}

	function get_today_upcoming_commission($date)
	{
		$sql = "SELECT * FROM ci_level_bonus_transactions WHERE commission_month='".$date."' AND is_paid=0"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array();
	}
	/*
	function get_less_level_users()
	{
		$sql = "SELECT * FROM ci_users WHERE level_bonus < 8 AND is_paid=1"; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array();
	}

	function get_plan_by_id($id)
	{
		$sql = "SELECT id, plan_name, price FROM ci_plans WHERE id=".$id; 
		$query = $this->db->query($sql); 
		return $result = $query->result_array();
	}
	function user_down_level_one($user_id)
	{
		//$sql = "SELECT * FROM ci_users WHERE ref_id ='".$user_id."' AND is_paid=1"; 
		//$sql="SELECT ci_users.*, ci_user_plan_details.payment_amount, ci_user_plan_details.plan_id 
		//FROM  ci_users, ci_user_plan_details WHERE ci_user_plan_details.user_id = ci_users.id AND ci_users.ref_id=".$user_id;
		$sql="SELECT SUM(ci_user_plan_details.payment_amount) as cnt
		FROM  ci_users, ci_user_plan_details WHERE ci_user_plan_details.user_id = ci_users.id AND ci_user_plan_details.is_confirmed=1 AND ci_users.ref_id=".$user_id;
		$query = $this->db->query($sql); 
		$result = $query->result_array();
		if(isset($result[0]['cnt']) && $result[0]['cnt'] > 0)
		{
			return $cnt = @$result[0]['cnt'];
		}else{
			return 0;
		}
	}
	function update_user($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	} */
	

}