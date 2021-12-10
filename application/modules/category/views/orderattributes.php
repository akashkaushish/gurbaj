<div class="annual-sales brands-list">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice" style="clear:both;">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <div class="head">
    <h2 class="d-inline-block">  Order Attributes List</h2>
    <a href="<?php  echo site_url($module.'/admin/createattribute')?>" class="btn btn-success float-right">Create Attribute</a></div>
  <div class="table-responsive">
    <?php  if($attributes) : ?>
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Status</th>
          <th scope="col">Attribute Name</th>
          <th scope="col">Created on</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php  $i = 1; foreach ($attributes as $category): ?>
        <tr class="<?php  echo $rowClass?>">
          <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
          <td class="center"><?php  echo ($i + $start) ?></td>
          <td><?php  if($category['is_active'] == 1) { echo "Active"; }else{ echo "Disabled"; } ?></td>
          <td><?php  echo $category['attribute_name'];?></td>
          <td><?php  echo $category['date_created']?></td>
          <td><div class="btn-group">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Choose.. </button>
              <div class="dropdown-menu"> <a class="dropdown-item" href="<?php  echo site_url($module.'/admin/editattribute/'.$category['id'])?>">Edit</a> <a class="dropdown-item"  onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteattribute/'.$category['id'])?>">Delete</a> </div>
            </div></td>
        </tr>
        <?php  $i++; endforeach;?>
      </tbody>
    </table>
    <?php  else: ?>
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Status</th>
          <th scope="col">Category</th>
          <th scope="col">Created on</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">No Category Found</td>
        </tr>
      </tbody>
    </table>
    <?php  endif ; ?>
  </div>
</div>
<?php /*?><main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-users"></i> Order Attributes List</h1>
  </div>
  <div><a class="btn btn-primary" href="<?php  echo site_url($module.'/admin/createattribute')?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Create Attribute</a></div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Attribute List</li>
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
        <?php  if($attributes) : ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th width="25%"><?php  echo "Attribute"; ?></th>
              <th width="20%"><?php  echo "Status"; ?></th>
              <th width="20%"><?php  echo "Created on"; ?></th>
              <th width="5%" >Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $i = 1; foreach ($attributes as $category): ?>
            <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
            <tr class="<?php  echo $rowClass?>">
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><?php  echo $category['attribute_name'];?></td>
              <td><?php  if($category['is_active'] == 1) { echo "Active"; }else{ echo "Disabled"; } ?></td>
              <td><?php  echo $category['date_created']?></td>
              <td><a href="<?php  echo site_url($module.'/admin/editattribute/'.$category['id'])?>">
                <?php  echo "Edit"; ?>
                </a></td>
              <td><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteattribute/'.$category['id'])?>">
                <?php  echo "Delete"; ?>
                </a></td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
        <?php  else: ?>
        <?php  echo "No Attribute found"; ?>
        <?php  endif ; ?>
        <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
          <ul class="pagination">
            <?php  //echo $pager;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>