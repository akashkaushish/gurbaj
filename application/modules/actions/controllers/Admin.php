<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MX_Controller {
		
		var $template = array();
		
		function __construct()
		{
			parent::__construct();			
			$this->load->library('administration');
			$this->load->model('actions_model');
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;			
			$this->template['module']	= 'actions';
			$this->template['admin']		= true;
			$this->_init();
		}
		
		function index()
		{
			redirect('buttonimage/admin/listall');
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
		
		function listall($start = 0, $limit = 10, $order = 'action_id') 
		{
			$where = array();			
			if ($filter = $this->input->post('filter'))
			{
				$where = array('audio_title' => $filter);
			}
			
			if ($this->input->post('sorting')){			
			     $order=$this->input->post('sorting');
			}
			
			
			$this->template['actions'] = $this->actions_model->get_actions($where, array('limit' => $limit, 'start' => $start, 'order_by' => $order));
			$this->load->library('pagination');
			$config['uri_segment'] = 4;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('actions/admin/listall');
			$config['total_rows'] = $this->actions_model->image_total;
			$config['per_page'] = $limit;
			$this->pagination->initialize($config); 
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;			
			$this->layout->load($this->template, 'admin');
			return;
		}

		
		function deleteaction($action_id)
		{
			if ($action_id > 0)
			{
			   				
				$this->actions_model->delete($action_id);	
				$this->session->set_flashdata("notification", "Action has been deleted successfully");
				redirect('actions/admin/listall');
			}
			else
			{		
				$this->session->set_flashdata("notification", "Action does not exist.");
				redirect('actions/admin/listall');
			}
						
		}

		
	

		function addaction(){		
			 	$this->layout->load($this->template, 'addaction');
		}

		function saveimage() {
				try {
				
				if ($this->input->post('submit') == 'Save')
				{

					$this->load->library('form_validation');
					$this->form_validation->CI =& $this;
					$this->form_validation->set_rules('action_title','Action Title',"trim|required");
					
					
					if ($this->form_validation->run() == FALSE)
					{
						$this->layout->load($this->template, 'addaction');
					}
					else
					{
					
						$data = array(
									'action_title' => $this->input->post('action_title'),
									'action_information' => $this->input->post('action_information'),
									'is_active' =>1,
									'created_date' => @date('Y-m-d')
							);	
									
							$actionid = $this->actions_model->insert_action($data);
							
							if($actionid){
							    $this->session->set_flashdata("notification", "Action has been deleted successfully.");
								redirect('actions/admin/listall');
							}
					}
				}else {
					redirect('actions/admin/listall');
				}
				}
				catch(Exception $e) {
				  echo 'Message: ' .$e->getMessage();
				}

			}

		function edit($action_id = null) 
		{	
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;			
			$this->form_validation->set_rules('action_title','Action title',"trim|required");
						
			if ( $action_id == 0 || $action_id == '' )
			{
				$this->session->set_flashdata("notification", "This Action doesn't exist");
				redirect('actions/admin/listall');
			}
			
			$this->template['action_id'] = $action_id;	
			$actiondata=$this->actions_model->get_action_by_id($action_id);		

			
			if ($this->template['actiondata'] = $actiondata)
			{						
				if ($this->form_validation->run() == FALSE)
				{
					$this->layout->load($this->template, 'edit');
				}
				else
				{		 
				
		
					 $data = array(
									'action_title' => $this->input->post('action_title'),
									'action_information' => $this->input->post('action_information'),
									'is_active' =>$this->input->post('is_active')
							);	
				
			
				
				$this->actions_model->updateaction($action_id, $data);
				$this->session->set_flashdata('notification', "Action data has been saved successfully");
				redirect('actions/admin/listall');
				}
			}
			else 
			{
				$this->session->set_flashdata("notification", "This actions doesn't exist");
				redirect('actions/admin/listall');
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
				$thumbHeight = $origHeight/$ratio;
				$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
				$this->setTransparency($thumbImg,$sourcePath); 
				imagealphablending($thumbImg, false);
				imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
				imagesavealpha($thumbImg, true);
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





		function subcatdata(){}

	}
	
?>