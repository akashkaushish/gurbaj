<div class="main-content">
<div class="dashboard-main">
<div class="row">
      <div class="col-md-12 title">
        <h3>Welcome <?php echo $userdetail['fname']." ".$userdetail['lname']; ?> </h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Plans</li>
        </ol>
      </div>
    </div> 
<section class="pricing-section" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> <span>Expore more features</span>
      <h2>by Selecting a plan</h2>
     <!-- <p>Choose How You Want to Invest With Us</p>-->
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
	 <?php if ($notice = $this->session->flashdata('notification')):?>
            <p class="notice" style="text-align:center"><?php echo $notice;?></p>
			<br />
            <?php endif;?>
    <div class="tab-content">
      <div class="tab-pane fade active in" id="monthly-price">
        <div class="row">
          
          <?php for($i=0;$i<count($plans);$i++){ ?>
          <!-- /.col-md-4 -->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="single-pricing hvr-bounce-to-bottom">
              <div class="title">
                <h3><?php echo $plans[$i]['plan_name']; ?></h3>
              </div>
              <!-- /.title -->
              <div class="percent"> <span><i class="fa fa-dollors"></i>$<?php echo $plans[$i]['price']; ?></span>
               </div>
              <!-- /.percent -->
              
              <div class="info">
              <p><div class="title"><h3>Return $<?php echo $payout= ($plans[$i]['price']*$plans[$i]['payout']*1)/100; ?> per day</h3></div></p>
              <p>Minimum  Withdrawal $10</p>
              <p>Assured Return: <?php echo number_format( (float) $plans[$i]['payout'], 2, '.', ''); ?>% per day</p>
              <p>Plan Completion: <?php echo $plans[$i]['days']; ?> days </p>
              </div>
              
              <!-- /.info -->
              <div class="btn-box"> 
              <?php if($activeplan != $plans[$i]['id']){ ?>
               <a href="<?php $plan_id= $plans[$i]['id']; echo site_url('member/pay/'.$plan_id)?>" class="sign-up">Buy Now</a> 
              <?php }else{ ?>
                <a href="#" class="sign-up">Already Active</a> 
              <?php } ?>
              </div>
              <!-- /.btn-box -->
             
            </div>
            <!-- /.single-pricing -->
          </div>
          <?php } ?>
          <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>
</div>
</div>
