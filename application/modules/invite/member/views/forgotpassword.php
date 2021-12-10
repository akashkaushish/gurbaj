<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> 
      <h2> Forgot Password</h2>
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
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/forgotpassword')?>" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="exampleInputEmail1">Email*</label>
            <input type="text" name="email" class="form-control" placeholder="email" required>
          </div>
          
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>