<main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-th-list"></i> Action Administration</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Action List</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">&nbsp;&nbsp; &nbsp;<a href="<?php  echo site_url('actions/admin/addaction')?>" style="margin-left:10px;" class="btn btn-primary float-right"><i class="fa fa-fw fa-lg fa-plus"></i>Add New Action</a>&nbsp;&nbsp; &nbsp; <br />
        <br />
        &nbsp;
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice float-left">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <?php  if($actions) : ?>
        <table class="table table-hover table-bordered" id="">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th width="25%"><?php  echo "Action Title"; ?></th>
			  <th width="25%"><?php  echo "Action Information"; ?></th>
              <th width="12%"><?php  echo "Is Active"; ?></th>
              <th width="12%"><?php  echo " Created Date"; ?></th>
              <th colspan="2" width="15%"><?php echo "Action";?></th>
            </tr>
          </thead>
          <tbody>
            <?php 
					$i = 1; 
					foreach ($actions as $actionsData): 
             ?>
            <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
            <tr class="<?php  echo $rowClass?>">
              <td class="center"><?php  echo ($i) ?></td>
              <td><?php  echo $actionsData['action_title'];?></td>
			  <td><?php if(strlen($actionsData['action_information']) > 90){ }else{echo $actionsData['action_information'];}?></td>
              <td><?php  if($actionsData['is_active']==1){ echo "Active";}else{ echo "Inactive";}?></td>
              <td><?php  echo $actionsData['created_date'];?></td>
              <td><a href="<?php echo site_url($module.'/admin/edit/'.$actionsData['action_id'])?>"><?php echo "Edit";?></a></td>
              <td><a onclick="return confirm('Are you sure to delete?');" href="<?php echo site_url($module.'/admin/deleteaction/'.$actionsData['action_id'])?>">
                <?php  echo "Delete";?>
                </a></td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
        <?php  else: ?>
        <table class="table table-hover table-bordered" id="">
          <thead>
            <tr>
               <th width="3%" class="center">#</th>
              <th width="20%"><?php  echo "Action Title"; ?></th>
              <th width="20%"><?php  echo "Action Information"; ?></th>
              <th width="20%"><?php  echo "Created Date"; ?></th>
              <th colspan="2" width="20%"><?php echo "Action";?></th>
            </tr>
          </thead>
          <tbody>
            <tr class="<?php  echo $rowClass?>">
              <td colspan="5">No Action Found </td>
            </tr>
          </tbody>
        </table>
        <?php  endif ; ?>
        <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
          <ul class="pagination">
            <?php  echo $pager;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>