<!--body start here-->
<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/c/video.js"></script>
<div class="container">
  <div class="wrap">
    <ul class="breadcrumb">
      <li>Home <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="">My Account</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="" class="aciveurl-breadcrumb">Video</a> </li>
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
  <div class="account-main">
    <div class="account-link">
      <h2>My Account</h2>
      <ul>
        <li><a href="<?php echo site_url('member/products')?>" ><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Products</a></li>
        <li><a href="<?php echo site_url('member/services')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/services-icon.png" alt=""/></span>Services</a></li>
        <li><a href="<?php echo site_url('member/video')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/videoicon1.png" alt=""/></span>Training Video</a></li>
        <?php if ($_SESSION['is_coach']==0){?>
        <li><a href="<?php echo site_url('member/coach')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Become a Coach</a></li>
        <?php }?>
        <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>
        <li><a href="#"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/upgrade-icon.png" alt=""/></span>Upgrade Membership</a></li>
        <?php }?>
        <li><a href="<?php echo site_url('member/changepassword')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/changepass-icon.png" alt=""/></span>Change Password</a></li>
        <?php if ($_SESSION['is_coach']==1 && $_SESSION['is_paid']==1){?>
        <li><a href="<?php echo site_url('member/mycustomer')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/mycustomer-icon.png" alt=""/></span>My Downline</a>
        <li><a href="#" ><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
          <ul>
            <li><a href="<?php echo site_url('member/allnotification')?>">Gallery</a></li>
            <li><a href="<?php echo site_url('member/sentnotification')?>">Sent</a></li>
            <li><a href="<?php echo site_url('member/receivednotification')?>">Received</a></li>
          </ul>
        </li>
        <?php }else{  ?>
        <li><a href="<?php echo site_url('member/receivednotification')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
          <?php } ?>
      </ul>
    </div>
  </div>
  <div class="subscribe-main">
    <h1>Video</h1>
    <?php foreach($video as $videodata): ?>
    <div class="subscribe-person">
      <?php if( $videodata['video']!=''){ ?>
      <?php //if( ($videodata['video_for']==0)
		
		
		   if( ($_SESSION['is_coach']==1) && ( $_SESSION['is_paid']==1)){
		   
		            if($videodata['video_for']==1){?>
      <?php if($videodata['video']!='')
					         {
					            $findExt = explode(".",$videodata['video']);
		                        $ext = $findExt[count($findExt)-1];
							}	?>
      <?php if($ext=='flv'){?>
      <a  <?php if( $videodata['video']==''){ ?> href="<?php echo  $videodata['data_link']; ?>" target="_blank" <?php }else{?>href="javascript:void(0);"<?php }?> style="text-decoration:none">
      <h2 class="myaccount_heading"><?php echo  $videodata['title']; ?></h2>
      </a> <br />
      <video id="<?php echo base_url();?>media/video_training/<?php  echo $videodata['video']?>" class="video-js vjs-default-skin" width="100%" height="420"
        data-setup='{"controls" : true, "autoplay" : true, "preload" : "auto"}'>
        <source src="<?php echo base_url();?>media/video_training/<?php  echo $videodata['video']?>" type="video/x-flv">
      </video>
      <?php }else{ ?>
      <a  <?php if( $videodata['video']==''){ ?> href="<?php echo  $videodata['data_link']; ?>" target="_blank" <?php }else{?>href="javascript:void(0);"<?php }?> style="text-decoration:none">
      <h2 class="myaccount_heading"><?php echo  $videodata['title']; ?></h2>
      </a> <br />
      <video width="100%" height="auto" controls>
        <source src="<?php echo base_url();?>media/video_training/<?php  echo $videodata['video']?>" type="video/mp4">
        <source src="movie.ogg" type="video/ogg">
        Your browser does not support the video tag. </video>
      <?php  }?>
      <?php 	}
		   
		   
		   }else{
		      
		           if(($videodata['video_for']==0) && ($_SESSION['is_coach']==0)){?>
      <a  <?php if( $videodata['video']==''){ ?> href="<?php echo  $videodata['data_link']; ?>" target="_blank" <?php }else{?>href="javascript:void(0);"<?php }?> style="text-decoration:none">
      <h2 class="myaccount_heading"><?php echo  $videodata['title']; ?></h2>
      </a> <br />
      <video width="70%" height="auto" controls>
        <source src="<?php echo base_url();?>media/video_training/<?php  echo $videodata['video']?>" type="video/mp4">
        <source src="movie.ogg" type="video/ogg">
        Your browser does not support the video tag. </video>
      <?php 	}
		       
		   
		   }
		
		?>
      <?php }?>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<!--body end here-->
