<!--body start here-->



<div class="container">

  <div class="wrap">

    <ul class="breadcrumb">

      <li>Home <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>

      <li><a href="">My Account</a> </li>

    </ul>

  </div>

</div>

<div class="wrap">

<div class="topbutton">

     <?php if ($_SESSION['is_coach']==0){?>

    <a href="<?php echo site_url('member/customertocoach')?>" class="member-btn"> I am a Coach</a>

    <?php }?>

    <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>

    <!--a href="<?php echo site_url('member/coach')?>" class="member-btn"> Upgrade Membership</a-->

    <?php }?>

	

	  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>

  <p class="notice center">

    <?php  echo $notice;?>

  </p>

  <?php  endif;?>

  </div>

  <div class="account-main">

    <div class="account-link">

      <h2>My Account</h2>

           <ul>

        <li><a href="<?php echo site_url('member/products')?>" ><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Products</a></li>

        <li><a href="<?php echo site_url('member/services')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/services-icon.png" alt=""/></span>Services</a></li>

        <li><a href="<?php echo site_url('member/video')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/videoicon1.png" alt=""/></span>Training Videos</a></li>

        <?php if ($_SESSION['is_coach']==0){?>

        <li><a href="<?php echo site_url('member/customertocoach')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>I am a Coach</a></li>

        <?php }?>

        <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>

        <li><a href="<?php echo site_url('member/coach')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/upgrade-icon.png" alt=""/></span>Upgrade Membership</a></li>

        <?php }?>

        <li><a href="<?php echo site_url('member/changepassword')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/changepass-icon.png" alt=""/></span>Change Password</a></li>

        <?php if ($_SESSION['is_coach']==1){?>

		<?php if($_SESSION['is_paid']==1){?>

        <li><a href="<?php echo site_url('member/mycustomer')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/mycustomer-icon.png" alt=""/></span>My Downline</a>

		 <?php }?>

        <li><a href="#" ><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notifications</a>

          <ul>

            <?php if($_SESSION['is_paid']==1){?>

            <li><a href="<?php echo site_url('member/allnotification')?>">Gallery</a></li>

            <li><a href="<?php echo site_url('member/sentnotification')?>">Sent</a></li>

            <li><a href="<?php echo site_url('member/receivednotification')?>">Received</a></li>

            <?php }else{?>

            <li><a href="<?php echo site_url('member/allnotification')?>">Gallery</a></li>

            <li><a href="<?php echo site_url('member/receivednotification')?>">Received</a></li>

            <?php }?>

          </ul>

        </li>

        <?php }else{  ?>

        <li><a href="<?php echo site_url('member/receivednotification')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notifications</a>

          <?php } ?>

      </ul>

       

    </div>

  </div>

  <div class="subscribe-main">

    <h1> <?php if ($_SESSION['is_coach']==0){?>

     Become A Coach

    <?php }?>

    <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>

    Upgrade Now

    <?php }?></h1>

    

      <div class="login-bx1">

        <p>By Upgrading you will be able to send assertive messages and content to your down line of Coaches and to your Customers.  You will also be able to have real time Chat communications with your down line.  The cost for the Upgraded features are $3.95 / Month.  Click the button below to start the payment process.<!--You can upgrade your account, by paying a minimal fee of $6 (US). We will not store any of your details. Click the button below to start the payment process.--></p>

        

        

		<div class="control-group2">

		<a  class="paypalimg" href="<?php echo base_url().'member/buy'; ?>" class="float:left;"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/paypal.png" alt=""/></a>
		
		<a href="<?php echo base_url().'member/buy'; ?>"> <img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/visa.jpg" alt=""/></a>
		
		
		

		<!--form action="https://www.paypal.com/cgi-bin/webscr" method="post">

			<input type="hidden" name="cmd" value="_xclick">

			<input type="hidden" name="business" value="pay@rackron.com">

			<input type="hidden" name="item_name" value="Fitness Club Network Membership Fee">

			<input type="hidden" name="item_number" value="1">

			<input type="hidden" name="amount" value="6.00">

			<input type="hidden" name="no_shipping" value="0">

			<input type="hidden" name="no_note" value="1">

			<input type="hidden" name="currency_code" value="USD">

			<input type="hidden" name="lc" value="US">

			<input type="hidden" name="bn" value="PP-BuyNowBF">

			<input type="hidden" name="return" value="http://dackpharma.com/fitnessclub/index.php?/member/paymentconfirmation">

			<input type="submit" value="Pay with PayPal!">

			<img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">

		</form-->

		</div>



      </div>

    

  </div>

</div>

<!--body end here-->

