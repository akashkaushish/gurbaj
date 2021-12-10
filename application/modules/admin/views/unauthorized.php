<!-- [Left menu] start -->
<div class="leftmenu">

	<h1 id="quicklaunch"><?php echo "Settings";?></h1>
	
	<ul class="quickmenu">
		<li><a href="<?php echo site_url('admin/settings')?>"><?php echo "General settings";?></a></li>
		<li><a href="<?php echo site_url('admin/module')?>"><?php echo "Modules settings";?></a></li>		
		<li><a href="<?php echo site_url('admin/admins')?>"><?php echo "Administrators";?></a></li>		
	</ul>
	<div class="quickend"></div>

</div>
<!-- [Left menu] end -->

<!-- [Content] start -->
<div class="content slim">

<h1 id="dashboard"><?php echo "Unauthorized";?></h1>

<hr />


<div class="row">


	<h2><?php echo "Module";?>: <?php echo ucfirst($data['module'])?></h2>
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
	<?php echo sprintf( "Sorry, you cannot %s the %s module", $levelword, $data['module'] )?>

	<p>
	<a href="<?php echo site_url( $this->session->userdata("last_uri") ) ?>"><?php echo "Go back"; ?></a>
	</p>
	
</div>

<br class="clearfloat" />

</div>
<!-- [Content] end -->
