<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Profile Image</h6>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <!--  <div class="col">
            <h3 class="text-white mb-0">For sake of security, change your password by time.</h3>
          </div>-->
        </div>
      </div>
      <div class="card-body">
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
        <div class="alert alert-success">
          <?php  echo $success;?>
        </div>
        <?php  endif;?>
        <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
        <div class="alert alert-danger">
          <?php  echo $error;?>
        </div>
        <?php  endif;?>
        <form class="form-horizontal" method="POST" action="<?php echo site_url('member/editprofileimage');?>" enctype="multipart/form-data" >
          <div class="form-row">
            <div class="col-md-6 mb-6">
              <label class="form-control-label">Upload Your Image*</label>
              <input type="file" name="Image" placeholder="First Name" value="<?php //echo $userdetail['fname'];?>" class="form-control input-solid" required>
              <div class="valid-feedback"> Looks good! </div>
            </div>
		
            </div>
			
			 <div class="form-row">
           
            <div class="col-md-4 mb-3">
              <?php if($_SESSION['photo'] && ($_SESSION['photo'] !='')){?>
			<img src="<?php echo base_url()?>media/thumb/<?php echo $_SESSION['photo'];?>" alt="" width="150px;"> 
		<?php }?> 
            </div>
			<br />
            <div class="col-md-12">
              <button class="btn btn-primary" type="submit" name="submit" value="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
