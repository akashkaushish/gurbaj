<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Profile Verification</h6>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">Please enter the verification code sent over email.</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
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
        <form class="form-horizontal" method="POST" action="<?php echo site_url('member/verifyeditprofile')?>" >
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label class="form-control-label">Enter Verification Code*</label>
              <input type="text" name="verificationcode" class="form-control input-solid" placeholder="Verification Code" required>
              <div class="valid-feedback"> Looks good! </div>
            </div>
          <div class="col-md-12">
              <button class="btn btn-primary" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
