<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
      ob_start();
  class Admin extends MX_Controller {

		

		var $nav;

		var $level = 0;

		var $template = array();

		

		function __construct()

		{

			parent::__construct();

			

			$this->load->library('administration');

			$this->system->version = @file_get_contents(APPPATH . "version.txt");

			

			$this->check_latest_version();

			$this->template['module'] = "admin";

			$this->template['admin'] = true;
			$this->load->model('admin_model');
			$this->template['latest_version'] = $this->latest_version;

		

		}

		

		function index()

		{

		  

			if (!isset($this->user->level) ||  $this->user->level['admin'] == 0)

			{

				redirect('admin/unauthorized/admin/1');

			}

			$totaluser= $this->user->totalusers();
			
			$this->template['user']=$this->user->get_registeruser();
		

			$this->template['usercount']=$totaluser;

			$this->template['totalinvested']=$this->admin_model->get_total_invested();
			$this->template['totalwithdrawn']=$this->admin_model->get_total_withdrawn();
			$this->template['totalplan']=$this->admin_model->get_total_plans();

			if($this->user->email == '')

			{

				$this->session->set_flashdata('notification', "Please set your email");

				redirect('admin/member/edit');

			}

			

			// Get News

			// Get News if Php version smaller than 5.3.0

			$news = array();

			$news2 = array();

			

			if(!is_php('5.3.0'))

			{	

			  $this->load->library('Simplepie');

			  $this->simplepie->set_feed_url('http://ci-cms.blogspot.com/feeds/posts/default/-/news');

			  $this->simplepie->set_cache_location('./cache');

			  $this->simplepie->init();

			  $this->simplepie->handle_content_type();

			  $news = $this->simplepie->get_items();

			

			  // Get Development News

			  $this->simplepie2 = new SimplePie();

			  $this->simplepie2->set_feed_url('http://bitbucket.org/hery/ci-cms/rss?token=ffaaafc0111cc8100198a44b5c263671');

			  $this->simplepie2->set_cache_location('./cache');

			  $this->simplepie2->init();

			  $this->simplepie2->handle_content_type();

			  $news2 = $this->simplepie2->get_items();

			}

			

			// Save news if avaliable

			$this->template['cicms_news'] = $news;

			$this->template['cicms2_news'] = $news2;

			

			$this->layout->load($this->template, 'index');

			

		}

        function clear_cache()

        {

           $this->system->clear_cache();

           redirect('admin');

  

        }

        

        

		function check_latest_version()

		{

			if(!($data = $this->cache->get('latest_version', 'dashboard')))

			{

				

				ini_set('default_socket_timeout', 1);

				$data = @file_get_contents("http://ci-cms.googlecode.com/svn/trunk/application/version.txt");

				if (!$data) $data = $this->system->version;

				$this->cache->save('latest_version', $data, 'dashboard', 86400);

			}

		

			$this->latest_version = $data;

			

		}

		

		function unauthorized($module, $level)

		{

			$this->template['data']  = array('module' => $module, 'level' => $level);

			$this->layout->load($this->template, 'unauthorized');

		}

		

		

		function login()

		{
		    

			if ( $this->user->logged_in && !$this->input->post('submit') )

			{

				redirect('admin');

			}

			else

			{

				if ( !$this->input->post('submit') )

				{

					$this->layout->load($this->template, 'login');

				}

				else

				{

				

					if(!$username = $this->input->post('username'))

					{    

						$this->session->set_flashdata('notification', "Please enter username and password");

						redirect('admin/login');

					}

					

					if(!$password = $this->input->post('password'))

					{

						$this->session->set_flashdata('notification',"Please enter username and password");

						redirect('admin/login');

					}

					

					if ($this->user->login($username, $password))

					{

					

						if ($this->input->post('redirect')) 

						{

							redirect($this->input->post('redirect'));

							return;

						}					

						redirect('admin');

					}

					else

					{

						if ($this->input->post('redirect')) 

						{

							$this->session->set_flashdata('redirect', $this->input->post('redirect'));

						}

						$this->layout->load($this->template, 'login');

					}

				}

			}

		}

		

		

		

		function forgotpassword()

		{

			if ( $this->user->logged_in && !$this->input->post('submit') )

			{

				redirect('admin');

			}

			else

			{

				if ( !$this->input->post('submit') )

				{

					$this->layout->load($this->template, 'login');

				}

				else

				{

					if(!$email = $this->input->post('email'))

					{    

						$this->session->set_flashdata('notification', "Please enter right email address and password");

						redirect('admin/login');

					}

					

					

					

					if ($this->user->changepassword($email))

					{

					

						if ($this->input->post('redirect')) 

						{

							redirect($this->input->post('redirect'));

							return;

						}					

						redirect('admin');

					}

					else

					{

						if ($this->input->post('redirect')) 

						{

							$this->session->set_flashdata('redirect', $this->input->post('redirect'));

						}

						$this->layout->load($this->template, 'login');

					}

				}

			}

		}

		

		

		function logout()

		{

			$this->user->logout();

			redirect('admin/login');

		}

		

		function navigation($action = null)

		{

			$fields = array(

				'id' => '',

				'lang' => $this->user->lang,

				'parent_id' => 0,

				'active' => '',

				'title' => '',

				'uri' => '',

				'g_id' => '0'

			);

		

			$this->user->check_level('page', LEVEL_VIEW);

			switch ($action) 

			{

				case 'move':

					$direction = $this->uri->segment(4);

					$id = $this->uri->segment(5);

					if (!isset($direction) || !isset($id))

					{

						redirect('admin/navigation');

					}

					

					$query = $this->db->get_where('navigation', array('id' => $id));

					

					

					if ($row = $query->row())

					{

						$parent_id = $row->parent_id;

						

					}

					else

					{

						$parent_id = 0;

					}

					

					

					$move = ($direction == 'up') ? -1 : 1;

					$this->db->where(array('id' => $id));

					

					$this->db->set('weight', 'weight+'.$move, FALSE);

					$this->db->update('navigation');

					

					$this->db->where(array('id' => $id));

					$query = $this->db->get('navigation');

					$row = $query->row();

					$new_ordering = $row->weight;

					

					

					if ( $move > 0 )

					{

						$this->db->set('weight', 'weight-1', FALSE);

						$this->db->where(array('weight <=' => $new_ordering, 'id <>' => $id, 'parent_id' => $parent_id, 'lang' => $this->user->lang));

						$this->db->update('navigation');

					}

					else

					{

						$this->db->set('weight', 'weight+1', FALSE);

						$where = array('weight >=' => $new_ordering, 'id <>' => $id, 'parent_id' => $parent_id, 'lang' => $this->user->lang);

						

						$this->db->where($where);

						$this->db->update('navigation');

					}

					//reordinate

					$i = 0;

					$this->db->order_by('weight');

					$this->db->where(array('parent_id' => $parent_id, 'lang' => $this->user->lang));

					

					$query = $this->db->get('navigation');

					

					if ($rows = $query->result())

					{

						foreach ($rows as $row)

						{

							$this->db->set('weight', $i);

							$this->db->where('id', $row->id);

							$this->db->update('navigation');

							$i++;

						}

					}

					//clear cache

					$this->cache->remove_group('navigation');

					redirect('admin/navigation');					

					

					

					

				break;

				case 'save':

					$data = array(

						'lang' => $this->input->post('lang'),

						'parent_id' => $this->input->post('parent_id'),

						'active' => $this->input->post('status'),

						'title' => $this->input->post('title'),

						'uri' => $this->input->post('uri'),

						'g_id' => $this->input->post('g_id')

					);

					

					$this->db->set($data);

					if($id = $this->input->post('id'))

					{

						$this->db->where('id', $id);

						$this->db->update('navigation');

					}

					else

					{

						$this->db->insert('navigation');

					}

					

					$this->session->set_flashdata('notification', __("Navigation item saved", $this->template['module']));

					$this->cache->remove_group('navigation');

					redirect('admin/navigation');

				

				break;

				case 'create':

					$this->template['parents'] = $this->nav_get();

					$this->template['nav'] = $fields;

					$this->layout->load($this->template, 'navigation/create');

				break;

				case 'edit':

					$id = $this->uri->segment(4);

					if (!isset($id))

					{

						$this->session->set_flashdata('notification', __("Please select a menu", $this->template['module']));

						redirect('admin/navigation');						

					}

					

					$this->db->where('id', $id);

					$this->db->limit(1);

					$query = $this->db->get('navigation');

					if ($query->num_rows() > 0 )

					{

						$this->template['nav'] = $query->row_array();

						

						$this->layout->load($this->template, 'navigation/create');

					}

					else

					{

						$this->session->set_flashdata('notification', __("Navigation item not found", $this->template['module']));

						redirect('admin/navigation');

					}

				break;

				case 'delete':

					$id = $this->uri->segment(4);

					if (!isset($id))

					{

						$this->session->set_flashdata('notification', __("Please select a menu", $this->template['module']));

						redirect('admin/navigation');	

					}

					else

					{

					

						$this->db->where('id', $id);

						$this->db->delete('navigation');

						$this->session->set_flashdata('notification', __("Navigation item deleted", $this->template['module']));

						$this->cache->remove_group('navigation');

						redirect('admin/navigation');

					}

				break;

				default:

				

					$this->template['navigation'] = $this->nav_get();

					

					$this->layout->load($this->template, 'navigation/admin');

				break;

			}

		}

		function nav_get($parent = 0, $level = 0) {

			// retrieve all children of $parent

			$this->db->where(array('parent_id' => $parent, 'lang' => $this->user->lang));

			$this->db->order_by('parent_id, weight');

			$query = $this->db->get('navigation');

			// display each child

			foreach ($query->result_array() as $row) {

			// indent and display the title of this child

			$this->nav[] = array(

				'level' =>$level, 

				'title' => $row['title'],

				'parent_id' => $row['parent_id'],

				'id' => $row['id'],

				'uri' => $row['uri']

			);

			// call this function again to display this

			// child's children

				$this->nav_get($row['id'], $level+1);

			}

			return $this->nav;

		} 			

		

		function nav_ajax_reorder()

		{

			$i = 1;

			

			foreach($_POST['item'] as $key => $value):

			

				$data = array('weight' => $i);

				$this->db->where('id', $value);

				$query = $this->db->update('navigation', $data);

				$i++;

				

			endforeach;

			

			echo 'Update Complete';

		}

		

		function nav_ajax_add()

		{

			

		}

		

		function nav_ajax_delete()

		{

			

		}

		

		function settings()

		{

			//$this->user->check_level($this->template['module'], LEVEL_EDIT);

			$fields = array('site_name', 'meta_keywords', 'meta_description', 'cache', 'cache_time', 'theme_dir', 'theme', 'debug', 'admin_email','ads_cpm_cost','ad_cpm_user_percentage','cost_per_click','approximate');

			

			if ( !$this->input->post('submit') )

			{

				foreach ($fields as $field)

				{

					if (!isset($this->system->$field))

					{

						$this->system->$field = '';

					}

				}

				$this->template['themes'] = $this->layout->get_themes();

				$this->layout->load($this->template, 'settings');

			}

			else

			{

				foreach ($fields as $field)

				{

					if ( $this->input->post($field) !== false)

					{

						// Special handling for the theme directory

						// as we need to ensure a trailing slash

						if($field == 'theme_dir')

						{

							$val = $this->input->post($field);

							$this->system->set($field, (substr($val,-1,1) == '/'?$val:$val.'/'));	

						}

						else

						{

							$this->system->set($field, $this->input->post($field));

						}

						// if($this->input->post($field) == 'approximate'){

						// 	$

						// }else{

							

						// }

						

					}

				}

				

				if ($this->input->post('cache') == 0)

				{

					$this->system->clear_cache();

				}

				

				$this->session->set_flashdata("notification", "Settings saved successfully.");

		

				redirect('admin/settings');

			}

		}

		

	}

?>

