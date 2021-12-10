<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MX_Controller {
		
		var $template = array();
		
		function __construct()
		{
			parent::__construct();
			//$this->output->enable_profiler(true);
						
			$this->load->library('administration');
			$this->load->model('bodies_model');
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->template['module']	= 'asset';
			$this->template['admin']		= true;
			$this->_init();
		}
		
		function index()
		{
			redirect('asset/admin/listall');
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
		
		function listall() 
		{

			
			//$this->template['bodies'] = $this->bodies_model->get_allbodies($where, array('limit' => $limit, 'start' => $start, 'order_by' => $order));
			$this->template['asset'] = $this->db->get('bundle')->result_array();
			// $this->load->library('pagination');

			// $config['uri_segment'] = 4;
			// $config['first_link'] = 'First';
			// $config['last_link'] = 'Last';
			// $config['base_url'] = site_url('asset/admin/listall');
			// $config['total_rows'] = $this->bodies_model->bodies_total;
			// $config['per_page'] = $limit;

			// $this->pagination->initialize($config); 

			// $this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = '0';
			
			$this->layout->load($this->template, 'admin');
			return;
		}

		
		function deleteasset($id)
		{
			if ($id > 0)
			{
				
				$this->db->delete('bundle', array('id' => $id));
				$this->session->set_flashdata("notification", "Asset deleted.");
				redirect("asset/admin/listall");
			}
			else
			{
				$this->session->set_flashdata("notification", "Asset does not exist.");
				redirect("asset/admin/listall");
			}
						
		}

		
		
		function status($body_id = null, $fromstatus = null)
		{
			if (is_null($body_id) || is_null($fromstatus))
			{
				$this->session->set_flashdata("notification", "Body Id and status required", $this->template['module']);
				redirect("bodies/admin/listall");
			}
			
			if ($fromstatus == 1) 
			{
				$data['status'] = 0;
			}
			else
			{
				$data['status'] = 1;
			}
			$this->bodies_model->update_user($user_id, $data);
			$this->session->set_flashdata("notification", "Body status updated", $this->template['module']);
			redirect("bodies/admin/listall");
			
			
		}

		function creatbundle(){	
			$this->layout->load($this->template, 'addasset');
		}

		function saveasset() {
				try {
					$data = array(
									'name' => $this->input->post('name'),
									'url' => $this->input->post('url'),
									'device' => $this->input->post('device'),
									'version' => $this->input->post('version')
							);		
					$this->db->insert('bundle',$data);
					$assetid = $this->db->insert_id();
					if($assetid){
						redirect('asset/admin/listall');
					}
				}
				catch(Exception $e) {
				  echo 'Message: ' .$e->getMessage();
				}

			}

		function editasset($para){	
			$this->template['assetdata'] = $this->db->get_where('bundle', array('id'=>$para))->row_array();
			$this->layout->load($this->template, 'editasset');
		}

		function saveeditasset() {
				try {
					$para = $this->input->post('para');
					$data = array(
									'name' => $this->input->post('name'),
									'url' => $this->input->post('url'),
									'device' => $this->input->post('device'),
									'version' => $this->input->post('version')
							);		
					$this->db->trans_start();
					$this->db->where('id', $para);
					$this->db->update('bundle',$data);					
					$this->db->trans_complete();
					if ($this->db->trans_status() === true) {
						redirect('asset/admin/listall');
					}
				}
				catch(Exception $e) {
				  echo 'Message: ' .$e->getMessage();
				}

			}

		function editbody($body_id = null) 
		{
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
						
			//$this->form_validation->set_rules('body_title', 'Body Title', $this->template['module'],"trim|required");
					
			if ( $body_id == 0 || $body_id == '' )
			{
				$this->session->set_flashdata("notification", "This bodies doesn't exist");
				redirect("bodies/admin/listall");
			}
			$this->template['body_id'] = $body_id;			
			if ($this->template['bodies'] = $this->bodies_model->get_body_by_id($body_id))
			{
				
				if (!$this->input->post('submit') == 'Save')
				{		
				//if ($this->form_validation->run() == FALSE)
				//{
					$this->layout->load($this->template, 'edit');
				}
				else
				{
				 
				$imgname ="";
				$is_active = ($this->input->post('is_active') !="")?1:0;
				if(isset($_FILES['body_image']) && !empty($_FILES['body_image'])) {

				  // $allowed_types = array('image/fbx');       
				  $allowed_types = array('image/bmp', 'image/x-windows-bmp', 'image/gif', 'image/x-icon', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/tiff'); 

					$fileType = $_FILES['body_image']['type'];

				    $type=explode('/', $fileType);
					 
					if (in_array($fileType, $allowed_types)) {
							$name = uniqid();
							$findExt = explode(".",$_FILES['body_image']['name']);
							$ext = $findExt[count($findExt)-1];	
							$imgname = $name.'.'.$ext;
							$filename = FCPATH.'media/bodyimage/'.$imgname;										
							@chmod($filename , 777);
							copy($_FILES['body_image']['tmp_name'], $filename);
					}				

					$data = array(
								'body_title' => $this->input->post('body_title'),
								'body_image' => $imgname,							
								'is_active' => $is_active
						);	
				}else{
					$data = array(
						'body_title' => $this->input->post('body_title'),
						'is_active' => $is_active
						);
				}
				

				$this->bodies_model->updatebody($body_id, $data);
				$this->session->set_flashdata('notification', "bodies saved", $this->template['module']);
				redirect('bodies/admin/listall');
				}
			}
			else 
			{
				$this->session->set_flashdata("notification", "This bodies doesn't exist", $this->template['module']);
				redirect("bodies/admin/listall");
			}				

		}


	
		
		function createThumbnail($sourcePath, $thumbDirectory, $thumbWidth , $ext, $thumb_height="") {  

			if($ext == "jpg" || $ext == "jpeg")		{ 
				$srcImg = imagecreatefromjpeg($sourcePath); 
				$origWidth = imagesx($srcImg);
				$origHeight = imagesy($srcImg);
				$ratio = $origWidth / $thumbWidth;
				if($thumb_height ==""){
				$thumbHeight = $origHeight/$ratio;
				}else{ $thumbHeight = $thumb_height; }
				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagejpeg($thumbImg, $thumbDirectory);			

			}else if($ext == "png")	{  

				$srcImg = imagecreatefrompng($sourcePath); 
				$origWidth = imagesx($srcImg);
				$origHeight = imagesy($srcImg);
				$ratio = $origWidth / $thumbWidth;
				//$thumbHeight = $origHeight/$ratio;
				if($thumb_height==""){
				$thumbHeight = $origHeight/$ratio;
				}else{ $thumbHeight = $thumb_height; }

				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagepng($thumbImg, $thumbDirectory);
			}

			else if($ext == "gif")	{

				$srcImg = imagecreatefromgif($sourcePath); 
				$origWidth = imagesx($srcImg); 
				$origHeight = imagesy($srcImg);
				$ratio = $origWidth / $thumbWidth;
				//$thumbHeight = $origHeight/$ratio;
				if($thumb_height==""){
				$thumbHeight = $origHeight/$ratio;
				}else{ $thumbHeight = $thumb_height; }

				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagegif($thumbImg, $thumbDirectory);
			}
			return true;

		}




	}
	
?>