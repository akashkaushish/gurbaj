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
<?php if ($notice = $this->session->flashdata('notification')):?>

<p></p>
<p class="notice"><?php echo $notice;?></p>
<?php endif;?>
<p><?php echo validation_errors(); ?></p>
<div class="form-container">
  <div class="card p-4">
    <h2>Edit Attribute</h2>
    <p>Edit Attribute With Credentials :</p>
     <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('category/admin/editattribute/'.$attribute['id'])?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Attribute Name* </label>
      <input class="form-control" type="text"  id="attribute_name" name="attribute_name"  value="<?php echo $attribute['attribute_name']; ?>"  placeholder="Attribute name">
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Assign Role* </label>
        <br />
        <?php $selectedroles = explode(",", $attribute['permit_user_type']);  ?>
              <?php for($i=0;$i<count($user_roles);$i++){ ?>
              <input type="checkbox" name="roles[]" <?php if(in_array($user_roles[$i]['id'], $selectedroles)){ ?> checked <?php } ?> value="<?php echo $user_roles[$i]['id']; ?>"> <?php echo $user_roles[$i]['type']; ?><br/>
               
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

<?php /*?><main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Enter Attribute</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('category/admin/orderattributes');?>">Attribute List</a></li>
      <li class="breadcrumb-item">Add Attribute</li>
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
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('category/admin/editattribute/'.$attribute['id'])?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Attribute Name</label>
              <input class="form-control" type="text"  id="attribute_name" name="attribute_name"  value="<?php echo $attribute['attribute_name']; ?>"  placeholder="Attribute name">
            </div>
            
            <div class="form-group">
              <label class="control-label">Assign Role</label> <br/>
             <?php $selectedroles = explode(",", $attribute['permit_user_type']);  ?>
              <?php for($i=0;$i<count($user_roles);$i++){ ?>
              <input type="checkbox" name="roles[]" <?php if(in_array($user_roles[$i]['id'], $selectedroles)){ ?> checked <?php } ?> value="<?php echo $user_roles[$i]['id']; ?>"> <?php echo $user_roles[$i]['type']; ?><br/>
               
              <?php } ?>
             
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit" name="submit" value="Save" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
            <a class="btn btn-secondary" href="<?php echo site_url('admin');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main><?php */?>