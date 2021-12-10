<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> 
      <h2> Change Password</h2>
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
    <div class="login-sec">
      <div class="thm-container">
        <div class="login-header">
          <p><b>Current Email:</b> <?php echo @$user[0]['email'];?></p>
        </div>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <p><?php echo validation_errors(); ?></p>
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/updatepassword/'.$key)?>" method="post" accept-charset="utf-8">
          <?php if($stat > 0){ ?>
          <div class="form-group">
            <label for="exampleInputEmail1">New Password*</label>
            <input type="password" name="password" class="form-control" placeholder="New Password" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Confrim Password*</label>
            <input type="password" id="passconf" name="passconf" class="form-control" placeholder="Confrim Password" required>
          </div>
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        <?php } ?>
          
        </form>
        <div class="row">
      <div class="col-md-6">
      <a href="<?php echo site_url('member/login');?>"><small>Sign In</small></a>
      </div>
      <div class="col-md-6 text-right">
          
      </div>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>