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
    <?php for($i=0;$i<count($plans);$i++){ ?>
    <div class="pricing_item">
      <h3 class="pricing_title"><?php echo strtoupper($plans[$i]['plan_name']); ?></h3>
      <div class="pricing_price"><span class="pricing_currency">$</span><?php echo $plans[$i]['price']; ?></div>
      <ul class="pricing_feature-list">
        <li class="pricing_feature"><b>RETURN MONTHLY BASIS</b></li>
        <li class="pricing_feature">Minimum Withdrawal $5</li>
        <li class="pricing_feature">Plan Completion: <?php echo $plans[$i]['months']; ?> months</li>
      </ul>
      <?php  if($activeplan == 0){   //!= $plans[$i]['id'] ?>
      <a href="<?php $plan_id= $plans[$i]['id']; echo site_url('member/buyplan/'.$plan_id)?>">
      <button class="pricing_action" aria-label="Purchase this plan"><span class="icon lnr lnr-arrow-right"></span></button>
      </a>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="pricing_item plan-section">
      <h3 class="pricing_title">ROI COMMISSION</h3>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="info left-sec">
            <p><span>2%:</span> 1st Level</p>
            <p><span>1%:</span> 2nd Level</p>
            <p><span>1%:</span> 3rd Level</p>
            <p><span>0.50%:</span> 4th Level</p>
            <p><span>0.50%:</span> 5th Level</p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="info right-sec">
            <p><span>0.25%:</span> 6th Level</p>
            <p><span>0.25%:</span> 7th Level</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.End of pricing -->
