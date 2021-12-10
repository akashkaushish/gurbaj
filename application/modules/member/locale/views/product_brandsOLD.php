<!-- Header -->
    <div class="header bg-gradient-primary  pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
         <h2 class="text-white">Product Brands</h2>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      
      <div class="row mt-3">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Brand List</h3>
                </div>
                <div class="col text-right">
                  <a href="<?php echo base_url()?>index.php?member/addbrand" class="btn btn-sm btn-primary">Add New</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
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
                    <td>
                        <a href="#" class="avatar  mr-3">
                        <?php if($brands[$i]['logo'] != ""){ ?>
                          <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/<?php echo $brands[$i]['logo']; ?>">
                        <?php }else{ ?>
                          <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/no_image.png">
                          <?php } ?>
                        </a>
                    </td>
                    <td><?php echo $brands[$i]['name']; ?></td>
                    <td><?php echo $brands[$i]['fname']." ".$brands[$i]['lname']; ?></td>
                    <td><a _ngcontent-c5="" class="btn btn-sm btn-success"><?php if($brands[$i]['is_active'] == 1){ echo "Active"; }else{ echo "Disabled"; } ?></a></td>
                    
                    <td>
                      <?php if(isset($_SESSION['user_id']) &&  $_SESSION['user_id'] == $brands[$i]['added_by']){ ?>
                      <a class="btn btn-sm btn-icon-only" href="<?php $brand_id = $brands[$i]['id']; echo site_url('member/editbrand/'.$brand_id) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
                      <a class="btn btn-sm btn-icon-only" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } }else{ ?>
                  <tr>
                      <td><p>No brands available.</p></td>
                  </tr>
                <?php } ?>
                </tbody>
              
              </table>
              
            </div>
          </div>
        </div>
        
      </div>