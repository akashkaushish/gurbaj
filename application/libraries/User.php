<?php

/*

| User Library for CI 2.00

| Note this module depends on

| the config constants.php

| having the following definitions

| added to it:

| define('LEVEL_NONE', 0);

| define('LEVEL_VIEW', 1);

| define('LEVEL_ADD', 2);

| define('LEVEL_EDIT', 3);

| define('LEVEL_DEL', 4);

|

|

*/

	class User {

		var $id = 0;

		var $logged_in = false;

		var $auto_login = false;

		var $lang;

		var $email;

		var $username = '';

		var $table = 'users';

		var $level = array();

		var $groups = array();		

		function __construct()

		{

			$this->obj =& get_instance();

			$this->obj->load->library('encrypt');

			//this filter allows us to use another type of auth (LDAP etc)

			$this->obj->plugin->add_filter('user_auth', array(&$this, '_user_auth'), 30, 2);

			$this->_session_to_library();

			$this->_get_levels();

			$this->_get_groups();

			$this->_update_fields();

		}

		

		function _update_fields()

		{	

			if ($this->logged_in)

			{

				//$this->update($this->username, array('activation' => '', 'lastvisit' => time(), 'online' => 1));

				$this->update($this->username, array('lastvisit' => time()));

			}

		}
		
		

		function _get_groups()

		{

			$this->groups[] = '0';

			if($this->logged_in){

				$this->groups[] = '1';

				$this->obj->db->select('g_id');

				$this->obj->db->where('g_user', $this->username);

				$this->obj->db->where("(g_from <= '" . time() . "' OR g_from=0)");

				$this->obj->db->where("(g_to >= '" . time() . "' OR g_to=0)");

				$query = $this->obj->db->get("group_members");				

				if($rows = $query->result_array()){

					foreach ($rows as $row) {

						$this->groups[] = $row['g_id'];

					}

				}

				//user also is member of his own groups

				$this->obj->db->select('g_id');

				$this->obj->db->where('g_owner', $this->username);

				$query = $this->obj->db->get("groups");

				if($rows = $query->result_array()){

					foreach ($rows as $row) {

						$this->groups[] = $row['g_id'];

					}

				}

			}		

		}

		function _get_levels()

		{

			$admin = array();

			if ($this->logged_in)

			{

				$this->obj->db->where('username', $this->username);

				$query = $this->obj->db->get('admins');

				if ($rows = $query->result_array())

				{

					foreach($rows as $val) {

						$admin[ $val['module'] ] = $val['level'];

					}

				}

			}

			if (is_array($this->obj->system->modules))

			{

				foreach($this->obj->system->modules as $module)

				{	

					if (!isset($admin[ $module['name'] ]))

					{

						$admin[ $module['name'] ] = 0;

					}

				}

			}

			$this->level = $admin;

		}

		

		function check_level($module, $level)

		{

			if ( !isset($this->obj->user->level[$module]) || $this->obj->user->level[$module] < $level)

			{

				if ($this->obj->uri->segment(1) == "admin" || $this->obj->uri->segment(2) == "admin")

				{

					redirect('admin/unauthorized/'. $module . '/' . $level);

					exit;

				}

				else

				{

					redirect('member/unauthorized/'. $module . '/' . $level);

					exit;

				}

			}

		}

		function _prep_password($password)

		{

			// Salt up the hash pipe

			// Encryption key as suffix.

			  

			return sha1($password.$this->obj->config->item('encryption_key'));

			//return $this->obj->encrypt->sha1($password.$this->obj->config->item('encryption_key'));

		}

		

		function prep_password($password)

		{

			// Salt up the hash pipe

			// Encryption key as suffix.

			  return sha1($password.$this->obj->config->item('encryption_key'));

			//return $this->obj->encrypt->sha1($password.$this->obj->config->item('encryption_key'));

		}

		

		function _session_to_library()

		{

			// Pulls session data into the library.

			$this->id 				= $this->obj->session->userdata('id');

			$this->username			= $this->obj->session->userdata('username');

			$this->logged_in 		= $this->obj->session->userdata('logged_in');

			$this->auto_login		= $this->obj->session->userdata('auto_login');

			$this->lang 			= $this->obj->session->userdata('lang');

			$this->email			= $this->obj->session->userdata('email');

		}

		

		function _start_session()

		{

			// $user is an object sent from function login();

			// Let's build an array of data to put in the session.

			$data = array(

						'id' 			=> $this->id,

						'username' 		=> $this->username,

						'email'			=> $this->email, 

						'logged_in'		=> $this->logged_in,

						'auto_login' 	=> $this->auto_login,

						'lang'			=> $this->lang

					);

					

			$this->obj->session->set_userdata($data);

			

		}

		

		function _destroy_session()

		{

			$data = array(

						'id' 			=> 0,

						'username' 		=> '',

						'email' 		=> '',

						'logged_in'		=> false,

						'auto_login' 	=> false

					);					

			$this->obj->session->set_userdata($data);

			foreach ($data as $key => $value)

			{

				$this->$key = $value;

			}

		}

	 

		

		function login($username, $password, $remember=false)

		{

			//destroy previous sesson

			$this->_destroy_session();

			//First check from the table

			$result = array();

			$result['username'] = $username;

			$result['password'] = $password;

			$result = $this->obj->plugin->apply_filters('user_auth', $result);

			if(isset($result['logged_in']) && $result['logged_in'] !== false)

			{

				// We found a user!

				// Let's save some data in their session/cookie/pocket whatever.

				

				$this->id 				= $result['id'];

				$this->username			= $result['username'];

				$this->logged_in 		= true;

				$this->lang 			= $this->obj->session->userdata('lang');

				$this->email			= $result['email'];

				$this->_start_session();

				$this->obj->session->set_flashdata('notification', 'Login successful...');

				//if ever we need to do action on the registered user (as array)

				$this->obj->plugin->do_action('user_logged_in', $result);

				if($remember !== false)

				{

					$this->obj->load->library('user_persistence');

					$this->obj->user_persistence->remember();

				}

				return true;

			}

			else

			{

				$this->_destroy_session();

				if (isset($result['error_message']))

				{

					$this->obj->session->set_flashdata('notification', $result['error_message']);

				}

				else

				{

					$this->obj->session->set_flashdata('notification', 'Login failed...');

				}

				return false;

			}

		}

		

		function logout()

		{

			// If the user is logging out destroy thier persistant data

			$this->obj->load->library('user_persistence');

			$this->obj->user_persistence->forget();

			$last_uri = $this->obj->session->userdata("last_uri");

			$this->_destroy_session();

			$this->obj->session->set_userdata(array('last_uri' => $last_uri));

			$this->obj->session->set_flashdata('notification', 'You are now logged out');

		}

		

		function update($username, $data)

		{

			//encrypt password

			if (isset($data['password']))

			{

				$data['password'] = $this->_prep_password($data['password']);

			}

			$this->obj->db->where('username', $username);

			$this->obj->db->set($data);

			$this->obj->db->update($this->table);

		}

		

		function register($username, $password, $email)

		{

			// $user is an array...

			$data	= 	array(

							'username'	=> $username,

							'password'	=> $this->_prep_password($password),

							'email'		=> $email,

							'status'	=> 'active',

							'registered'=> time()

						);

			$query = $this->obj->db->insert($this->table, $data);

			$this->obj->plugin->do_action('user_registered', $data);

			return $this->obj->db->insert_id();

		}

		function require_login()

		{

			$this->obj->load->library('user_persistence');

			

			if (!$this->logged_in)

			{

				//save _POST and uri

				$data = array(

				"last_post" => $_POST,

				"redirect" => $this->obj->uri->uri_string()

				);

				$this->obj->session->set_userdata($data);

				redirect("member/login");

			}

		}

		

		function get_user($where)

		{

			if (!is_array($where))

			{

				$this->obj->db->where('id', $where);

			}

			elseif(is_array($where))

			{

				foreach($where as $field => $val)

				{

					$this->obj->db->where($field, $val);

				}

			}

			

			$query = $this->obj->db->get('users');

			if ($query->num_rows() > 0 )

			{

				return $query->row_array();

			}

			else

			{

				return false;

			}

		}

		

		function get_users($where)

		{

			if (!is_array($where))

			{

				$where = array('id', $where);

			}

		

			$query = $this->obj->db->get_where('users', $where);

			if ($query->num_rows() > 0 )

			{

				return $query->result_array();

			}

			else

			{

				return false;

			}

		}

		function get_user_number($where = array(), $params = array())

		{

			$this->obj->db->select("COUNT(id) total");

			$this->obj->db->where($where);

			$this->obj->db->from("users");

			$query = $this->obj->db->get();

			if ($query->num_rows() > 0)

			{

				$row = $query->row_array();

				return $row['total'];

			}

			else

			{

				return 0;

			}

		}

		

		function delete_user($where, $limit = 1)

		{

			if (!is_array($where))

			{

				$where = array('id', $where);

			}

			$this->obj->db->where($where);

			$this->obj->db->limit($limit);

			$this->obj->db->delete("users");

		}

		

		function get_user_list($params = array())

		{

			$default_params = array

			(

				'order_by' => 'id',

				'limit' => null,

				'start' => null,

				'where' => null,

				'like' => null,

			);

			foreach ($default_params as $key => $value)

			{

				$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];

			}

			if (!is_null($params['like']))

			{

				$this->obj->db->like($params['like']);

			}

			$this->obj->db->order_by($params['order_by']);

			if (!is_null($params['where']))

			{

				$this->obj->db->where($params['where']);

			}

			$this->obj->db->limit($params['limit'], $params['start']);

		

			$query = $this->obj->db->get('users');

			if ($query->num_rows() > 0 )

			{

				return $query->result_array();

			}

			else

			{

				return false;

			}

		}

		function get_group_list($params = array())

		{

			$default_params = array

			(

				'order_by' => 'id',

				'limit' => null,

				'start' => null,

				'where' => array('g_owner' => $this->username),

				'like' => null,

			);

			

			foreach ($default_params as $key => $value)

			{

				$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];

			}

			if (!is_null($params['like']))

			{

				$this->obj->db->like($params['like']);

			}

			if (!is_null($params['where']))

			{

				$this->obj->db->where($params['where']);

			}

			$this->obj->db->or_where(array('g_id' => '0'));

			$this->obj->db->or_where(array('g_id' => '1'));

			$this->obj->db->order_by($params['order_by']);

			$this->obj->db->limit($params['limit'], $params['start']);

			

			$query = $this->obj->db->get('groups');

			if($query->num_rows() > 0)

			{

				return $query->result_array();

			}

			else

			{

				return false;

			}

			

		}

		

		function is_online($username)

		{

			$this->obj->db->where(array('username' => $username, 'lastvisit >' => time() - 600, 'online' => 1 ));

			$this->obj->db->order_by('lastvisit DESC');

			$query = $this->obj->db->get('users');

			if($query->num_rows() > 0)

			{

				return true;

			}

			else

			{

				return false;

			}

		}

		

		function get_online()

		{

			$this->obj->db->where(array('lastvisit >' => time() - 600, 'online' => 1 ));

			$this->obj->db->order_by('lastvisit DESC');

			$query = $this->obj->db->get('users');

			if($query->num_rows() > 0)

			{

				return $query->result_array();

			}

			else

			{

				return false;

			}

			

		}

		function _user_auth($result)

		{

			// this is the authentication from database

			//used only if no plugin were used before

			if(isset($result['logged_in'])) return $result;

			$result['logged_in'] = false;

			$this->obj->db->where('username', $result['username']);

			$this->obj->db->where('password', $this->_prep_password($result['password']));

			$this->obj->db->where('status', 'active');

			$query = $this->obj->db->get('users', 1);

			if ( $query->num_rows() == 1 )

			{

			$userdata = $query->row_array();

				$result['logged_in'] = true;

				$result['email'] = $userdata['email'];

				$result['id'] = $userdata['id'];

				return $result;

			}

			else

			{

				$result['logged_in'] = false;

				return $result;

			}

		}

		

		

		function remember()

		{

			$this->obj->load->library('user_persistence');	

		}

		

		

		

		function update_user_notify_count($user_id)

		{

			if($user_id > 0)

			{

				$data = array('is_notify_read_count' => 0);

				$this->obj->db->where('receiver_id', $user_id);

				$this->obj->db->update('user_media', $data);

				return true;

			}else{

				return false;

			}

		}

  

		function get_active_group_list()

		{

		    

			$this->obj->db->where(array('is_active' => 1 ));

			$query = $this->obj->db->get('user_group');

			return $result = $query->result_array();

		}

			

			

		function get_total_group_user($groupid)

		{

			if($groupid > 0)

			{

				$this->obj->db->select('count(user_id) as nb');

				$query = $this->obj->db->get_where('user_group_member', array('group_id' => $groupid), 1, 0);

				$row = $query->row();

				$count = $row->nb;

				if($count > 0)

				{

					return $count;  

				}else{

					return 0; 

				}

			}else{

				return 0; 

			}

		}

		 function get_user_list_for_sendmedia()

		{

			$this->obj->db->where(array('status' => 'active'));

			

			$this->obj->db->where('id !=', '1');

			$query = $this->obj->db->get('users');

			return $result = $query->result_array();

		}

		

	

  function getdownlinelist($leadsid, $project_id,$login_user_id)

	{

			$this->obj->db->where(array('id'=>$leadsid));

			$query = $this->obj->db->get('leads');

			$result = $query->result_array();

			$email=$result[0]['email'];

			

			/*get referid of login user*/

			$this->obj->db->where(array('id'=>$login_user_id));

			$query12 = $this->obj->db->get('users');

			$result12 = $query12->result_array();

			$id_number=$result12[0]['id_number'];

			

			/*get downline of login user*/

			$this->obj->db->where(array('email'=>$email,'project_id'=>$project_id,'ref_number'=>$id_number));

			$query22 = $this->obj->db->get('users');

			$result22 = $query22->result_array();

		if ($query22->num_rows() > 0 )

			return 'Yes';

		else

			return 'No';

	}

	

 

		/*function encryptval($string) 

		{

			$key = '3DES';

			$result = '';

			for($i=0; $i<strlen($string); $i++) 

			{

				$char = substr($string, $i, 1);

				$keychar = substr($key, ($i % strlen($key))-1, 1);

				$char = chr(ord($char)+ord($keychar));

				$result.=$char;

			}

			$data = base64_encode($result);

			$data = str_replace(array('+','/','='),array('-','_',''),$data);

			return $data;

		}	

		

	function decryptval($string)

		{

			$data = str_replace(array('-','_'),array('+','/'),$string);

			$mod4 = strlen($data) % 4;

			if ($mod4) {

				$data .= substr('====', $mod4);

			}

	

			$key = '3DES';

			$result = '';

			//$string = base64_decode($string);

			$string = base64_decode($data);

			for($i=0; $i<strlen($string); $i++) 

			{

				$char = substr($string, $i, 1);

				$keychar = substr($key, ($i % strlen($key))-1, 1);

				$char = chr(ord($char)-ord($keychar));

				$result.=$char;

			}

			return $result;

		}*/

		

			/*changed to new code*/

		function encryptval($string) 

		{

			$key = '3DES';

			$result = '';

			for($i=0; $i<strlen($string); $i++) 

			{

				$char = substr($string, $i, 1);

				$keychar = substr($key, ($i % strlen($key))-1, 1);

				$char = chr(ord($char)+ord($keychar));

				$result.=$char;

			}

			$data = base64_encode($result);

			$data = str_replace(array('+','/','='),array('-','_',''),$data);

			return $data;

		}	

		

		function decryptval($string)

		{

			$data = str_replace(array('-','_'),array('+','/'),$string);

			$mod4 = strlen($data) % 4;

			if ($mod4) {

				$data .= substr('====', $mod4);

			}

	

	

			$key = '3DES';

			$result = '';

			//$string = base64_decode($string);

			$string = base64_decode($data);

			for($i=0; $i<strlen($string); $i++) 

			{

				$char = substr($string, $i, 1);

				$keychar = substr($key, ($i % strlen($key))-1, 1);

				$char = chr(ord($char)-ord($keychar));

				$result.=$char;

			}

			return $result;

		}

