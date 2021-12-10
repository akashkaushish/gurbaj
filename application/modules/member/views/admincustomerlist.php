<!-- Header -->
<div class="annual-sales brands-list">
  <div class="head">
    <h2 class="d-inline-block">Customer's List</h2>
    <a href="<?php echo base_url()?>index.php?product/salesorders" class="btn btn-sm btn-primary float-right">Manage Orders</a>
   
  <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">ID</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(count($customers) > 0){ for($i=0;$i<count($customers);$i++){ ?>
                  <tr>
                    <td><?php echo $customers[$i]['fname']." ".$customers[$i]['lname']; ?></td>
                    <td><?php echo $customers[$i]['email']; ?></td>
                    <td><?php echo $customers[$i]['phone']; ?></td>
                    <td><?php echo $customers[$i]['uniq_id']; ?></td>
                    <td><div class="btn-group">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Choose.. </button>
                      <div class="dropdown-menu"> 
                        <a class="dropdown-item" href="<?php $customer_id = $customers[$i]['id']; echo site_url('product/admin/createorder_byadmin/'.$customer_id) ?>">Take Order</a> 
                        
                      </div>
                     </div>
                    </td>
                  </tr>
                <?php } }else{ ?>
                  <tr>
                      <td><p>No Customer available.</p></td>
                  </tr>
                <?php } ?>
                </tbody>
              
              </table>
              
            </div>
          </div>
