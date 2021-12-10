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
    <h2>Add Product's Brand</h2>
    <p>Add Your Brand With Credentials :</p>
    <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php  echo site_url('member/addbrand')?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Name* </label>
        <input class="form-control" type="text"  type="text" name="name"  placeholder="Brand name">
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
      <div class="form-group">
          <label for="exampleFormControlInput1">Status* </label>
          <select class="custom-select mr-sm-2" name="status" id="inlineFormCustomSelect">
            <option value="1" selected>Active</option>
            <option value="0">Disabled</option>
            
          </select>
        </div>
      <div class="form-group text-center">
        <button type="submit" value= "Submit" class="btn btn-success">Submit</button>
        <a  href="<?php echo site_url('member/product_brands');?>">
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

