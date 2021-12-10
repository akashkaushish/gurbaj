<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Add Asset Bundle</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('asset/admin/');?>">Asset Bundles</a></li>
      <li class="breadcrumb-item">Add Asset Bundle</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Asset Bundle</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('asset/admin/saveasset')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Asset Name</label>
            <input class="form-control" id="name" name="name" type='text' />
            </div>
            <div class="form-group">
              <label class="control-label">Asset URL</label>
            <input class="form-control" id="url" name="url" type='text'/>
            </div>
            <div class="form-group">
              <label class="control-label">Asset Device</label>
              <select class="form-control" id="device" name="device">
                <option value="android">Android</option>
                <option value="webgl">WebGL</option>
                <option value="ios">iOS</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Asset Version</label>
            <input class="form-control" id="version" name="version" type='text'/>
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit" name="submit" value="<?php  echo "Save";?>" class="btn btn-primary" > <i class="fa fa-fw fa-lg fa-check-circle"></i>Save </button>
            <a class="btn btn-secondary" href="<?php echo site_url('asset/admin/');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>