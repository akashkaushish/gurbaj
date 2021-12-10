<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*


 * $Id$


 *


 *


 */


  





class Admin_model extends CI_Model {





	var $fields = array();


	


	function __construct()

	{


		parent::__construct();
	}

	function get_total_invested()
	{
		$sql = "SELECT sum(payment_amount) as totalinvest FROM ci_user_plan_details WHERE is_confirmed=1"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$totalinvested = @$result[0]['totalinvest'];
		if($totalinvested > 0){ return $totalinvested; }else{ return 0; }
	}
	function get_total_plans()
	{
		$sql = "SELECT count(id) as totalplan FROM ci_user_plan_details WHERE is_confirmed=1"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $totalinvested = @$result[0]['totalplan'];
	}
	function get_total_withdrawn()
	{
		$sql = "SELECT sum(amount) as totalwithdrawn FROM ci_user_transactions WHERE trans_type='debit' AND trans_reason='waithdraw'"; 
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$totalwithdrawn = @$result[0]['totalwithdrawn'];
		if($totalwithdrawn > 0){ return $totalwithdrawn; }else{ return 0; }
	}


	function get($params = array())
	{
		$default_params = array
		(
			'order_by' => 'id DESC',
			'limit' => 1,
			'start' => null,
			'where' => null,
			'like' => null,
		);


		


		foreach ($default_params as $key => $value)


		{


			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];


		}


		$hash = md5(serialize($params));


		if(!$result = $this->cache->get('get' . $hash, 'groups'))


		{


			if (!is_null($params['like']))


			{


				$this->db->like($params['like']);


			}


			if (!is_null($params['where']))


			{


				$this->db->where($params['where']);


			}


			//$this->db->where('g_id');


			$this->db->order_by($params['order_by']);


			$this->db->from('groups');


			$this->db->limit(1);


			$this->db->group_by('groups.id');


			$query = $this->db->get();





			if ($query->num_rows() == 0 )


			{


				$result =  false;


			}


			else


			{


				$result = $query->row_array();


			}


			


			$this->cache->save('get' . $hash, $result, 'groups', 0);


		}


		


