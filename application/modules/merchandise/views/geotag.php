<main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-th-list"></i> Geotag Administration</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Geotag List</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <?php  if($geotag) : ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th width="15%"><?php  echo "Product ID"; ?></th>
              <th width="20%"><?php  echo "Plan"; ?></th>
              <th width="15%"><?php  echo "Price"; ?></th>
              <th width="15%"><?php  echo "Date"; ?></th>
              <th width="10%"><?php  echo "Edit"; ?></th>
			  <th width="10%"><?php  echo "Delete"; ?></th>
            </tr>
          </thead>
          <tbody>
        <?php  $i = 1; foreach ($geotag as $p): ?>
        <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
        <tr class="<?php  echo $rowClass?>">
          <td class="center"><?php  echo ($i + $start) ?></td>
          <td><?php  echo $p['product_id'];?></td>
          <td><?php  echo $p['name'];?></td>
          <td><?php  echo $p['price']?></td>
          <td><?php  echo $p['created_date'];?></td>
          <td><a href="<?php  echo site_url($module.'/admin/editgeotags/'.$p['id'])?>">
            <?php  echo "Edit"; ?>
            </a></td>
          <td><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deletegeotags/'.$p['id'])?>">
            <?php  echo "Delete"; ?>
            </a></td>
        </tr>
        <?php  $i++; endforeach;?>
      </tbody>
        </table>
        <?php  else: ?>
        <?php  echo "No Purchase found"; ?>
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
<?php /*?><div class="container">
  <div class="content wide">
    <h1 id="page">
      <p style="float: left">
        <?php  echo "Packages" ;?>
      </p>
      <p style="float: right;"><a href="<?php  echo site_url('merchandise/admin/addgeotags')?>">
        <?php  echo "Add New Geotag Plan" ;?>
        </a></p>
    </h1>
    <br class="clearfloat" />
    <hr />
    <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice">
      <?php  echo $notice;?>
    </p>
    <?php  endif;?>
    <table style="width:100%">
      <form action="<?php  echo site_url($this->uri->uri_string()) ?>" method="post" name="myform" class="myform" >
        <tr>
          <td></td>
          <td width="20%"><input type="text" class="input-text" name="filter" value="<?php  echo $this->input->post('filter') ?>" />
          </td>
          <td><input type="submit" class="input-submit" id="submit" name="submit" value="<?php  echo "Search"; ?>" />
          </td>
          <td align="right"><select name="sorting" onchange="javascript:submitdata();">
              <option value="" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='')){?>selected<?php }?>>Sort Data</option>
              <option value="registered" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='registered')){?>selected<?php }?>>By Register Date</option>
              <option value="name" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='name')){?>selected<?php }?>>By Name</option>
            </select>
          </td>
        </tr>
      </form>
    </table>
    <?php  if($geotag) : ?>
    <table class="page-list">
      <thead>
        <tr>
          <th width="3%" class="center">#</th>
          <th width="15%"><?php  echo "Product ID"; ?></th>
          <th width="20%"><?php  echo "Plan"; ?></th>
          <th width="15%"><?php  echo "Price"; ?></th>
          <th width="15%"><?php  echo "Date"; ?></th>
          <th width="30%" colspan="2"><?php  echo "Action"; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php  $i = 1; foreach ($geotag as $p): ?>
        <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
        <tr class="<?php  echo $rowClass?>">
          <td class="center"><?php  echo ($i + $start) ?></td>
          <td><?php  echo $p['product_id'];?></td>
          <td><?php  echo $p['name'];?></td>
          <td><?php  echo $p['price']?></td>
          <td><?php  echo $p['created_date'];?></td>
          <td><a href="<?php  echo site_url($module.'/admin/editgeotags/'.$p['id'])?>">
            <?php  echo "Edit"; ?>
            </a></td>
          <td><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deletegeotags/'.$p['id'])?>">
            <?php  echo "Delete"; ?>
            </a></td>
        </tr>
        <?php  $i++; endforeach;?>
      </tbody>
    </table>
    <?php  else: ?>
    <?php  echo "No member found"; ?>
    <?php  endif ; ?>
  </div>
</div>
<script>
		function submitdata(){ 
			$(document).ready(function () {
			     $("#submit").click();
			});
		
		}
	</script>
<?php */?>
