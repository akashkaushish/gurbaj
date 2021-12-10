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
<!-- Header -->
<div class="header bg-gradient-primary  pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
         <h2 class="text-white">Add Product's Brand</h2>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12">
                  <h4 class="mb-0">Add Your Brand With Credentials :</h4>
                </div>

              </div>
            </div>
      <div class="card-body">
        <?php if ($notice = $this->session->flashdata('notification')):?>
          <p></p>
          <p class="notice"><?php echo $notice;?></p>
        <?php endif;?>
        <p><?php echo validation_errors(); ?></p>
          <form onsubmit="return validateForm()" name="myForm" method="POST" enctype="multipart/form-data" action="<?php echo site_url('member/addbrand')?>">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-brandname">Name* </label>
                  <input type="text" name="name" class="form-control">
                </div>
              </div>
            </div>
                  
				  <div class="row">
					  <div class="col-lg-6">
                <div class="form-group">
                        <label class="form-control-label" for="input-first-name"> Upload Brand Logo* </label>
                <div class="input-group form-control-alternative">
                
                <div class="custom-file">
                  <input type="file" name="logo" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                  
                </div>
              </div>                      
              <div>Please upload jpeg, jpg, png & gif images only.</div>
              </div>
					  
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-title">Status * </label>
                  <select name="status" class="form-control" id="status">
                    <option selected='selected' value="1">Active</option>
                    <option value="0">Disabled</option>
                  </select>
              </div>
            </div>
          </div>

          </div>
            <div class="col-lg-12 text-left">
              <input type="submit" value= "Submit" class="btn btn-warning">
              <a href="<?php echo site_url('member/product_brands');?>" class="btn btn-primary">Cancel</a>
            </div>
				  </div>
               
        </form>
      </div>
    </div>	  
  </div>        
</div>