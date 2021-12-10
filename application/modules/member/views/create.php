<script>

function validateForm() 
{
    var first_name = document.forms["myForm"]["name"];
    var last_name = document.forms["myForm"]["lname"];
    var email = document.forms["myForm"]["email"];
    var uniq_id = document.forms["myForm"]["uniq_id"];
   // var chks = document.getElementsByName('roles[]');
    
    if (first_name.value == null || first_name.value.trim() == "") 
    {
      alert("Please enter First name.");
		  first_name.focus();
      return false;
    }

    if (last_name.value == null || last_name.value.trim() == "") 
    {
      alert("Please enter Last name.");
		  last_name.focus();
      return false;
    }
    if (uniq_id.value == null || uniq_id.value.trim() == "") 
    {
      alert("Please enter User ID.");
		  uniq_id.focus();
      return false;
    }

	  if (email.value == null || email.value.trim() == "") 
    {
      alert("Email must be filled out");
		  email.focus();
      return false;
    }

    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if(reg.test(email.value) == false) 
    {

      alert("Enter valid email.");
			email.focus();
			return false;

    }

    /*var i, j=0;
    for (i = 0; i < chks.length; i++)
    { 
      if (chks[i].checked == true){ 
          j=1;
      }
    }
    if(j == 0)
    {
      alert('Please select a role for user.');
      return false;
    } */

    return true;

}

</script>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Enter Users Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('member/admin');?>">Members List</a></li>
      <li class="breadcrumb-item">Add User</li>
    </ul>
    
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Information</h3>
        <?php if ($notice = $this->session->flashdata('notification')):?>
        <p></p>
          <p class="notice"><?php echo $notice;?></p>
        <?php endif;?>
        <p><?php echo validation_errors(); ?></p>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('member/admin/create')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">First Name*</label>
              <input class="form-control" type="text"  id="name" name="name"  value=""  placeholder="First name">
            </div>
            <div class="form-group">
              <label class="control-label">Last Name*</label>
              <input class="form-control" type="text"  id="lname" name="lname"  value=""  placeholder="Last name">
            </div>
            <div class="form-group">
              <label class="control-label">User ID*</label>
              <input class="form-control" type="text"  id="uniq_id" name="uniq_id"  value=""  placeholder="User Id">
            </div>
            <div class="form-group">
              <label class="control-label">Email*</label>
              <input class="form-control" name="email" value="" id="email"  type="email" placeholder="Enter email address">
            </div>
			      <div class="form-group">
              <label class="control-label">Phone</label>
              <input class="form-control" name="phone" value=""   type="text" placeholder="Enter Phone">
            </div>
            <div class="form-group">
              <label class="control-label">Assign Role</label> <br/>
              <select name="role" class="form-control" id="status">
              <?php for($i=0;$i<count($user_roles);$i++){ ?>
                <!--input type="checkbox" name="roles[]" value="<?php echo $user_roles[$i]['id']; ?>"> <?php echo $user_roles[$i]['type']; ?><br/-->
                <option value="<?php echo $user_roles[$i]['id']; ?>"><?php echo $user_roles[$i]['type']; ?></option>
              <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Status</label>
              <select name="status" class="form-control" id="status">
                <option selected='selected' value="1">Active</option>
                <option value="0">Disabled</option>
              </select>
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit" name="submit" value="Save" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
            <a class="btn btn-secondary" href="<?php echo site_url('member/admin');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>