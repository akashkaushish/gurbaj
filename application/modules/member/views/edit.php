<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center">
      <h2> Edit Users Information</h2>
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
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('member/admin/edit/'.$user_id)?>" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="exampleInputEmail1">First Name*</label>
            <input class="form-control" type="text" value="<?php  echo $member['fname']?>"  name="fname" placeholder="First name" >
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Last Name*</label>
            <input class="form-control" type="text"  value="<?php  echo $member['lname']?>" name="lname"  placeholder="Last name" >
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email*</label>
            <input class="form-control" name="email" value="<?php  echo $member['email'];?>" id="email"  type="email" placeholder="Enter email address">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Phone*</label>
            <input class="form-control"  value="<?php  echo $member['phone'];?>"   name="phone" type="text" placeholder="Enter Phone" >
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">ID*</label>
            <input class="form-control"  value="<?php  echo $member['my_ref_code'];?>"   type="text"  placeholder="Enter Ref ID" readonly="">
          </div>
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>
