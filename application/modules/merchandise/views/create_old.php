<!-- [Left menu] start -->
<!--div class="leftmenu">

	<h1 id="pageinfo"><?php  echo __("Navigation", $module)?></h1>
	
	<ul id="tabs" class="quickmenu">
		<li><a href="#one">General settings</a></li>
	</ul>
	<div class="quickend"></div>

</div-->
<!-- [Left menu] end -->

<!-- [Content] start -->
<script>
function validateForm() {
var first_name = document.forms["myForm"]["first_name"];
var last_name = document.forms["myForm"]["last_name"];
var email = document.forms["myForm"]["email"];
var password = document.forms["myForm"]["password"];;
//var id_number = document.forms["myForm"]["id_number"];

    if (first_name.value == null || first_name.value == "") {
        alert("First name must be filled out");
		first_name.focus();
        return false;
    }
	 if (last_name.value == null || last_name.value == "") {
        alert("Last name must be filled out");
		last_name.focus();
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
	
	
	 if (password.value == null || password.value == "") {
        alert("Password must be filled out");
		password.focus();
        return false;
    }

	/* if (id_number.value == null || id_number.value == "") {
        alert("Id number must be filled out");
		id_number.focus();
        return false;
    }*/
    return true;
	}
</script>
<div class="content slim">

<h1 id="settings"><?php  echo __("Add a user", $module)?></h1>



<form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('admin/member/create')?>" method="post" accept-charset="utf-8">
		
		<ul>
			<li><input type="submit" name="submit" value="<?php  echo __("Save", $module)?>" class="input-submit" /></li>
			<li><a href="<?php  echo site_url('admin/member/listall')?>" class="input-submit last"><?php  echo __("Cancel", $module)?></a></li>
		</ul>
		
		<br class="clearfloat" />

		<hr />
		<?php  echo validation_errors(); ?>
		<div id="one">
		
			<label for="first_name"><?php  echo __("First Name*", $module)?>: </label>
			<input id="first_name" name="first_name" type='text' value='<?php echo set_value('first_name'); ?>' class="input-text" />
			<br />
			<label for="last_name"><?php  echo __("Last Name*", $module)?>: </label>
			<input id="last_name" name="last_name" type='text' value='<?php echo set_value('last_name'); ?>' class="input-text" />
			<br />
			<label for="email"><?php  echo __("Email*", $module)?>:</label>
			<input type="text" name="email" value="<?php  echo set_value('email');?>" id="email" class="input-text" /><br />
			
			<label for="password"><?php  echo __("Password*", $module)?>:</label>
			<input type="text" name="password" value="wmg" id="password" class="input-text" readonly /><br />

			
			<?php /*?><label for="id_number"><?php  echo __("ID Number", $module)?>:</label>
			<input type="text" name="id_number" value="<?php  echo set_value('id_number');?>" id="id_number" class="input-text" /><br /><?php */?>
						
		</div>
	</form>
<script>

  $(document).ready(function(){
    $("#tabs").tabs();
  });

</script>
</div>
<!-- [Content] end -->
