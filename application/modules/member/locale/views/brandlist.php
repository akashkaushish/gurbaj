<div class="annual-sales brands-list">
  <div class="head">
    <h2 class="d-inline-block">Product Brands</h2>
    <a href="<?php  echo site_url('member/admin/addadminbrand/') ?>" class="btn btn-success float-right">Add New Brands</a> </div>
  <div class="table-responsive">
    <?php  if($brands) : ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          
          <th scope="col">Image</th>
          <th scope="col">Brand</th>
          <th scope="col">Added By</th>
		  <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php  $i = 1; foreach ($brands as $brand): ?>
        <tr>
          <td><?php  echo ($i + $start) ?></td>
         
          <td><?php if($brand['logo'] != ""){ ?>
            <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/<?php echo $brand['logo']; ?>" class="img-thumbnail">
            <?php }else{ ?>
            <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/no_image.png" class="img-thumbnail">
            <?php } ?>
          </td>
          <td><?php echo $brand['name']; ?></td>
          <td><?php if($brand['added_by']==1){echo "Admin";}else{
			  
			  echo $this->db->get_where('users', array('id'=>$brand['added_by']))->row()->name.' '.$this->db->get_where('users', array('id'=>$brand['added_by']))->row()->lname;
			  }?></td>
			   <td><?php if($brand['is_active'] == 1){ echo "Active"; }else{ echo "Disabled"; } ?></td>
          <td><?php $brand_id = $brand['id'];?>
            <div class="btn-group">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Choose.. </button>
              <div class="dropdown-menu"> <a class="dropdown-item" href="<?php  echo site_url('member/admin/editadminbrand/'.$brand_id) ?>">Edit</a> <a class="dropdown-item" href="<?php  echo site_url('member/admin/deletebrand/'.$brand_id) ?>" onclick="return confirm('Are you sure to delete?');">Delete</a> </div>
            </div></td>
        </tr>
        <?php  $i++; endforeach;?>
      </tbody>
    </table>
    <?php  else: ?>
    <?php  echo "No user found"; ?>
    <?php  endif ; ?>
  </div>
</div>
<!--annual sale-->
<?php /*?><main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-btc"></i> Brand List</h1>
  </div>
  <div><a class="btn btn-primary" href="<?php  echo site_url($module.'/admin/addadminbrand')?>"><i class="fa fa-fw fa-lg fa-plus-circle"></i>Create Brand</a></div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Brand List</li>
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
        <?php  if($brands) : ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th scope="col" class="center">#</th>
              <th scope="col">Image</th>
              <th scope="col">Brand</th>
              <th scope="col">Added By</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php  $i = 1; foreach ($brands as $brand): ?>
            <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
            <tr>
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><a href="#" class="avatar  mr-3">
                <?php if($brand['logo'] != ""){ ?>
                <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/<?php echo $brand['logo']; ?>" width="80px;">
                <?php }else{ ?>
                <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/no_image.png">
                <?php } ?>
                </a> </td>
              <td><?php echo $brand['name']; ?></td>
              <td><?php if($brand['added_by']==1){echo "Admin";}else{
			  
			  echo $this->db->get_where('users', array('id'=>$brand['added_by']))->row()->name.' '.$this->db->get_where('users', array('id'=>$brand['added_by']))->row()->lname;
			  }?></td>
              <td><a _ngcontent-c5="" class="btn btn-sm btn-success">
                <?php if($brand['is_active'] == 1){ echo "Active"; }else{ echo "Disabled"; } ?>
                </a></td>
              <?php $brand_id = $brand['id'];?>
              <td><a class="btn btn-sm btn-icon-only" href="<?php  echo site_url('member/admin/editadminbrand/'.$brand_id) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a> <a class="btn btn-sm btn-icon-only" onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url('member/admin/deletebrand/'.$brand_id) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
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
