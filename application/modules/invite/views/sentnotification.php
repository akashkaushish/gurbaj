<!--body start here-->
<style>.center{ padding-top:10px; text-align:center; clear:both;}</style>
<link href="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/style/modal-videos.css" rel="stylesheet">
<div class="container">
  <div class="wrap">
    <ul class="breadcrumb">
      <li>Home<span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="">My Account</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="" class="aciveurl-breadcrumb">All Notofications</a> </li>
    </ul>
  </div>
</div>
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
        <li><a href="<?php echo site_url('member/video')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/videoicon1.png" alt=""/></span>Training Video</a></li>
        <?php if ($_SESSION['is_coach']==0){?>
        <li><a href="<?php echo site_url('member/coach')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Become a Coach</a></li>
        <?php }?>
        <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>
        <li><a href="#"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/upgrade-icon.png" alt=""/></span>Upgrade Membership</a></li>
        <?php }?>
        <li><a href="<?php echo site_url('member/changepassword')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/changepass-icon.png" alt=""/></span>Change Password</a></li>
         <?php if ($_SESSION['is_coach']==1 && $_SESSION['is_paid']==1){?>
		<li><a href="<?php echo site_url('member/mycustomer')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/mycustomer-icon.png" alt=""/></span>My Downline</a>
        <li><a href="#" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
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
    <h1>Sent Notifications</h1>
	 <div class="media-aset mycustomer">
      <div class="col-1" > Media Type </div>
	  <div class="col-1">Sent To</div>
	  <div class="col-2">Media Image</div>
      <div class="col-3" >Title</div>
      <div class="col-4">Action</div>
    </div>
	<?php if(count($media) > 0){?>
	
    <?php foreach($media as $media):?>
    <div class="media-aset">
      <div class="col-1"><?php echo  $media['media_type']; ?></div>
	  <div class="col-1"><?php echo $media['first_name'];?></div>
      <div class="col-2">
	  
	  <?php if ( $media['media_type_id']==1){?>
					<a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>media/media_type/photo/thumb/<?php echo  $media['media']; ?>" alt="Photo"></a>
				<?php }else{?>
					<a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/<?php echo $media['media_type']; ?>-icon-list.png" alt="<?php echo $media['media_type']; ?>"></a>
				
			   <?php }?>
			   
			   
			   
	  
   <?php /*?>     <?php if ( $media['media_type_id']==1){?>
        <a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>media/media_type/photo/thumb/<?php echo  $media['media']; ?>" alt="Photo"></a>
        <?php }else if($media['media_type_id']==2){  ?>
        <a  href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/video-icon-list.png" alt="video"></a>
        <?php }else if($media['media_type_id']==3){ ?>
					<!--img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/audio-icon.png" alt=""-->
				
					
					<a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/audio-icon-list.png" alt="audio"></a>
				<?php }else if($media['media_type_id']==4){ ?>
				
				<a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/text-icon-list.png" alt="Text"></a>
				<?php }else if($media['media_type_id']==5){ ?>
				 <a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/video-icon-list.png" alt="walkout"></a>
				
				<?php }else if($media['media_type_id']==6){ ?>
				<a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/swf-icon-list.png" alt="swf"></a>
				
			<?php 	} ?><?php */?>
      </div>
	  
      <div class="col-3"><?php echo  $media['title']; ?></div>
      <div class="col-4">
       <?php /*?> <?php if ( $_SESSION['is_coach']==1 && $_SESSION['is_paid']==1 ){?>
        <a href="<?php  echo site_url('member/sentnotificationbyuser/'.$media['user_media_id'])?>">SEND</a>
        <?php } ?><?php */?>
		
        <?php /*?><a href="#" class="<?php echo $media['user_media_id']?>">View</a><?php */?>
		<a href="<?php  echo site_url('member/mediadetail/'.$media['user_media_id'])?>" data-lity>View</a><a href="<?php  echo site_url('member/deleterecord/'.$media['user_media_id'])?>" onclick="return confirm('Are you sure you want to delete this file?');" class="<?php echo $media['user_media_id']?>">Delete</a> </div>
    </div>
    <?php endforeach; ?>
	<div class="pagging-new"><ul><?php  echo $pager?></ul></div>
	<?php }else{?>
	<div class="media-aset"><p>You haven't send any notification.</p></div>
	
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
