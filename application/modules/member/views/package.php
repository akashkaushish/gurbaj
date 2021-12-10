<div class="container-fluid">
<div class="pricing row">
<div class="haeder-text">
 <h1 class="white">Pricing Plans</h1>
 <p class="white">Expore more features by selecting a plan</p>
 </div>
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
            <p><span>8%:</span> 1st Level</p>
            <p><span>4%:</span> 2nd Level</p>
            <p><span>4%:</span> 3rd Level</p>
            <p><span>2%:</span> 4th Level</p>
            <p><span>2%:</span> 5th Level</p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="info right-sec">
            <p><span>1%:</span> 6th Level</p>
            <p><span>1%:</span> 7th Level</p>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- /.End of pricing -->
