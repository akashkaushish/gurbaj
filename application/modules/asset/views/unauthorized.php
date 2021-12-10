<h1 ><?php  echo "Unauthorized"; ?></h1>
	<h2><?php  echo "Module"; ?>: <?php  echo ucfirst($data['module'])?></h2>
	<?php  
	switch ($data['level'])
	{
		case 0:
		$levelword = "have access to";
		break;
		case 1:
		$levelword = "view in";
		break;
		case 2:
		$levelword = "add into";
		break;
		case 3:
		$levelword = "edit in";
		break;
		case 4:
		$levelword = "delete in";
		break;
	}
	?>
	<?php  echo sprintf( "Sorry, you cannot %s the %s module", $levelword, $data['module'] )?>
	<p>
	<a href="<?php  echo site_url( $this->session->userdata("last_uri") ) ?>"><?php  _e("Go back", $module) ?></a>
	</p>

