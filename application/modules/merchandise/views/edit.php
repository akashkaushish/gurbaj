
<script>
function validateForm() {
var first_name = document.forms["myForm"]["name"];
//var last_name = document.forms["myForm"]["last_name"];
var email = document.forms["myForm"]["email"];

//var id_number = document.forms["myForm"]["id_number"];

    if (first_name.value == null || first_name.value == "") {
        alert("First name must be filled out");
		first_name.focus();
        return false;
    }
	
	 if (email.value == null || email.value == "") {
        alert("Email must be filled out");
		email.focus();
        return false;
    }
	
		
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			 	
             if(reg.test(email.value) == false) {
                   alert("Enter valid email");
					email.focus();
					return false;
              }
	
	
    return true;
	}
</script>
<div class="content slim">
<div class="container">


<h1 id="settings"><?php  echo "Edit a user";?></h1>



<form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('member/admin/edit/'.$user_id)?>" method="post" accept-charset="utf-8">
		
		<ul>
			<li><input type="submit" name="submit" value="<?php  echo "Save";?>" class="input-submit" /></li>
			<li><a href="<?php  echo site_url('admin/member/listall')?>" class="input-submit last"><?php  echo "Cancel";?></a></li>
		</ul>
		
		<br class="clearfloat" />

		<hr />
		<?php  echo validation_errors(); ?>
		<div id="one">
		
			<label for="name"><?php  echo "Name*";?>: </label>
			<input id="name" name="name" type='text' value='<?php  echo $member['name']?>' class="input-text" />
			<br>
			<label for="email"><?php  echo "Email*";?>:</label>
			<input type="text" name="email" value="<?php  echo $member['email'];?>" id="email" class="input-text" /><br />
			
			<label for="status"><?php  echo "Status";?>:</label>
				<select name="status" class="input-select" id="status">
					<option value='active' <?php  if ($member['status'] == 'active'):?>selected='selected' <?php  endif;?>><?php  echo "Active";?></option>
					<option value='disabled' <?php  if ($member['status'] == 'disabled'):?>selected='selected' <?php  endif;?>><?php  echo "Disabled";?></option>
				</select><br />

					
		</div>
	</form>
<script>

  $(document).ready(function(){
    $("#tabs").tabs();
  });

</script>
</div>

</div>
	</div>
<!-- [Content] end -->
