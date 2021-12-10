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
<!--change password-->
<?php if ($notice = $this->session->flashdata('notification')):?>
<p class="notice"><?php echo $notice;?></p>
<?php endif;?>
<p><?php echo validation_errors(); ?></p>
<div class="form-container">
  <div class="card p-4">
    <h2>Change Password</h2>
    <p>Submit Form With Credentials:</p>
    <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/changepassword')?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Old Password* </label>
        <input class="form-control" type="password" name="oldpassword"  placeholder="Old Password">
      </div>
      
      <div class="form-group">
        <label for="exampleFormControlInput1">New Password* </label>
        <input class="form-control" type="password" name="password"  placeholder="New Password">
      </div>

      <div class="form-group">
        <label for="exampleFormControlInput1">Confrim Password* </label>
        <input class="form-control" type="password" name="passconf"  placeholder="Confrim Password">
      </div>

      
      <div class="form-group text-center">
        <button type="submit" value= "Submit" class="btn btn-success">Submit</button>
        <a  href="<?php echo site_url('member/dashboard');?>">
        <button type="button" class="btn btn-secondary">Cancel</button>
        </a> </div>
    </form>
  </div>
</div>


