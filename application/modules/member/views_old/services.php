<!--body start here-->

<div class="container">
  <div class="wrap">
    <ul class="breadcrumb">
      <li>Home <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="">My Account</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="" class="aciveurl-breadcrumb">Services</a> </li>
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
            <li><a href="<?php echo site_url('member/products')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Products</a></li>
            <li><a href="<?php echo site_url('member/services')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/services-icon.png" alt=""/></span>Services</a></li>
            <li><a href="<?php echo site_url('member/video')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/videoicon1.png" alt=""/></span>Training Video</a></li>
           <?php if ($_SESSION['is_coach']==0){?> <li><a href="<?php echo site_url('member/coach')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Become a Coach</a></li> <?php }?>
		   <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?> <li><a href="#"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/upgrade-icon.png" alt=""/></span>Upgrade Membership</a></li> <?php }?>
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
    <h1>Services</h1>
    <?php foreach($services as $servicesdata): ?>
    <div class="subscribe-person">
		<a href="<?php echo  $servicesdata['data_link']; ?>" target="_blank" style="text-decoration:none"><h2 class="myaccount_heading"><?php echo  $servicesdata['title']; ?></h2></a>
      <!--span class="urls"><a href="<?php echo  $servicesdata['data_link']; ?>" target="_blank"><?php echo  $servicesdata['data_link']; ?></a></span--> </div>
    <?php endforeach; ?>
	<div class="pagging-new"><ul><?php  echo $pager?></ul></div>
  </div>
</div>
<!--body end here-->
