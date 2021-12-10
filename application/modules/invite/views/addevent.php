<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Add New Event</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('email/admin/events');?>">Events List</a></li>
      <li class="breadcrumb-item">Add New Event</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add New Event</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('email/admin/addevent')?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Event Name</label>
              <input class="form-control" name="eventname" type="text" value="" />
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit"  name="savesche" value="<?php  echo "Save";?>" class="btn btn-primary" >
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
            </button>
            <a class="btn btn-secondary" href="<?php echo site_url('email/admin/events');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>  
  </div>
</main>