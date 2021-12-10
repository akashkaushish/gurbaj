<!--body start here-->
  <div class="container">
	<form class="settings" id="signupform" action="<?php  echo site_url('member/signup')?>" method="post" accept-charset="utf-8">
	
    <div class="wrap">
      <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
        <li><a href="">Signup</a> </li>
      </ul>
      <div class="row"> 
        <!--login-->
        <div class="register-bx">
          <h2>CREATE COACH ACCOUNT</h2>
          <p>Please fill up the form below, all fields are mandatory.</p>
			<?php if ($notice = $this->session->flashdata('notification')):?>
				<p class="notice"><b><?=$notice;?><b></p>
			<?php endif;?>
			<p><b><?php echo validation_errors(); ?></b></p>
			
          <div class="control-group2">
            <label>First Name: *</label><input name="first_name" value="<?php  echo set_value('first_name');?>" type="text" class="frmfield4">
          </div>
          <div class="control-group2">
            <label>Last Name: *</label><input name="last_name" value="<?php  echo set_value('last_name');?>" type="text" class="frmfield4">
          </div>
          <div class="control-group2">
            <label>Email: *</label><input name="email" value="<?php  echo set_value('email');?>" type="text" class="frmfield4">
          </div>
          <div class="control-group2">
            <label>Password: *</label><input name="password" type="password" class="frmfield4">
          </div>
          <div class="control-group2">
            <label>Confirm Password: *</label><input name="passconf" type="password" class="frmfield4">
          </div>
		  
		  <div class="control-group2">
            <label>Referrer ID: *</label><input name="ref_number" value="<?php  echo set_value('ref_number');?>" type="text" class="frmfield4">
          </div>
		  
		  <div class="control-group2">
            <label>ID Number: *</label><input name="id_number" value="<?php  echo set_value('id_number');?>" type="text" class="frmfield4">
          </div>
          
          <div class="control-group2">
            <div class="control-group3"><input name="submit" type="submit" value="submit" class="register-btn">
            </div>
          </div>
        </div>
        <!--advantages-->
        <div class="register-sidebar">
          <div class="register-now"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/register-now.jpg" alt=""></div>
          <div class="register-now"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/register-now-1.jpg" alt=""></div>
        </div>
      </div>
    </div>
	</form>
  </div>
  <!--body end here--> 