<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Activate Account</h1>
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
        <div class="form-content text-center">
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
         
          <div class="form-group">
            <div class="col-sm-12"> <a href="<?php echo site_url('member/forgotpassword');?>" class="btn btn-default mr-10">Forgot Password</a> <a href="<?php echo site_url('member/signup');?>" class="btn btn-orange">Signup</a> </div>
			<br /><br />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.End of buy & sell content -->
<footer class="footer">
