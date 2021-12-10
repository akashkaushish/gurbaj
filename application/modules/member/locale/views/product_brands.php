<div class="annual-sales brands-list">
  <div class="head">
    <h2 class="d-inline-block">Product Brands</h2>
    <a href="<?php echo base_url()?>index.php?member/addbrand" class="btn btn-success float-right">Add New Brands</a> </div>
  <div class="table-responsive">
  
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
      <?php if(count($brands) > 0){ for($i=0;$i<count($brands);$i++){ ?>
        <tr>
          <td><?php  echo ($i + 1); ?></td>
         
          <td><?php if($brands[$i]['logo'] != ""){ ?>
            <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/<?php echo $brands[$i]['logo']; ?>" class="img-thumbnail">
            <?php }else{ ?>
            <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/no_image.png" class="img-thumbnail">
            <?php } ?>
          </td>
          <td><?php echo $brands[$i]['name']; ?></td>
          <td><?php echo $brands[$i]['fname']." ".$brands[$i]['lname']; ?></td>
			   <td><?php if($brands[$i]['is_active'] == 1){ echo "Active"; }else{ echo "Disabled"; } ?></td>
          <td><?php $brand_id = $brand['id'];?>
            <div class="btn-group">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Choose.. </button>
              <div class="dropdown-menu"> <a class="dropdown-item" href="<?php $brand_id = $brands[$i]['id']; echo site_url('member/editbrand/'.$brand_id) ?>">Edit</a> <!--a class="dropdown-item" href="<?php  echo site_url('member/admin/deletebrand/'.$brand_id) ?>" onclick="return confirm('Are you sure to delete?');">Delete</a--> </div>
            </div></td>
        </tr>
      <?php  }?>

      <?php  }else{ ?>
      <tr>
        <td colspan="6"><?php  echo "No Brand found."; ?></td>
      </tr>
      <?php  } ?>

      </tbody>
    </table>
    
  </div>
</div>

