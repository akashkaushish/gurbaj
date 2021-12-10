<script>

function validateForm() 
{
    var attribute_name = document.forms["myForm"]["attribute_name"];
    var chks = document.getElementsByName('roles[]');
    
    if (attribute_name.value == null || attribute_name.value.trim() == "") 
    {
      alert("Please enter attribute name.");
		  attribute_name.focus();
      return false;
    }
    var i, j=0;
    for (i = 0; i < chks.length; i++)
    { 
      if (chks[i].checked == true){ 
          j=1;
      }
    }
    if(j == 0)
    {
      alert('Please select a user role to assign.');
      return false;
    } 
    return true;

}

</script>
<!--change password-->
<?php if ($notice = $this->session->flashdata('notification')):?>

<p></p>
<p class="notice"><?php echo $notice;?></p>
<?php endif;?>
<p><?php echo validation_errors(); ?></p>
<div class="form-container">
  <div class="card p-4">
    <h2>Add Attribute</h2>
    <p>Add Attribute With Credentials :</p>
    <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('category/admin/createattribute')?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Attribute Name* </label>
        <input class="form-control" type="text"  id="attribute_name" name="attribute_name"  value=""  placeholder="Attribute name">
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Assign Role* </label>
        <br />
        <?php for($i=0;$i<count($user_roles);$i++){ ?>
        <input type="checkbox" name="roles[]" value="<?php echo $user_roles[$i]['id']; ?>">
        <?php echo $user_roles[$i]['type']; ?><br/>
        <?php } ?>
      </div>
      <div class="form-group text-center">
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
        <a href="<?php echo site_url('category/admin/orderattributes');?>">
        <button type="button" class="btn btn-secondary">Cancel</button>
        </a> </div>
    </form>
  </div>
</div>
<!--change password-->
