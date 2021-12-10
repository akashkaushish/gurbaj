<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Edit Email Templates</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('email/admin/mails');?>">Templates List</a></li>
      <li class="breadcrumb-item">Edit Email Template</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Edit Email Template</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('email/admin/updatemails')?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Subject</label>
              <input class="form-control" type="text" name="subject" value="<?=$m['subject']?>" />
            </div>
            <div class="form-group">
              <label class="control-label">Body</label>
              <textarea class="form-control" name="body"><?=$m['body']?></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Attachment</label>
              <input class="form-control" type="file" name="attachment" />
              <a href="<?=$m['attachment']?>" target="_blank"><?=$m['attachment']?></a>
              <input class="form-control" type="hidden" name="att" value="<?=$m['attachment']?>" />
            </div>
            <div class="form-group">
              <label class="control-label">Select Event</label>
              <select class="form-control" name="event">
                <?php 
                  $d = $this->db->query('SELECT * FROM ci_event')->result_array();
                  foreach ($d as $e) {
                ?>
                  <option value="<?=$e['id']?>" v="<?=$ep?>" <?php if($e['id'] == $m['event']) echo 'selected="selected"';?>><?=$e['event']?></option>
                <?php
                  }
                ?>
              </select>
              <input type="hidden" id="para" name="para" value="<?=$m['id']?>">
            </div>
          <div class="tile-footer">
            <button type="submit"  name="savemail" value="<?php  echo "Save";?>" class="btn btn-primary" >
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Update
            </button>
            <a class="btn btn-secondary" href="<?php echo site_url('email/admin/mails');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>