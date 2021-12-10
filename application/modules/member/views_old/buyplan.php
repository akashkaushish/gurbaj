<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-2.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Pricing Plans</h1>
            <p>Expore more features by selecting a plan</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="container">
  <div class="pricing">
    <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice w-100" style="clear:both; width:100%">
      <?php  echo $notice;?>
    </p>
    <?php  endif;?>
    <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
    <div class="alert alert-success" style="clear:both; width:100%">
      <?php  echo $success;?>
    </div>
    <?php  endif;?>
    <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
    <div class="alert alert-danger w-100"style="clear:both; width:100%" >
      <?php  echo $error;?>
    </div>
    <?php  endif;?>
    <?php if($activeplan == 0){ ?>
    <div class="pricing_item">
      <h3 class="pricing_title">BitFxCo Wallet</h3>
      <div class="pricing_price"><span class="pricing_currency">$</span><?php echo $userdata['wallet_total'];?></div>
      <?php if( $userdata['wallet_total']   >=  $plans['price']){?>
      <ul class="pricing_feature-list">
        <li class="pricing_feature">Buy your plan using BitFxCo wallet</li>
      </ul>
      <a href="<?php  echo site_url('member/paybywallet/'.$planid);?>">
      <button class="pricing_action" aria-label="Purchase this plan"><span class="icon lnr lnr-arrow-right"></span></button>
      </a>
      <?php }else{?>
	  
	  <ul class="pricing_feature-list">
        <li class="pricing_feature">You have unsufficient amount in wallet</li>
      </ul>
      
	<?php   }?>
    </div>
    <div class="pricing_item">
      <h3 class="pricing_title">Bitcoin Wallet</h3>
      <div class="pricing_price"><span class="pricing_currency">$</span>0</div>
      <ul class="pricing_feature-list">
        <li class="pricing_feature"> Buy your plan using Bitcoin wallet</li>
      </ul>
      <a href="<?php $plan_id= $plans[$i]['id']; echo site_url('member/pay/'.$planid)?>">
      <button class="pricing_action" aria-label="Purchase this plan"><span class="icon lnr lnr-arrow-right"></span></button>
      </a> </div>
  </div>
      <?php }else{ ?>
        <p  class="alert alert-success"> You already have a active plan associated with this ID.</p>
      <?php } ?>
</div>
<!-- /.End of pricing -->
