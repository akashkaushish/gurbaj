<div class="row main-buttons dashboard-margin">
  <?php /*?><div class="col-md-3"> <a href="<?php echo site_url('product/admin/listall');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/dashboard-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Dashboard</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div><?php */?>
  <div class="col-md-3"> <a href="<?php echo site_url('member/admin');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/user-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Users</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('product/admin/listall');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/product-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Product Library</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
    <div class="col-md-3"> <a href="<?php echo site_url('product/admin/speciallistall');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/product-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Private Products</h4>
        <p>These products are for limited users only.</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('product/admin/productattributes');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/product-attribute-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Product Attributes</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('member/admin/brandlist');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/brand-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Brand List</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('category/admin/orderlist');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/order-history-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Order History</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('category/admin/orderattributes');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/order-attribute-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Order Attributes</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
  <div class="col-md-3"> <a href="<?php echo site_url('category/admin');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/product-category-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Product Category</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>

    <div class="col-md-3"> <a href="<?php echo site_url('product/admin/supplierbids');?>">
    <div class="card">
      <div class="icon"><img class="img-fluid" src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/images/product-category-icon.png" alt=""></div>
      <div class="icon-det">
        <h4>Supplier Bids</h4>
        <p>It is a long established fact that a reader will be .</p>
      </div>
    </div>
    </a> </div>
</div>
<!--<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      <p style="font-family:Niconne; font-size:22px">Zeesotech</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-2x"></i>
        <div class="info">
          <h4>Users</h4>
          <p><b>
            <?php if(isset($usercount) && ($usercount > 0)){ echo $usercount;}else{echo "0";}?>
            </b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-2x"></i>
        <div class="info">
          <h4>Categories</h4>
          <p><b>
            <?php if(isset($categorycount) && ($categorycount > 0)){ echo $categorycount;}else{echo "0";}?>
            </b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-2x"></i>
        <div class="info">
          <h4>Brands</h4>
          <p><b>
            <?php if(isset($brandcount) && ($brandcount > 0)){ echo $brandcount;}else{echo "0";}?>
            </b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-print fa-2x"></i>
        <div class="info">
          <h4>Products</h4>
          <p><b>100</b></p>
        </div>
      </div>
    </div>
  </div>
</main>-->
