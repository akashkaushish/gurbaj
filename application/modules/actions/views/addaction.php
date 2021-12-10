<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Add Action</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('actions/admin/');?>">Action List</a></li>
      <li class="breadcrumb-item">Add Action</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Action</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()"  enctype="multipart/form-data" name="myForm" action="<?php  echo site_url('actions/admin/saveimage')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
          <div class="form-group">
            <label class="control-label">Action Title</label>
            <input class="form-control" id="action_title" name="action_title" type='text' value='<?php echo set_value('action_title'); ?>'  />
          </div>
		   <div class="form-group">
            <label class="control-label">Action Information</label>
           <textarea class="form-control" name="action_information" ></textarea>
          </div>
          <div class="tile-footer">
            <button type="submit"  name="submit" value="<?php  echo "Save";?>" class="btn btn-primary" > <i class="fa fa-fw fa-lg fa-check-circle"></i>Save </button>
            <a class="btn btn-secondary" href="<?php echo site_url('actions/admin/listall');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>
