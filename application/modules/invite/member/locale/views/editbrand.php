<script>

function validateForm() 
{
    var name = document.forms["myForm"]["name"];

    
    if (name.value == null || name.value.trim() == "") 
    {
      alert("Please enter brand name.");
		  name.focus();
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
    <h2>Edit Product Brand</h2>
    <p>Edit Your Product Brand With Credentials :</p>
    <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/editbrand/'.$brand_id)?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label for="exampleFormControlInput1">Name* </label>
        <input class="form-control" type="text"  id="name" name="name"  value="<?php  echo $brand['name']?>"  placeholder="Brand name">
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Upload Brand Logo* </label>
        <div class="input-group mb-3">
          <div class="custom-file">
            <input  type="file" name="logo" class="custom-file-input" id="inputGroupFile01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
		   
        </div><br />
				  <?php if($brand['logo'] !=''){?>
					<img alt="Image placeholder" src="<?php echo base_url()?>media/brand/<?php echo $brand['logo']; ?>" width="200px;">
				  <?php }?>
      </div>
       <div class="form-group">
          <label for="exampleFormControlInput1">Status* </label>
          <select name="status" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected='selected' value="1" <?php  if ($brand['is_active'] == 1):?>selected='selected' <?php  endif;?> >Active</option>
            <option value="0" <?php  if ($brand['is_active'] == 0):?>selected='selected' <?php  endif;?> >Disabled</option>
          </select>
        </div>
      <div class="form-group text-center">
        <button type="submit" value= "Submit" class="btn btn-success">Submit</button>
        <a href="<?php echo site_url('member/product_brands');?>">
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

