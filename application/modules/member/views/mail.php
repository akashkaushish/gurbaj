<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Add Email Templates</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('member/admin/mails');?>">Templates List</a></li>
      <li class="breadcrumb-item">Add Email Template</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Email Template</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('member/admin/addmails')?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Subject</label>
              <input class="form-control" type="text" name="subject"  />
            </div>
            <div class="form-group">
              <label class="control-label">Body</label>
              <textarea class="form-control" name="body"></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Attachment</label>
              <input class="form-control" type="file" name="attachment"  />
            </div>
            <div class="form-group">
              <label class="control-label">Select Event</label>
              <select class="form-control" name="event">
                <?php 
                  $d = $this->db->query('SELECT * FROM ci_event')->result_array();
                  foreach ($d as $e) {
                ?>
                  <option value="<?=$e['id']?>"><?=$e['event']?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          <div class="tile-footer">
            <button type="submit"  name="savemail" value="<?php  echo "Save";?>" class="btn btn-primary" >
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
            </button>
            <a class="btn btn-secondary" href="<?php echo site_url('member/admin/mails');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>