function hexToRgb($hex, $alpha = false) {

   $hex      = str_replace('#', '', $hex);

   $length   = strlen($hex);

   $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));

   $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));

   $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

   if ( $alpha ) {

      $rgb['a'] = $alpha;

   }

   return $rgb;

}	

	

		

	 function get_user_list_group($group_id)

		{

		   $sql = "SELECT ci_users.*, ci_user_group_member.user_id FROM ci_users, ci_user_group_member  WHERE ci_user_group_member.user_id= ci_users.id AND ci_user_group_member.group_id=".$group_id;

			

			    $query = $this->obj->db->query($sql);

				return $result = $query->result_array();

		}


//9 June

	function totalusers()
       {			   
			     $sql = "SELECT count(id) as id FROM ci_users where id!=1  ";			

			    $query = $this->obj->db->query($sql);

			    $result = $query->result_array();				

				return $result[0]['id'];

			}	
			function get_plan_name($plan_id)
			{			   
				$sql = "SELECT plan_name FROM ci_plans where id=".$plan_id;			
				$query = $this->obj->db->query($sql);
				$result = $query->result_array();
				return @$result[0]['plan_name'];
	 
			}	
			function get_id_by_userid($user_id)
			{			   
				$sql = "SELECT my_ref_code FROM ci_users where id=".$user_id;			
				$query = $this->obj->db->query($sql);
				$result = $query->result_array();
				return @$result[0]['my_ref_code'];
	 
			}	
			
  function get_registeruser()
             {			   
			     echo $sql = "SELECT COUNT(id) AS  totaldata, created_date FROM  `ci_users` GROUP BY YEAR(created_date)";		
			     $query = $this->obj->db->query($sql);
			     $result = $query->result_array();				
				 return @$result[0]['totaldata'];
			}

