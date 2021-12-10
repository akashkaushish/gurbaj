<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Edit Body Type</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('bodies/admin/');?>">Body Type List</a></li>
      <li class="breadcrumb-item">Edit Body Type</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Edit Body Type</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('bodies/admin/editbody/'.$body_id)?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Body Title</label>
              <input id="body_title" name="body_title" type='text' value='<?php  echo $bodies['body_title']; ?>' class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label">Upload Body</label>
              <input type="file" name="body_image" id="body_image" class="form-control" />
              <?php  $imageName = $bodies['body_image'];?>
              <?php  if($imageName !="") { echo "<br><img src ='".base_url()."/media/bodyimage/".$imageName."' width='100px' height='100px'>";} ?>
            </div>
            <div class="form-group">
              <label class="control-label">Status</label>
              <select name="is_active" class="form-control" id="is_active">
                <option value='active' <?php  if ($bodies['is_active'] == 1):?>selected='selected' <?php  endif;?>>
                <?php  echo "Active"; ?>
                </option>
                <option value='disabled' <?php  if ($bodies['is_active'] == 0):?>selected='selected' <?php  endif;?>>
                <?php  echo "Disabled"; ?>
                </option>
              </select>
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit" name="submit" value="<?php  echo "Save";?>" class="btn btn-primary" > <i class="fa fa-fw fa-lg fa-check-circle"></i>Save </button>
            <a class="btn btn-secondary" href="<?php echo site_url('bodies/admin/');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>
<?php /*?><div class="container">
  <div class="content wide">
    <h1 id="settings">
      <?php  echo "Edit a Body"; ?>
    </h1>
    <form class="settings" name="myForm" action="<?php  echo site_url('bodies/admin/editbody/'.$body_id)?>" method="post" enctype="multipart/form-data">
      <ul>
        <li><a href="<?php  echo site_url('bodies/admin/listall')?>" class="input-submit last">
          <?php  echo "Cancel"; ?>
          </a></li>
      </ul>
      <br class="clearfloat" />
      <hr />
      <?php  echo validation_errors(); ?>
      <div class="control-group2">
        <label for="body_title">
        <?php  echo "Body Title*"; ?>
        : </label>
        <input id="body_title" name="body_title" type='text' value='<?php  echo $bodies['body_title']; ?>' class="input-text" />
      </div>
      <div class="control-group2">
        <label for="body_image">
        <?php  echo "Upload Body"; ?>
        :</label>
        <input type="file" name="body_image" id="body_image" class="input-text" />
        <?php  $imageName = $bodies['body_image'];?>
        <?php  if($imageName !="") { echo "<br><img src ='".base_url()."/media/bodyimage/".$imageName."' width='100px' height='100px'>";} ?>
      </div>
      <div class="control-group2">
        <label for="status">
        <?php  echo "Status"; ?>
        :</label>
        <select name="is_active" class="input-select" id="is_active">
          <option value='active' <?php  if ($bodies['is_active'] == 1):?>selected='selected' <?php  endif;?>>
          <?php  echo "Active"; ?>
          </option>
          <option value='disabled' <?php  if ($bodies['is_active'] == 0):?>selected='selected' <?php  endif;?>>
          <?php  echo "Disabled"; ?>
          </option>
        </select>
      </div>
      <div class="control-group2">
        <div class="control-group3">
          <input type="submit" name="submit" value="<?php  echo "Save"; ?>" class="input-submit" />
        </div>
      </div>
    </form>
  </div>
</div><?php */?>
<!-- [Content] end -->
