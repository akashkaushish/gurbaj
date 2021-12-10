<script>
function validateForm() 
{
    var category = document.forms["myForm"]["category"]; 
    if (category.value == null || category.value.trim() == "") 
    {
      alert("Please enter category name.");
		  category.focus();
      return false;
    }
    return true;

}

</script>

<div class="form-container">
  <div class="card p-4">
    <h2>Add Category</h2>
    <p>Add Your Category With Credentials :</p>
    <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('category/admin/create')?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Category Name* </label>
        <input class="form-control" type="text"  id="category" name="category"  value=""  placeholder="Category name">
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Status* </label>
        <select name="status" class="form-control" id="status">
          <option value='1' >
          <?php  echo "Active";?>
          </option>
          <option value='0'>
          <?php  echo "Disabled";?>
          </option>
        </select>
      </div>
      <div class="form-group text-center">
        <button  type="submit" name="submit" class="btn btn-success">Submit</button>
        <a href="<?php echo site_url('category/admin/listall');?>">
        <button type="button" class="btn btn-secondary">Cancel</button>
        </a> </div>
    </form>
  </div>
</div>
<!--change password-->
<?php /*?><main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Enter Category</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('member/admin');?>">Category List</a></li>
      <li class="breadcrumb-item">Add Category</li>
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
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('category/admin/create')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Category</label>
              <input class="form-control" type="text"  id="category" name="category"  value=""  placeholder="Category name">
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
            <a class="btn btn-secondary" href="<?php echo site_url('admin');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main><?php */?>
