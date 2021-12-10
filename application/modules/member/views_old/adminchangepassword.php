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
          <p>Submit form with credentials:</p>
        </div>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <p><?php echo validation_errors(); ?></p>
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/admin/changepassword')?>" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="exampleInputEmail1">Old Password*</label>
            <input type="password" id="transaction_id" name="oldpassword" class="form-control" placeholder="Old Password"  >
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">New Password*</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="New Password"  >
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Confrim Password*</label>
            <input type="password" id="passconf" name="passconf" class="form-control" placeholder="Confrim Password"  >
          </div>
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>