function get_leastyear()
             {			   
			     $sql = "SELECT created_date AS  'date' FROM  `ci_users` GROUP BY created_date ORDER BY created_date ASC LIMIT 1";		
			     $query = $this->obj->db->query($sql);
			     $result = $query->result_array();				
				if(isset($result[0]['date']) && ($result[0]['date'] > 0)){
				   return $result[0]['date'];
				}else{
				   return "0";
				
				}	
			 }	
			 
			 		
function getblabtagimage($blabeey_tag_logo,$blavtarid, $color){ 

	if(isset($color) && ($color !='')){		
		   $colorinrgb=$this->hexToRgb($color);
		   $r=$colorinrgb['r'];
		   $g=$colorinrgb['g'];
		   $b=$colorinrgb['b'];
		}	

			  $targetPath=ABSPATH.'/script/'.$blabeey_tag_logo;
			  $image_name=$blabeey_tag_logo;
			/*Create Blab image*/
		/*	    list($width_x, $height_x) = getimagesize('/var/www/html/blabeey/htdocs/gmail/blab-icon.png');
                list($width_y, $height_y) = getimagesize($targetPath);
		            $data = getimagesize('/var/www/html/blabeey/htdocs/gmail/blab-icon.png');
	                $width = $data[0];
					$height = $data[1];						
					$dest= imagecreatefrompng('/var/www/html/blabeey/htdocs/gmail/blab-icon.png');							 
					$src  = imagecreatefrompng($targetPath);
					imagealphablending($dest, false);
					imagesavealpha($dest, true);					
					imagecopymerge($dest, $src, (($width_x/2)-($width_y/2)), (($height_x/2)-($height_y/2)), 0, 0, $width_y, $height_y, 100);				
					//header('Content-Type: image/png');
					//imagepng($dest);
					if(imagepng($dest,'/var/www/html/blabeey/htdocs/media/images/thumb/customimage/'.$image_name )){
					     $logo=$dest; 
						imagedestroy($dest);
						imagedestroy($src);	
					}*/
				
		  /*logo after tag*/	
	    	         $logoaftertag=$targetPath ;
					 $viewdata = $blavtarid;	
					 $id_without_enc=$blavtarid;	
					 $blavtardata=$blavtarid;
					
					
					
					if(!empty($viewdata))						
					{	
					
					
							$URLdata12=$viewdata;
							$sendurl=$blavtarid;
					        $_REQUEST['data']= $URLdata12;
							//$urldata=$this->dynamiclink($URLdata12);
							/*qrcode data*/
							$PNG_TEMP_DIR=ABSPATH.'/script/phpqrcode/temp/';
							//html PNG location prefix	
					
							include ABSPATH."/script/phpqrcode/qrlib.php";  
							     
							//ofcourse we need rights to create temp dir
							if (!file_exists($PNG_TEMP_DIR))
								mkdir($PNG_TEMP_DIR);
								$filename = $PNG_TEMP_DIR.'test.png';
								$errorCorrectionLevel = 'H';
								$matrixPointSize = 16;
					 
								
								// user data
								  $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
							      $filenamealreadt = ABSPATH.'/script/phpqrcode/temp/'.$filename;
								  if (file_exists($filenamealreadt)) { unlink($filenamealreadt);}
							     QRcode::png( $sendurl, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    	
								 $logo = isset($logoaftertag) ? $logoaftertag : 'https://bitfx-co.com/application/views/themes/bitfx/assets/img/logo.png';
								 $power = '';
								
						
								// === Adding image to qrcode 								
								$QR = imagecreatefrompng($filename);
								if($logo !== FALSE){
								 
								if(isset($ext) && ($ext =='jpg' || $ext =='jepg')){
								   $logopng = imagecreatefromjpeg($logo);
								}else{
								   $logopng = imagecreatefrompng($logo);
								}	
														 
								
								$QR_width = imagesx($QR);
								$QR_height = imagesy($QR);
								$logo_width = imagesx($logopng);
								$logo_height = imagesy($logopng);
								
								list($newwidth, $newheight) = getimagesize($logo);
								$out = imagecreatetruecolor($QR_width, $QR_width);
								imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
								//imagecopyresampled($out, $logopng, $QR_width/2.65, $QR_height/2.65, 0, 0, $QR_width/4, $QR_height/4, $newwidth, $newheight);
								
								}
								imagepng($out,$filename);
								imagedestroy($out);
									
								// === Change image color
								$im = imagecreatefrompng($filename);
								//$r = 44;$g = 62;$b = 80;
								for($x=0;$x<imagesx($im);++$x){
								for($y=0;$y<imagesy($im);++$y){
								$index 	= imagecolorat($im, $x, $y);
								$c   	= imagecolorsforindex($im, $index);
							
								if(($c['red'] < 100) && ($c['green'] < 100) && ($c['blue'] < 100)) { 
								
							   
								// dark colors
								// here we use the new color, but the original alpha channel
								//$colorB = imagecolorallocatealpha($im,56, 56, 56, 127);
								$colorB = imagecolorallocatealpha($im,$r, $g, $b, 1);
								// $colorB = imagecolorallocatealpha($im,98, 147, 3, 1);
						
								imagesetpixel($im, $x, $y, $colorB);
								}
								}
								}
								imagepng($im,$filename);
								imagedestroy($im);
								
								//Place image after color fill
								
								$QR1 = imagecreatefrompng($filename);
								//$logopng = imagecreatefrompng($logo);
								if(isset($ext) && ($ext =='jpg' || $ext =='jepg')){
								   $logopng = imagecreatefromjpeg($logo);
								}else{
								   $logopng = imagecreatefrompng($logo);
								}	
								
							$QR_width1 = imagesx($QR1);
							$QR_height1 = imagesy($QR1);
							$out1 = imagecreatetruecolor($QR_width1, $QR_width1);
							imagecopyresampled($out1, $QR1, 0, 0, 0, 0, $QR_width1, $QR_height1, $QR_width1, $QR_height1);
							imagecopyresampled($out1, $logopng, $QR_width1/2.65, $QR_height1/2.65, 0, 0, $QR_width1/4, $QR_height1/4, $newwidth, $newheight);
							imagepng($out1,$filename);
							imagedestroy($out1);
							
							$type = pathinfo($filename, PATHINFO_EXTENSION);
							$data = file_get_contents($filename);
							$imgaename=$PNG_WEB_DIR.basename($filename);																					
							return basename($filename);  
							
					}else{							
						echo "0"; exit;					
					}
		
		exit;
	
	}					
 function userplandata($planid)
           {			   
			    $sql = "SELECT count(id) as id FROM ci_user_plan_details where plan_id='".$planid."' ";	
			    $query = $this->obj->db->query($sql);
			    $result = $query->result_array();
				
				if(isset($result[0]['id']) && ($result[0]['id'] > 0)){
				   return $result[0]['id'];
				}else{
				   return "0";
				
				}	
				
			}	
 function getwallet($userid)
           {			   
			    $sql = "SELECT wallet_total as wallet FROM ci_users where id='".$userid."'";	
			    $query = $this->obj->db->query($sql);
			    $result = $query->result_array();
				
				if(isset($result[0]['wallet']) && ($result[0]['wallet'] > 0)){
				   return $result[0]['wallet'];
				}else{
				   return "0";
				
				}	
				
			}	  

		  

	}	