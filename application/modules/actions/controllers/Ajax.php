<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/*
 * $Id: document.php 1070 2008-11-18 06:26:42Z hery $
 *
 *
 */
  


class Ajax extends MX_Controller {
	
	var $template = array();

	function __construct()
	{
		parent::__construct();
		
		$this->template['module']	= 'advertiser';
	}

	function login()
	{
		$username = '';
		$password = '';
		
		if(!$username = $this->input->post('username'))
		{
			$data['message'] = "Username is required";
			$data['status'] = 0;
			$this->output->set_header("Content-type: text/xml");
			$this->load->view('ajax', $data);
			return;
		}
		
		if(!$password = $this->input->post('password'))
		{
			$data['message'] = "Please enter your password";
			$data['status'] = 0;
			$this->output->set_header("Content-type: text/xml");
			$this->load->view('ajax', $data);
			return;
		}
	
		if ($this->user->login($username, $password))
		{
			$data['message'] = "Logged in:". " " . $username;
			$data['message'] .= "<br /><a href='" . site_url('advertiser/logout') . "'>" . "Sign out". "</a>"; 
	
			$data['status'] = 1;
			
			$data = $this->plugin->apply_filters('logged_in_message', $data);
			$this->output->set_header("Content-type: text/xml");
			$this->load->view('ajax', $data);
			return;
		}
		else
		{	
			$data['message'] = "Login error. Please verify your username " . $this->input->post('username') . " and your password.";
			$data['status'] = 0;
			$this->output->set_header("Content-type: text/xml");
			$this->load->view('ajax', $data);
			return;
		}

	}
	
	function exists($field)
	{
		if (is_null($field))
		{
			echo "false";
		}
		switch($field)
		{
			case 'username':
				if(! $username = $this->input->post('username'))
				{
					echo "false";
					return;
				}
			
				$this->load->model('advertiser_model', 'advertiser');
				if ($this->advertiser->exists(array('username' => $username)))
				{
					echo "false";
					return;
				}
				else
				{
					echo "true";
				}
			
			break;
			case 'email':
				if(! $email = $this->input->post('email'))
				{
					echo "false";
					return;
				}
			
				$this->load->model('advertiser_model', 'advertiser');
				if ($this->advertiser->exists(array('email' => $email)))
				{
					echo "false";
					return;
				}
				else
				{
					echo "true";
				}
			
			break;
		}
	}

}	
?>