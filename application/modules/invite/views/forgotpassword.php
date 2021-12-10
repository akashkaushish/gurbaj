<!--body start here-->
  <div class="container">
    <div class="wrap">
      <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
        <li><a href="">Forgot Your Password</a> </li>
      </ul>
      <div class="row"> 
        <!--login-->
		<form name="loginform" method="POST" action="<?php echo site_url('member/forgotpassword')?>">
        <div class="login-bx">
         <h2>Forgot Your Password?</h2>
          <p>No worries, we'll help you reset it and get back in.</p>
		  
		  <?php if ($notice = $this->session->flashdata('notification')):?>
			<p class="notice"><?php echo $notice;?></p>
			
			<?php endif;?>
			
			<p><?php echo validation_errors(); ?></p>

          <div class="control-group2">
            <label>Email: *</label><input name="email" value='<?php echo set_value('email'); ?>' type="text" class="frmfield4">
          </div>
          <div class="control-group2"><input name="submit" value="submit" type="submit" class="login-btn"> <a href="<?php echo site_url('member/login')?>"><input name="login" value="Login" type="button" class="login-btn12"></a>
          </div>
        </div>
		</form>
        <!--register-->
        <div class="login-bx reseller">
          <h2>Become a Coach</h2>
          <div class="control-group2">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
            <br>
            <br>
          </div>
          <!--div class="control-group2">
		  <input name="" type="button" value="Download" class="register-btn">
		  <input name="" type="button" value="Download" class="register-btn">
          </div-->
        </div>
      </div>
    </div>
  </div>
  <!--body end here--> 