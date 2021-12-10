<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Add Sound Category</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('audio/admin/adcategorylist');?>">Sound Category List</a></li>
      <li class="breadcrumb-item">Add Sound Category</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Sound Category</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('audio/admin/createadcat')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Name</label>
              <input id="category_title" name="name" type='text' value='<?php echo set_value('category_title'); ?>' class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label">Description</label>
              <textarea id="short_description" name="short_description"  rows="5" cols="15" class="form-control" ><?php  echo set_value('short_description');?>
</textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Full Description</label>
              <textarea id="description" name="description"  rows="5" cols="15" class="form-control" ><?php  echo set_value('description');?>
</textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Image</label>
              <input id="category_image" name="category_image" type='file' class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label">Is Active</label>
              <select name="is_active" class="form-control">
                <?php foreach($is_active as $key=>$title){
			   echo "<option value='".$key."'>".$title."</option>";
			}?>
              </select>
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit" name="submit" value="<?php  echo "Save";?>" class="btn btn-primary" > <i class="fa fa-fw fa-lg fa-check-circle"></i>Save </button>
            <a class="btn btn-secondary" href="<?php echo site_url('audio/admin/adcategorylist');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>
<?php /*?><div class="content slim">
  <h1 id="settings">
    <?php  echo "Add Sound Category"; ?>
  </h1>
  <?php
    $is_active = array("0"=>"No","1"=>"Yes");
 ?>
  <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('audio/admin/createadcat')?>" method="post" enctype="multipart/form-data">
    <ul>
      <li>
        <input type="submit" name="submit" value="<?php  echo "Save"; ?>" class="input-submit" />
      </li>
      <li><a href="<?php  echo site_url('audio/admin/adcategorylist')?>" class="input-submit last">
        <?php  echo "Cancel"; ?>
        </a></li>
    </ul>
    <br class="clearfloat" />
    <hr />
    <?php  echo validation_errors(); ?>
    <div id="one">
      <label for="category_title">
      <?php  echo "Name*"; ?>
      : </label>
      <input id="category_title" name="name" type='text' value='<?php echo set_value('category_title'); ?>' class="input-text" />
      <br>
      <label for="short_description">
      <?php  echo "Description*"; ?>
      : </label>
      <textarea id="short_description" name="short_description"  rows="5" cols="15" class="input-text" ><?php  echo set_value('short_description');?>
</textarea>
      <br>
      <label for="description">
      <?php  echo "Full Description*"; ?>
      : </label>
      <textarea id="description" name="description"  rows="5" cols="15" class="input-text" ><?php  echo set_value('description');?>
</textarea>
      <br>
      <label for="category_image">
      <?php  echo "Image*"; ?>
      : </label>
      <input id="category_image" name="category_image" type='file' class="input-text" />
      <br>
      <label for="is_active">
      <?php  echo "Is Active"; ?>
      :</label>
      <select name="is_active">
        <?php foreach($is_active as $key=>$title){
			   echo "<option value='".$key."'>".$title."</option>";
			}?>
      </select>
      <br />
    </div>
  </form>
</div>
<?php */?>