		return $result;


		


		


	}


	


	


	


		


	function getTotalUsers()	{


		


		echo $sql = "SELECT COUNT(id) as nb FROM `ci_users` WHERE status='active'";


		$query = $this->db->query($sql);


		$data= $query->result_array();


		


		if(isset($data[0]['nb'])&& ($data[0]['nb'] !='')){


		return $data[0]['nb'];


		}else{


		return '0';


		}





		





	}


	


	


	function get_list($params = array())


	{


		$this->cache->remove_group('groups');


		$default_params = array


		(


			'order_by' => 'id DESC',


			'limit' => null,


			'start' => null,


			'where' => null,


			'like' => null,


		);


		


		foreach ($default_params as $key => $value)


		{


			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];


		}


		$hash = md5(serialize($params));


		if(!$result = $this->cache->get('get_list' . $hash, 'groups'))


		{


			if (!is_null($params['like']))


			{


				$this->db->like($params['like']);


			}


			if (!is_null($params['where']))


			{


				$this->db->where($params['where']);


			}


			$this->db->order_by($params['order_by']);


			$this->db->select('groups.* , count(g_user) as cnt');


			$this->db->from('groups');


			$this->db->join('group_members', 'groups.g_id=group_members.g_id', 'left');


			$this->db->limit($params['limit'], $params['start']);


			$this->db->group_by('groups.id');


			$query = $this->db->get();


			if ($query->num_rows() == 0 )


			{


				$result =  false;


			}


			else


			{


				$result = $query->result_array();


			}


			


			$this->cache->save('get_list' . $hash, $result, 'groups', 0);


		}


		


		return $result;


		


		


	}


	


	function get_total($params = array())


	{


		$default_params = array


		(


			'order_by' => 'id DESC',


			'limit' => null,


			'start' => null,


			'where' => null,


			'like' => null,


		);


		


		foreach ($default_params as $key => $value)


		{


			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];


		}


		$hash = md5(serialize($params));


		if(!$result = $this->cache->get('get_total' . $hash, 'groups'))


		{


			if (!is_null($params['like']))


			{


				$this->db->like($params['like']);


			}


			if (!is_null($params['where']))


			{


				$this->db->where($params['where']);


			}


			$this->db->order_by($params['order_by']);





			$this->db->select('count(id) as cnt');


			$this->db->from('groups');


			


			$query = $this->db->get();





			$row = $query->row_array();


			


			$result = $row['cnt'];


			


			$this->cache->save('get_total' . $hash, $result, 'groups', 0);


		}


		


		return $result;


		


	}


	


	function delete($params = array())


	{


		$this->db->where($params['where']);


		$this->db->delete('groups');


		$this->cache->remove_group('groups');


	}


	


	function save($data = array())


	{


		$data['g_id'] = uniqid('g');


		$this->db->set($data);


		$this->db->insert('groups');


		$this->cache->remove_group('groups');


	}


	


	function update($where = array(), $data = array())


	{


		$this->db->where($where);


		$this->db->set($data);


		$this->db->update('groups');


		$this->cache->remove_group('groups');


	}


	


	function get_group($id)


	{


		return $this->get(array('where' =>  array('id' => $id)));


	}


	


	function delete_group($id)


	{


		$this->delete(array('id' => $id));


	}


	


	function update_group($id, $data)


	{


		$this->update(array('id' => $id), $data);


	}	





	function get_params($id)


	{


		if($params = $this->cache->get($id, 'group_search_cache'))


		{


			return $params;


		}


		else


		{


			return false;


		}


	}





	function save_params($params)


	{


		$id = md5($params);


		if($this->cache->get($id, 'group_search_cache'))


		{


			return $id;


		}


		else


		{


		


			$this->cache->save($id, $params, 'group_search_cache', 0);


			return $id;


		}


	}





	function get_members($params = array())


	{


		$this->cache->remove_group('groups');


		$default_params = array


		(


			'order_by' => 'id DESC',


			'limit' => null,


			'start' => null,


			'where' => null,


			'like' => null,


		);


		


		foreach ($default_params as $key => $value)


		{


			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];


		}


		$hash = md5(serialize($params));


		if(!$result = $this->cache->get('get_members' . $hash, 'groups'))


		{


			$result = $this->get(array('where' => array('groups.g_id' => $params['where']['g_id'])));


			if (!is_null($params['like']))


			{


				$this->db->like($params['like']);


			}


			if (!is_null($params['where']))


			{


				$this->db->where($params['where']);


			}


			$this->db->order_by($params['order_by']);


			$this->db->limit($params['limit'], $params['start']);


			$query = $this->db->get('group_members');


			if ($query->num_rows() == 0 )


			{


				$result['members'] =  false;


			}


			else


			{


				$result['members'] = $query->result_array();


			}


			


			$this->cache->save('get_members' . $hash, $result, 'groups', 0);


		}


		


		return $result;


	}








	function get_total_members($params = array())


	{


		$default_params = array


		(


			'order_by' => 'id DESC',


			'limit' => null,


			'start' => null,


			'where' => null,


			'like' => null,


		);


		


		foreach ($default_params as $key => $value)


		{


			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];


		}


		$hash = md5(serialize($params));


		if(!$result = $this->cache->get('get_total_members' . $hash, 'groups'))


		{


			if (!is_null($params['like']))


			{


				$this->db->like($params['like']);


			}


			if (!is_null($params['where']))


			{


				$this->db->where($params['where']);


			}


			$this->db->order_by($params['order_by']);





			$this->db->select('count(id) as cnt');


			$this->db->from('group_members');


			


			$query = $this->db->get();





			$row = $query->row_array();


			


			$result = $row['cnt'];


			


			$this->cache->save('get_total_members' . $hash, $result, 'groups', 0);


		}


		


		return $result;


		


	}





	function save_member($data = array())


	{


		$this->db->set($data);


		$this->db->insert('group_members');


		$this->cache->remove_group('groups');


	}


	


	function update_member($where = array(), $data = array())


	{


		$this->db->where($where);


		$this->db->set($data);


		$this->db->update('group_members');


		$this->cache->remove_group('groups');


	}





	function delete_member($params = array())


	{


		$this->db->where($params['where']);


		$this->db->delete('group_members');


		$this->cache->remove_group('groups');


	}





	


}


