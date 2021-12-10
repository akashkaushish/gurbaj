<div class="row main-buttons dashboard-margin">
 
  <div class="col-md-3"> <a href="<?php echo site_url('member/changepassword');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/user-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Change Password</h4>
        <p>click here to your password.</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> 
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Products</h4>
        <p><?php $productcount = $this->user->totalproducts(); if(isset($productcount) && ($productcount > 0)){ echo $productcount;}else{echo "0";}?></p>
      </div>
    </div>
    </div>
  <div class="col-md-3"> 
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-attribute-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Brands</h4>
        <p><?php $brandcount = $this->user->totalbrands(); if(isset($brandcount) && ($brandcount > 0)){ echo $brandcount;}else{echo "0";}?></p>
      </div>
    </div>
  </div>
  <!--div class="col-md-3"> <a href="<?php echo site_url('member/admin/brandlist');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/brand-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Brand List</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('category/admin/orderlist');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/order-history-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Order History</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('category/admin/orderattributes');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/order-attribute-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Order Attributes</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div-->
  <div class="col-md-3"> 
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-category-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Categories</h4>
        <p><?php $categorycount = $this->user->totalcategories(); if(isset($categorycount) && ($categorycount > 0)){ echo $categorycount;}else{echo "0";}?></p>
      </div>
    </div>
    </div>
</div>
