<script>

function validateForm() 
{
    var oldpassword = document.forms["myForm"]["oldpassword"];
    var password = document.forms["myForm"]["password"];
	var passconf = document.forms["myForm"]["passconf"];
    
    if (oldpassword.value == null || oldpassword.value.trim() == "") 
    {
      alert("Please enter your previous password.");
	  oldpassword.focus();
      return false;
    }
    if (password.value == null || password.value.trim() == "") 
    {
      alert("Please enter new password.");
	  password.focus();
      return false;
    }
	if (passconf.value == null || passconf.value.trim() == "") 
    {
      alert("Please enter confirm password.");
	  passconf.focus();
      return false;
    }
	if (passconf.value != password.value) 
    {
      alert("Password and confirm password do not match.");
	  passconf.focus();
      return false;
    }

    return true;

}

</script>
<!-- Header -->
<div class="header bg-gradient-primary  pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
         <h2 class="text-white">Change Password</h2>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12">
                  <h4 class="mb-0">Submit Form With Credentials :</h4>
                </div>

              </div>
            </div>
      <div class="card-body">
        <?php if ($notice = $this->session->flashdata('notification')):?>
          <p></p>
          <p class="notice"><?php echo $notice;?></p>
        <?php endif;?>
        <p><?php echo validation_errors(); ?></p>
          <form onsubmit="return validateForm()" name="myForm" method="POST" enctype="multipart/form-data" action="<?php echo site_url('member/changepassword')?>">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-brandname">Old Password* </label>
                  <input type="password" name="oldpassword" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-brandname">New Password* </label>
                  <input type="password" name="password" class="form-control">
                </div>
              </div>
			</div>
			<div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-brandname">Confrim Password* </label>
                  <input type="password" name="passconf" class="form-control">
                </div>
              </div>
            </div>
			<div class="row">
				<div class="col-lg-6"></div>
            	<div class="col-lg-12 text-left">
              		<input type="submit" value= "Submit" class="btn btn-warning">
              		<a href="<?php echo site_url('member/dashboard');?>" class="btn btn-primary">Cancel</a>
            	</div>
			</div>
               
        </form>
      </div>
    </div>	  
  </div>        
</div>