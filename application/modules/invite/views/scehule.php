<main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-th-list"></i> Scheduled Mails</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Scheduled Mails</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <a href="<?php  echo site_url('email/admin/addschedule/')?>" class="btn btn-primary float-right" style=""><i class="fa fa-fw fa-lg fa-plus"></i>Add New Schedule</a>
		<?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice float-left">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>

        <?php  if($mailtmp) : ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th width="12%"><?php  echo "Mail Template Subject"; ?></th>
              <th width="12%"><?php  echo "Event"; ?></th>
              <th width="12%"><?php  echo "Scheduled Date Time"; ?></th>
              <th width="12%"><?php  echo "Remark"; ?></th>
              <th width="12%"><?php  echo "Created Date Time"; ?></th>
              <th width="12%"><?php  echo "Status"; ?></th>
              <th width="12%"><?php  echo "Action"; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php  $i = 1; foreach ($mailtmp as $p): ?>
            <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
            <tr class="<?php  echo $rowClass?>">
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><?php  echo $this->db->get_where('mail', array('id'=>$p['mailtemp']))->row()->subject;?></td>
              <td><?php  echo $this->db->get_where('event', array('id'=>$p['event']))->row()->event;?></td>
              <td>
                <?php 
                  if(is_numeric($p['stime']))
                    echo $p['descr'];
                  else
                    echo $p['stime'];
                  ?>                  
              </td>
              <td><?php  echo $p['remark'];?></td>
              <td><?php  echo $p['created_date'];?></td>
              <td><?php  
                    if($p['status'] == 0)
                      echo 'Pending';
                    else
                      echo 'Sent';
              ?></td>
              <td><a href="<?php  echo site_url('email/admin/editschedule/'.$p['id']);?>" class="btn btn-sm btn-success" style="margin: 5px;">Edit</a><span class="btn btn-sm btn-danger dsconf" i="<?=$p['id']?>" style="margin: 5px;">Delete</span></td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
        <?php  else: ?>
        <?php  echo "No Templates found"; ?>
        <?php  endif ; ?>
        <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
          <ul class="pagination">
            <?php  //echo $pager;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
		function submitdata(){ 
			$(document).ready(function () {
			     $("#submit").click();
			});
		
		}
	</script>
