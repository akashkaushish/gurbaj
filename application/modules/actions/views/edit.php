<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Edit Actions</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('actions/admin/listall');?>">Action List</a></li>
      <li class="breadcrumb-item">Edit Actions</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Edit Action</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" name="myForm" action="<?php  echo site_url('actions/admin/edit/'.$action_id)?>" method="post" enctype="multipart/form-data">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Action Name</label>
              <input class="form-control" id="action_title" name="action_title" type='text' value='<?php echo $actiondata['action_title']; ?>'  />
            </div>
		
		   <div class="form-group">
            <label class="control-label">Action Information</label>
           <textarea class="form-control" name="action_information" ><?php echo $actiondata['action_information']; ?></textarea>
          </div>
		  
            <div class="form-group">
              <label class="control-label">Status</label>
              <select name="is_active" class="form-control" id="">
                <option value='1' <?php  if ($actiondata['is_active'] == '1'):?>selected='selected' <?php  endif;?>>
                <?php  echo "Active";?>
                </option>
                <option value='0' <?php  if ($actiondata['is_active'] == '0'):?>selected='selected' <?php  endif;?>>
                <?php  echo "Inactive";?>
                </option>
              </select>
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit"  name="submit" value="<?php  echo "Save";?>" class="btn btn-primary" > <i class="fa fa-fw fa-lg fa-check-circle"></i>Save </button>
            <a class="btn btn-secondary" href="<?php echo site_url('actions/admin/listall');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>
