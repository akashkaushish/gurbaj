<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Admins extends MX_Controller {
		
		var $levels;
		var $template = array();
		
		function __construct()
		{
			parent::__construct();
			//$this->output->enable_profiler(true);
			$this->load->library('administration');
			
			$this->template['module'] = "admin";
			$this->template['levels'] = array(
					0 => "No access",
					1 => "Can view",
					2 => "Can add",
					3 => "Can edit",
					4 => "Can delete"
					);
			$this->user->check_level($this->template['module'], 3);
		}
		
		function index()
		{
		      
			$this->db->order_by('module ASC, level DESC');
			$query = $this->db->get('admins');
			
			$this->template['admins'] = $query->result_array();
			$this->layout->load($this->template, 'admins/index');
		}
		
		function create()
		{
			$this->user->check_level($this->template['module'], LEVEL_ADD);
			$this->layout->load($this->template, 'admins/create');
		}
		
		function edit($id)
		{
			$this->user->check_level($this->template['module'], LEVEL_EDIT);
			$this->db->where('id', $id);
			$query = $this->db->get('admins');
			$this->template['admin'] = $query->row_array();
			$this->layout->load($this->template, 'admins/edit');
		}
		
		function save($id = null)
		{
			$this->user->check_level($this->template['module'], LEVEL_EDIT);
			if ($this->input->post('submit'))
			{
				$this->db->where(array(
					'username' => $this->input->post('username'),
					'module' => $this->input->post('module'))
					);
				$query = $this->db->get('admins');
				$data = array(
					'username' => $this->input->post('username'),
					'module' => $this->input->post('module'),
					'level' => $this->input->post('level')
					);
				if ($query->num_rows() > 0)
				{
					$this->db->where(array(
					'username' => $this->input->post('username'),
					'module' => $this->input->post('module'))
					);
					$this->db->update('admins', $data);
					$this->session->set_flashdata('notification', "Administrator list updated");
		
				}
				else
				{
					$this->db->insert('admins', $data);	
					$this->session->set_flashdata('notification', "Administrator added in list");
				}
			}
			else
			{
				$this->session->set_flashdata('notification', "Nothing to save");
			}
			redirect('admin/admins');			
		}
		
		function delete($id)
		{
			$this->user->check_level($this->template['module'], LEVEL_DEL);
			$this->db->where('id', $id);
			$query = $this->db->get('admins');
			if ($query->num_rows == 1)
			{
				$row = $query->row_array();
				
				if ($this->user->username == $row['username']) 
				{
					$this->session->set_flashdata('notification', "You cannot remove yourself from the list.");
				}
				else
				{
				
					$this->db->where('id', $id);
					$this->db->delete('admins');
					$this->session->set_flashdata('notification', "User removed from administrator list");
				}
			}
			else
			{
					$this->session->set_flashdata('notification', "User not found in the list");
			}
			redirect('admin/admins');
		}
	}
?>