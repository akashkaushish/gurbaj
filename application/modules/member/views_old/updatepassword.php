<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Change Password</h1>
            <p>Update password for <b>Current Email:</b> <?php echo @$user[0]['email'];?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="buySell_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-md-offset-2">
        <div class="form-content">
          <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
          <p class="notice" style="clear:both;">
            <?php  echo $notice;?>
          </p>
          <?php  endif;?>
          <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
          <div class="alert alert-success">
            <?php  echo $success;?>
          </div>
          <?php  endif;?>
          <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
          <div class="alert alert-danger">
            <?php  echo $error;?>
          </div>
          <?php  endif;?>
          <p><?php echo validation_errors(); ?></p>
          <form class="form-horizontal" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/updatepassword/'.$key)?>" method="post" accept-charset="utf-8">
            <div class="form-group">
              <label class="col-sm-4 control-label">New Password*</label>
              <div class="col-sm-8">
                <input type="password" name="password" class="form-control input-solid" placeholder="New Password" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Confirm Password</label>
              <div class="col-sm-8">
                <input type="password" id="passconf" name="passconf" class="form-control input-solid" placeholder="Confirm Password" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-8 col-sm-offset-4"> <a href="<?php echo site_url('member/login');?>" class="form-title">Sign In</a> | <a href="<?php echo site_url('member/signup');?>" class="form-title">Signup</a> </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" name="submit" value="Submit" class="btn btn-default mr-10">Submit</button>
                <a href="<?php echo site_url('');?>" >
                <button type="button" class="btn btn-orange">Cancel</button>
                </a> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
