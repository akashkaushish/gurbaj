<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center">
      <h2> Pay Royalty</h2>
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
    <div class="login-sec">
      <div class="thm-container">
        <div class="login-header">
          <p>Please Enter The Amount:</p>
        </div>
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
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/admin/payrotalty/'.$id)?>" method="post" accept-charset="utf-8">
          <div class="form-group">
          <div class="form-group">
            <label for="exampleInputEmail1">Amount</label>
            <input type="text" id="amount" name="amount" class="form-control" placeholder="Amount" required>
          </div>
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>
