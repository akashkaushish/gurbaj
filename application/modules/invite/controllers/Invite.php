<?php    if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invite extends MX_Controller {
	var $template = array();
	var $r = '';
	function __construct(){
		parent::__construct();
		$this->template['module']	= 'invite';
	}

	function index(){
		//echo 'deepak verma';
	}

	function referalcode($referal){
		$this->template['r'] = $referal;
		$this->layout->load($this->template, 'invite');
		//echo $referal;
	}

	function savereferal(){
		$mobile = $_POST['mobile'];
		$referal = $_POST['referal'];

		$data = array('referalcode'=>$referal, 'phone'=>$mobile);

		$this->db->insert('invite', $data);
		$id = $this->db->insert_id();
		if($id){
			$this->template['r'] = $referal;
			$this->layout->load($this->template, 'thanks');
		}else{
			$this->template['r'] = $referal;
			$this->layout->load($this->template, 'invite');
		}
	}
}