<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Edit Schedule</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('email/admin/scehule');?>">Schedule List</a></li>
      <li class="breadcrumb-item">Edit Schedule</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Edit Schedule</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('email/admin/updateschedule')?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Select Mail Template</label>
              <select class="form-control" name="mailtemplate">
                <?php 
                  $d = $this->db->query('SELECT * FROM ci_mail')->result_array();
                  foreach ($d as $e) {
                ?>
                  <option value="<?=$e['id']?>" <?php if($e['id'] == $m['mailtemp']) echo 'selected="selected"'; ?>><?=$e['subject']?></option>
                <?php
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Select Event</label>
              <select class="form-control" name="event">
                <?php 
                  $d = $this->db->query('SELECT * FROM ci_event')->result_array();
                  foreach ($d as $e) {
                ?>
                  <option value="<?=$e['id']?>" <?php if($e['id'] == $m['event']) echo 'selected="selected"'; ?>><?=$e['event']?></option>
                <?php
                  }
                ?>
              </select>
            </div>   



            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label class="control-label">Select Date And Time</label>
                  <div class="input-append date form_datetime">
                    <input class="form-control" name="datetime" type="text" value="<?php 
                                                                                      if(!is_numeric($m['stime'])) 
                                                                                        echo $m['stime'];
                                                                                      else
                                                                                        echo '';
                                                                                      ?>" placeholder="Click to Select Date & Time">
                    <span class="add-on"><i class="icon-th"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label" style="margin-top: 12px;margin-left: 45px;font-weight: bold;font-size: 35px;color: green;">OR</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label class="control-label">Select Days Frequency</label>
                  <select class="form-control" name="days">
                    <option value="0">Select Days Frequency</option>
                    <?php
                      for($k = 1;$k <= 30;$k++) {
                    ?>
                      <option value="<?=$k?>" <?php if($k == $m['stime']) echo 'selected="selected"'; ?>><?=$k?> Days</option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <p style="color: blue;margin-top: -14px;">Please select one of them, if Date and Time selected then Days frequency ignored.</p>
              </div>
            </div>

            <div class="row" style="margin-top: 25px;margin-bottom: 25px;">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Repeat This Frequency Every Time</label>
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <input type="checkbox" name="repeat" class="form-control" />
                </div>
              </div>
              <div class="col-md-8"></div>
            </div>

  
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Select Users <span id="clear" style="text-decoration: underline;cursor: pointer;color: red;">Clear Selection</span></label>
                  <select class="form-control" id="deselect" name="users[]" multiple style="height: 300px;">
                    <?php 
                      $ar = explode(',', $m['usermails']);
                      $d = $this->db->query('SELECT * FROM ci_users')->result_array();
                      $i = 1;
                      foreach ($d as $e) {
                    ?>
                      <option value="<?=$e['email']?>" <?php if(in_array($e['email'], $ar)) echo 'selected="selected"'; ?>><?=$i?>) <?=$e['name']?> ( <?=$e['email']?> )</option>
                    <?php
                      $i++;
                      }
                    ?>
                  </select>
                  <input type="hidden" id="para" name="para" value="<?=$m['id']?>">
                </div>
              </div>
              <div class="col-md-12">
                <p style="color: blue;margin-top: -14px;">If you do not select any user then this action will apply every new user onwards.</p>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Remark</label>
              <textarea class="form-control" style="height: 200px;" name="remark"><?=$m['remark']?></textarea>
            </div>
          <div class="tile-footer">
            <button type="submit"  name="savesche" value="<?php  echo "Save";?>" class="btn btn-primary" >
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Update
            </button>
            <a class="btn btn-secondary" href="<?php echo site_url('email/admin/scehule');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>