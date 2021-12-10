<?php $activationdate= $myplans[0]['plan_activation_date'];
      $date=date('j M, Y',strtotime($activationdate));
?>
<script>

var countDownDate = new Date("<?php echo $date;?> 00:00:01").getTime();
// Update the count down every 1 second
  var x = setInterval(function() {

  var d = new Date();

    // convert to msec
    // add local time zone offset
    // get UTC time in msec
   // var now = d.getTime() + (d.getTimezoneOffset() * 60000);
	//now=now-18000000;
    var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  
  if(hours > 0){
  document.getElementById("demo").innerHTML =  hours + " Hours " + minutes + " minutes " + seconds + " Seconds";
  //document.getElementById("demo").innerHTML = d.getTimezoneOffset();
  }else{
  
  document.getElementById("demo").innerHTML =  minutes + "minutes " + seconds + "Seconds";
  }
  
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text mb-style">
            <h1><?php echo $user_detail['my_ref_code'];?> </h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="dashboard_content">
  <div class="container">
    <div class="row">
      <div class="dashboard-userinfo">
        <div class="top">
          <div class="col-left">
            <h3>Welcome !!</h3>
          </div>
          <div class="col-right"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/profile-img.png" class="img-responsive" alt=""></div>
        </div>
        <div class="details"> <i class="fa fa-user-circle" aria-hidden="true"></i>
          <div class="right-sec">
            <h5><?php echo $user_detail['fname'].' '.$user_detail['lname'];?></h5>
            <p><?php echo $user_detail['email'];?></p>
            <p><span>Phone : </span><?php echo $user_detail['phone'];?></p>
            <p><span>Level Open : </span>
              <?php if($user_detail['level_bonus'] > 7){ echo '7'; }else{ echo $user_detail['level_bonus'];} ?>
            </p>
            <p><span>Wallet Total : </span>$<?php echo round($totalwallet, 2);  ?></p>
          </div>
        </div>
      </div>
      <div class="dashboard-left">
        <div class="row">
          <!-- Single Widget -->
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card">
                <div class="card-body">
                  <h5 class="font-15">Total Invested</h5>
                  <h3 class="mb-0">$<?php echo round($totalinvested, 2);  ?></h3>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Widget -->
          <a href="<?php echo site_url('member/mytransactions') ?>">
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-danger">
                <div class="card-body">
                  <h5 class="font-15">Total Payout</h5>
                  <h3 class="mb-0">$
                    <?php  echo round($payout, 2);  ?>
                  </h3>
                </div>
              </div>
            </div>
          </div>
          </a>
          <!-- Single Widget -->
          <a href="<?php echo site_url('member/mytransactions') ?>">
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-success">
                <div class="card-body">
                  <h5 class="font-15">Total Commission</h5>
                  <h3 class="mb-0">$
                    <?php  echo round($commission, 2);  ?>
                  </h3>
                </div>
              </div>
            </div>
          </div>
          </a>
          <!-- Single Widget -->
          <a href="<?php echo site_url('member/showlevel') ?>">
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-warning">
                <div class="card-body">
                  <h5 class="font-15">Upcoming Commission</h5>
                  <h3 class="mb-0">$<?php echo round($userdetail['show_bonus'], 2);  ?></h3>
                </div>
              </div>
            </div>
          </div>
          </a> <a href="<?php echo site_url('member/fixedreward') ?>">
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-success">
                <div class="card-body">
                  <h5 class="font-15">Fixed Reward</h5>
                  <h3 class="mb-0">$<?php echo $my_reward; ?></h3>
                </div>
              </div>
            </div>
          </div>
          </a> <a href="<?php echo site_url('member/royalty') ?>" style="color:#fff;">
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-primary">
                <div class="card-body">
                  <h5 class="font-15">Royalty</h5>
                  <h3 class="mb-0">$<?php echo $my_royalty; ?></h3>
                </div>
              </div>
            </div>
          </div>
          </a> <a href="<?php echo site_url('member/upcomingpayout') ?>">
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-danger">
                <div class="card-body">
                  <h5 class="font-15">Upcoming Payout</h5>
                  <h3 class="mb-0">$<?php echo round($upcoming_payout, 2);  ?></h3>
                </div>
              </div>
            </div>
          </div>
          </a>
          <div class="col-sm-6 col-lg-3 margindashboard">
            <div class="single-widger-cart mb-30">
              <div class="card bg-primary">
                <div class="card-body">
                  <h5 class="font-15">Total Withdrawn</h5>
                  <h3 class="mb-0">$<?php echo round($totalwithdrawn, 2); ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 dataTab">
          <div class="card card-table">
            <div class="card-header">
              <h4>My Plans</h4>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Plan Name</th>
                    <th>Amout</th>
                    <th>Purchased Date</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Open/Close</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(count($myplans) > 0){ for($i=0;$i<count($myplans); $i++){ ?>
                  <tr>
                    <td><?php echo $myplans[$i]['plan_name']; ?></td>
                    <td><?php echo $myplans[$i]['payment_amount']; ?></td>
                    <td><?php echo $myplans[$i]['payment_date']; ?></td>
                    <td><?php echo $myplans[$i]['plan_activation_date']; ?></td>
                    <td><?php echo $myplans[$i]['plan_end_date']; ?></td>
                    <td><?php if($myplans[$i]['is_confirmed'] == 1){ //echo "Active";?>
                      <?php if(date('Y-m-d', strtotime(' +1 day'))== $myplans[$i]['plan_activation_date']){?>
                      <span id="demo" style="color:#25258E; font-size:16px;"></span>
                      <?php }else{echo "---";}?>
                      <?php }else if($myplans[$i]['is_confirmed'] == 2){ echo "Completed"; }else{ echo "Waiting for Approval"; } ?></td>
                    <td><?php if($myplans[$i]['is_close'] == 1){ echo "Closed"; }else{ echo "Open"; } ?></td>
                  </tr>
                  <?php } }else{ ?>
                  <tr>
                    <td colspan="7"><div class="alert alert-danger">No Plan Purchased yet, Hurry up to start by purchasing a plan.</div></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div> </div>
        </div>
      </div>
    </div>
  </div>
</div>
