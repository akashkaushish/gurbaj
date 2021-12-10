<!--body start here-->
  <div class="container">
    <div class="wrap">
      <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
        <li><a href="">Sign In To Your Account</a> </li>
      </ul>
      <div class="row"> 
        <!--login-->
		<form name="loginform" method="POST" action="<?php echo site_url('member/login')?>">
        <div class="login-bx">
          <h2>Login</h2>
          <p>You may login here, both the fields are mandatory. Be assured, we don't store your password.</p>
		  
		  <?php if ($notice = $this->session->flashdata('notification')):?>
			<p class="notice"><?php echo $notice;?></p>
			
			<?php endif;?>
			
			<p><?php echo validation_errors(); ?></p>

          <div class="control-group2">
            <label>Email: *</label><input name="email" value='<?php echo set_value('email'); ?>' type="text" class="frmfield4">
          </div>
          <div class="control-group2">
            <label>Password: *</label><input name="password" value='<?php echo set_value('password'); ?>' type="password" class="frmfield4">
          </div>
          <div class="control-group2"><a href="<?php echo site_url('member/forgotpassword')?>" class="forgot">Forgot Your Password?</a></div>
          <div class="control-group2"><input name="submit" value="submit" type="submit" class="login-btn">
          </div>
        </div>
		</form>
        <!--register-->
        <div class="login-bx reseller">
          <h2>Become a Coach</h2>
          <div class="control-group2">
            <p> Become a Coach. For just $3.95/mo you can create your own team messages and push them out to your organization in a single touch. You can also enjoy instant, private, two-way communications. </p>
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