
    <!-- Header -->
    <div class="header  pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="card bg-warning mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Brands</h5>
                      <span class="h2 font-weight-bold text-white mb-0"><?php $brandcount = $this->user->totalbrands(); if(isset($brandcount) && ($brandcount > 0)){ echo $brandcount;}else{echo "0";}?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="ni ni-bag-17"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6">
              <div class="card bg-success mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Products</h5>
                      <span class="h2 font-weight-bold text-white mb-0"><?php $brandcount = $this->user->totalproducts(); if(isset($brandcount) && ($brandcount > 0)){ echo $brandcount;}else{echo "0";}?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <i class="ni ni-bag-17"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6">
              <div class="card bg-yellow mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Sales</h5>
                      <span class="h2 font-weight-bold text-white mb-0">512,924</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="ni ni-bag-17"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      
      <div class="row mt-3">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <!--div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Annual Sales</h3>
                </div>
                <div class="col text-right">
                  <a href="#!" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div-->
            <!--div class="table-responsive">
              
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Status</th>
					<th scope="col">Amount</th>
					<th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td><a href="#" class="avatar  mr-3"><img alt="Image placeholder" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/01.png"></a></td>
                    <td>Ferrero Rocher</td>
                    <td>5</td>
                    <td><a _ngcontent-c5="" class="btn btn-sm btn-success">Active</a></td>
                    <td>$19.94</td>
                    <td><a class="btn btn-sm btn-icon-only" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                  </tr>
				  
				 
                  
                </tbody>
              </table>
            </div>
          </div-->
        </div>
        
      </div>