<link href="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/style/modal-videos.css" rel="stylesheet">
<div class="container">
  <div class="wrap">
    <ul class="breadcrumb">
      <li>Home<span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="">My Account</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="" class="aciveurl-breadcrumb">My Customers</a> </li>
    </ul>
  </div>
</div>
<style>
.center{ padding-top:10px; text-align:center; clear:both;}
</style>
<div class="wrap">
  <div class="topbutton">
    <?php if ($_SESSION['is_coach']==0){?>
    <a href="#" class="member-btn"> Become A Coach</a>
    <?php }?>
    <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>
    <a href="#" class="member-btn"> Upgrade Membership</a>
    <?php }?>
  </div>
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice center">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <div class="account-main">
    <div class="account-link">
      <h2>My Account</h2>
      <ul>
        <li><a href="<?php echo site_url('member/products')?>" ><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Products</a></li>
        <li><a href="<?php echo site_url('member/services')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/services-icon.png" alt=""/></span>Services</a></li>
        <li><a href="<?php echo site_url('member/video')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/videoicon1.png" alt=""/></span>Tutorial Video</a></li>
        <?php if ($_SESSION['is_coach']==0){?>
        <li><a href="<?php echo site_url('member/coach')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Become a Coach</a></li>
        <?php }?>
        <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>
        <li><a href="#"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/upgrade-icon.png" alt=""/></span>Upgrade Membership</a></li>
        <?php }?>
        <li><a href="<?php echo site_url('member/changepassword')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/changepass-icon.png" alt=""/></span>Change Password</a></li>
         <?php if ($_SESSION['is_coach']==1 && $_SESSION['is_paid']==1){?>
		<li><a href="<?php echo site_url('member/mycustomer')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/mycustomer-icon.png" alt=""/></span>My Downline</a>
        <li><a href="#"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
          <ul>
            <li><a href="<?php echo site_url('member/allnotification')?>">Gallery</a></li>
            <li><a href="<?php echo site_url('member/sentnotification')?>">Sent</a></li>
            <li><a href="<?php echo site_url('member/receivednotification')?>">Received</a></li>
          </ul>
        </li>
        <?php }else{  ?>
        <li><a href="<?php echo site_url('member/receivednotification')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
          <?php } ?>
      </ul>
    </div>
  </div>
  <div class="subscribe-main">
    <h1>My Downline</h1>
	
	<?php if(count($customers) > 0){?>
	
    <?php foreach($customers as $customer):	 ?>
    <div class="media-aset">
		<div class="col-1">
			<?php if($customer['is_coach'] == 1){ echo "Coach"; }else{ echo "Customer"; } ?>
		</div>
		<div class="col-2"><strong><?php //echo .' '.$customer['last_name']$customer['first_name']; ?>&nbsp;</strong></div>
		
		<div class="col-3" style="text-align:center;"><?php echo $customer['last_name'].', '.$customer['first_name']; ?></div>
		<div class="col-4"><?php if($customer['status'] == 'active'){ echo "Active"; }else{ echo "Declined"; } ?></div>
		<!--div class="col-4">
            <a href="#" class="<?php //echo $media['user_media_id']?>">View</a>
			<a href="#">Delete</a>
		</div-->
    </div>
    <?php endforeach; ?>
	<div class="pagging-new"><ul><?php  echo $pager?></ul></div>
	<?php }else{?>
	<div class="media-aset"><p>No records found.</p></div>
	
	<?php }?>
	
	
  </div>
</div>
<!--body end here-->
<script src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/javascript/modal-videos.js"></script>
<script>
		"use strict";

		$(document).ready(function () {
		
			//each video has need its own instance of modalVideoOptions  
			$('a[href]').each(function(){
				$(this).modalvideo(new ModalVideoOptions());
			});
		});
	</script>
