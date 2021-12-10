<!-- Header -->
<div class="annual-sales brands-list">
  <div class="head">
    <h2 class="d-inline-block">Product Suppliers</h2>
    <form action="<?php  echo site_url('product/purchaserproductlist') ?>" method="post" name="myform" class="myform float-right" >
				<input type="text" class="input-text" name="filter" value="<?php echo $filter;?>" />&nbsp;<input type="submit" class="btn btn-sm btn-primary" name="submit" value="Search" /> 
		</form>
  <div class="table-responsive">
                

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">ID</th>
          <th scope="col">email</th>
          <th scope="col">phone</th>
          <th scope="col">Since</th>
          
        </tr>
      </thead>
      <tbody>
      <?php if(count($suppliers) > 0){ for($i=0;$i<count($suppliers);$i++){ ?>
        <tr>
          
          <td><?php echo $suppliers[$i]['fname']." ".$suppliers[$i]['lname']; ?></td>
          <td><?php echo $suppliers[$i]['uniq_id']; ?></td>
          <td><?php echo $suppliers[$i]['email']; ?></td>
          <td><?php echo $suppliers[$i]['phone']; ?></td>
          <td><?php echo $suppliers[$i]['created_date']; ?></td>
          
          <!--td>
            <a class="btn btn-sm btn-icon-only" href="<?php $product_id = $products[$i]['id']; echo site_url('product/detail/'.$product_id); ?>"><i class="fa fa-shopping-cart" aria-hidden="true" title="View Details"></i></a>
          </td-->
        </tr>
      <?php } }else{ ?>
        <tr>
            <td colspan="7"><p>No Suppliers available.</p></td>
        </tr>
      <?php } ?>
      </tbody>
    
    </table>
              
  </div>
</div>
<br />
<div class="dataTables_paginate paging_simple_numbers float-right" id="sampleTable_paginate">
  <ul class="pagination">
    <?php  echo $pager;?>
  </ul>
</div>