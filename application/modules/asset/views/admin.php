<main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-th-list"></i> Asset Bundles</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Bundles List</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body"> <a href="<?php  echo site_url('asset/admin/creatbundle')?>" class="btn btn-primary float-right"><i class="fa fa-fw fa-lg fa-plus"></i>Add Asset Bundle</a>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice float-left">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <?php  if($asset) : ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th><?php  echo "Name";?></th>
              <th><?php  echo "URL";?></th>
              <th width="8%"><?php  echo "Device";?></th>
              <th width="10%"><?php  echo "Version";?></th>
              <th width="10%"><?php  echo "Created Date";?></th>
              <th width="10%"><?php  echo "Action";?></th>
            </tr>
          </thead>
          <tbody>
            <?php 
$i = 1; foreach ($asset as $a):
?>
            <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
            <tr class="<?php  echo $rowClass?>">
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><?php  echo $a['name'];?></td>
              <td><?php  echo $a['url'];?></td>
              <td><?php  echo $a['device'];?></td>
              <td><?php  echo $a['version'];?></td>
              <td><?php  echo $a['created_date'];?></td>
              <td><a href="<?php  echo site_url($module.'/admin/editasset/'.$a['id'])?>">Edit</a><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteasset/'.$a['id'])?>">
                <?php  echo "Delete";?>
                </a></td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
        <?php  else: ?>
        <?php  echo "No body type found"; ?>
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
<?php /*?><div class="container">
  <div class="content wide">
    <h1 id="page">
      <?php  echo "Body administration";?>
    </h1>
    <br class="clearfloat" />
    <div class="topbutton">
      <ul>
        <li><a href="<?php  echo site_url('bodies/admin/createnewbody')?>" class="input-submit last">
          <?php  echo "Create new";?>
          </a></li>
      </ul>
    </div>
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
              <option value="name" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='name')){?>selected<?php }?>>By Name</option>
            </select>
          </td>
        </tr>
      </form>
    </table>
    <?php  if($bodies) : ?>
    <table class="page-list">
      <thead>
        <tr>
          <th width="3%" class="center">#</th>
          <th><?php  echo "Title";?></th>
          <th><?php  echo "Body Image";?></th>
          <th width="8%"><?php  echo "Status";?></th>
          <th width="20%" colspan="2"><?php  echo "Action";?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
$i = 1; foreach ($bodies as $bodyData): 
$imageName = $bodyData['body_image'];

?>
        <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
        <tr class="<?php  echo $rowClass?>">
          <td class="center"><?php  echo ($i + $start) ?></td>
          <td><?php  echo $bodyData['body_title'];?></td>
          <td><?php  if($imageName !="") {echo "<img src ='".base_url()."/media/bodyimage/".$imageName."' width='100px' height='100px'>";} else{ echo "No Image"; } ?></td>
          <td><?php  echo ($bodyData['is_active']==1)?"Active":"Inactive";?></td>
          <td><a href="<?php  echo site_url($module.'/admin/editbody/'.$bodyData['id'])?>">
            <?php  echo "Edit";?>
            </a></td>
          <td><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deletebody/'.$bodyData['id'])?>">
            <?php  echo "Delete";?>
            </a></td>
        </tr>
        <?php  $i++; endforeach;?>
      </tbody>
    </table>
    <?php  else: ?>
    <?php  echo "No body data found"; ?>
    <?php  endif ; ?>
    <div class="pagging-new">
      <ul>
        <?php  echo $pager?>
      </ul>
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
<!-- [Content] end -->
<?php */?>
