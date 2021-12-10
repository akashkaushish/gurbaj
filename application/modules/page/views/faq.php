<link href="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir;?>admin/style/modal-videos.css" rel="stylesheet">
<div class="container">
  <div class="wrap">
    <ul class="breadcrumb">
      <li>Home<span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="">My Account</a> <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="" class="aciveurl-breadcrumb"><?php echo $faq['title'];?></a> </li>
    </ul>
  </div>
  <div class="wrap">
  <div class="section1 aboutus">
  <h1><?php echo $faq['title'];?></h1>
  
  <?php echo $faq['body'];?>
  </div>
</div>
</div>

