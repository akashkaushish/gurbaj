<?php    if (!defined('BASEPATH')) exit('No direct script access allowed');



class Bodies extends MX_Controller { 

	var $template = array();
	function __construct()	
	{
	   session_start();
		parent::__construct();
		$this->template['module']	= 'bodies';
		$this->load->model('bodies_model');	
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

	function _bodies_signup_header()
	{

		echo '<script src="' .  base_url() . 'application/views/' . $this->system->theme . '/javascript/jquery.validate.pack.js" type="text/javascript"></script>';

	}	

	function unauthorized($module, $level)

	{

		$this->template['data']  = array('module' => $module, 'level' => $level);

		$this->layout->load($this->template, 'unauthorized');

	}

	/* Get bodies all ads */
	function listbodies($start = 0, $limit = 50){
			
	  
		if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0){

			$this->template['managebody'] = $this->bodies_model->get_allbodies( array('limit' => $limit, 'start' => $start));	
			$this->load->library('pagination');
			$config['uri_segment'] = 3;
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['base_url'] = site_url('bodies/listads');
			$config['total_rows'] =$this->bodies_model->body_count();
			$config['per_page'] = $limit;
			$this->pagination->initialize($config);
			$this->template['pager'] = $this->pagination->create_links();
			$this->template['start'] = $start;
			$this->layout->load($this->template, 'managebody');
		}else{
			redirect('bodies/login');
		}
	}
	/* Create new ads */

	function createnewbody(){
	
	if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] > 0) {
			$this->layout->load($this->template, 'createnewbody');
		}
		else{
			redirect('bodies/login');
		}
	
	}
	function savebody()
	{
		try {
		if ($this->input->post('submit') == 'submit')
		{

			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			$this->form_validation->set_rules('body_title','Body Title',"trim|required|xss_clean");
			$this->form_validation->set_rules('body_image','Body Image',"trim|required|xss_clean");	
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->layout->load($this->template, 'createnewad');
			}
			else
			{
				$imgname ="";
				
				if(isset($_FILES['body_image']) && !empty($_FILES['body_image'])) {

				$allowed_types = array('image/fbx');       
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
							$targetPath = FCPATH.'media/bodyimage/thumb/'.$imgname;
							$this->createThumbnail($_FILES['body_image']['tmp_name'], $targetPath, 250 ,$ext, 250);
							$big_thumb_path =  FCPATH.'media/bodyimage/bigthumb/'.$imgname;
							$this->createThumbnail($_FILES['body_image']['tmp_name'], $big_thumb_path, 512 ,$ext, 512); // create icon image
					}
				}

				$is_active = (isset($this->input->post('is_active')))?1:0;
				
				$data = array(
							'body_title' => $this->input->post('body_title'),
							'body_image' => $imgname,							
							'is_active' => $is_active
					);				
					$body_id = $this->bodies_model->insert_newad($data);
					if($body_id){
						redirect('bodies/listbodies');
					}
			}
		}
		else {
			$this->layout->load($this->template, 'signup');
		}
		}
		catch(Exception $e) {
		  echo 'Message: ' .$e->getMessage();
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