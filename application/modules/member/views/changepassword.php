<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Change Password</h6>
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
            <h3 class="text-white mb-0">For sake of security, change your password by time.</h3>
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
        <form class="form-horizontal" method="POST" action="<?php echo site_url('member/changepassword')?>" >
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label class="form-control-label">Old Password*</label>
              <input type="password" name="oldpassword" placeholder="Old Password" class="form-control input-solid" required>
              <div class="valid-feedback"> Looks good! </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-control-label">New Password</label>
              <input type="password" name="password" placeholder="New Password" class="form-control input-solid" autocomplete="off" required>
              <div class="valid-feedback"> Looks good! </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-control-label">Confirm Password</label>
              <input type="password" name="passconf" placeholder="Confirm Password" class="form-control input-solid" required>
              <div class="invalid-feedback"> Please choose a username. </div>
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
