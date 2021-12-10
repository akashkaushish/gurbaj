<!--annual sale-->

<div class="annual-sales brands-list">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice" style="clear:both;">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <div class="head">
    <h2 class="d-inline-block">Users List</h2>
    <div class="float-right">
      <form class="form-inline float-left mr-3" method="post" action="<?php  echo site_url('member/admin/listall') ?>">
        <input class="form-control mr-sm-2" type="search" name="mfilter" value="<?php echo $mfilter;?>" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
    <!--<a href="add-newbrand.html" class="btn btn-success float-right">Add New Brands</a> -->
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Type</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php  $i = 1; foreach ($members as $member): ?>
        <tr>
          <td class="center"><?php  echo ($i + $start) ?></td>
          <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
          <td><?php  echo $member['email']?></td>
          <td><?php  echo $member['phone'];?></td>
          <td><?php  echo $this->user->get_user_type($member['type_id']);?></td>
          <td><?php if($member['is_active'] == 1){ echo "Active"; }else{ echo "Disabled"; } ?></td>
          <td><div class="btn-group">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Choose.. </button>
              <div class="dropdown-menu"> <a class="dropdown-item" href="<?php  echo site_url($module.'/admin/edit/'.$member['id'])?>">Edit</a> <a class="dropdown-item" onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteuser/'.$member['id'])?>">Delete</a> </div>
            </div></td>
        </tr>
        <?php  $i++; endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="dataTables_paginate paging_simple_numbers float-right" id="sampleTable_paginate">
    <ul class="pagination">
      <?php  echo $pager;?>
    </ul>
  </div>
</div>
<!--annual sale-->
<?php /*?><main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-users"></i> Users List</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Users List</li>
  </ul>
</div>
<?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
<p class="notice" style="clear:both;">
  <?php  echo $notice;?>
</p>
<?php  endif;?>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <?php  if($members) : ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th width="15%"><?php  echo "Name"; ?></th>
              <th width="20%"><?php  echo "Email"; ?></th>
              <th width="15%"><?php  echo "Phone"; ?></th>
              <th width="15%"><?php  echo "Type"; ?></th>
              <th width="5%" ><?php  echo "Edit"; ?></th>
              <th width="5%"><?php  echo "Delete"; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php  $i = 1; foreach ($members as $member): ?>
            <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
            <tr class="<?php  echo $rowClass?>">
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
              <td><?php  echo $member['email']?></td>
              <td><?php  echo $member['phone'];?></td>
              <td><?php  echo $member['type_id'];?></td>
              <td><a href="<?php  echo site_url($module.'/admin/edit/'.$member['id'])?>">
                <?php  echo "Edit"; ?>
                </a></td>
              <td><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteuser/'.$member['id'])?>">
                <?php  echo "Delete"; ?>
                </a></td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
        <?php  else: ?>
        <?php  echo "No user found"; ?>
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
<?php */?>
