<script>

function validateForm() 
{
    var name = document.forms["myForm"]["name"];
    var logo = document.forms["myForm"]["logo"];
    
    if (name.value == null || name.value.trim() == "") 
    {
      alert("Please enter brand name.");
		  name.focus();
      return false;
    }
    if (logo.value == null || logo.value.trim() == "") 
    {
      alert("Please choose brand logo.");
		  logo.focus();
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
    <h2>Add Product</h2>
    <p>Add Your Product With Credentials :</p>
    <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php  echo site_url('member/admin/addadminbrand')?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Name* </label>
        <input class="form-control" type="text"  id="name" name="name"  value="<?php  echo $member['fname']?>"  placeholder="Brand name">
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Upload Brand Logo* </label>
        <div class="input-group mb-3">
          <div class="custom-file">
            <input  type="file" name="logo" class="custom-file-input" id="inputGroupFile01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>
      </div>
      <!-- <div class="form-group">
          <label for="exampleFormControlInput1">Status* </label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected>Active</option>
            <option value="1">Disabled</option>
            <option value="2">Active</option>
          </select>
        </div>-->
      <div class="form-group text-center">
        <button type="submit" class="btn btn-success">Submit</button>
        <a  href="<?php echo site_url('member/admin/brandlist');?>">
        <button type="button" class="btn btn-secondary">Cancel</button>
        </a> </div>
    </form>
  </div>
</div>
<script>
            $('#inputGroupFile01').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
				var cleanFileName = fileName.replace('C:\\fakepath\\', " ");
                $(this).next('.custom-file-label').html(cleanFileName);
            })
        </script>
<!--change password-->
<?php /*?><main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-btc"></i> Add New Brand</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('member/admin/brandlist');?>">Brand List</a></li>
      <li class="breadcrumb-item">Add New Brand</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add New Brand</h3>
        <?php if ($notice = $this->session->flashdata('notification')):?>
        <p></p>
        <p class="notice"><?php echo $notice;?></p>
        <?php endif;?>
        <p><?php echo validation_errors(); ?></p>
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php  echo site_url('member/admin/addadminbrand')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Name*</label>
              <input class="form-control" type="text"  id="name" name="name"  value="<?php  echo $member['fname']?>"  placeholder="Brand name">
            </div>
            <div class="form-group">
              <label class="control-label">Upload Logo*</label>
              <input class="form-control"  type="file" name="logo"  value="<?php  echo $member['lname']?>"  placeholder="Logo">
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit" name="submit" value="<?php  echo "Save";?>" class="btn btn-primary"> <i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
            <a class="btn btn-secondary" href="<?php echo site_url('member/admin/brandlist');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>
<?php */?>
