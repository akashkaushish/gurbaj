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


    

<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Dashboards</h6>
        </div>
		
      </div>
	       <?php  if($get_upcoming_royalty_payment[0]['cnt']==1){?>
         <div class="alert alert-success">
            You are eligible for the upcoming level <?php echo $get_upcoming_royalty_payment[0]['step'];?> royalty, please contact to the admin.
          </div>
          <?php  }?>
      <!-- Card stats -->
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">TOTAL INVESTED</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">$<?php echo round($totalinvested, 2);  ?></span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow"> <i class="ni ni-active-40"></i> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <a href="<?php echo site_url('member/mytransactions') ?>">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">TOTAL PAYOUT</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">
                 $<?php  echo round($payout, 2);  ?>
                  </span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow"> <i class="ni ni-chart-pie-35"></i> </div>
                </div>
              </div>
            </div>
            </a></div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <a href="<?php echo site_url('member/royalty') ?>" style="color:#fff;">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">ROYALTY</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">$<?php echo $my_royalty; ?></span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow"> <i class="ni ni-money-coins"></i> </div>
                </div>
              </div>
            </div>
            </a> </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <a href="<?php echo site_url('member/fixedreward') ?>">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">FIXED REWARD</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">$<?php echo $my_reward; ?></span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow"> <i class="ni ni-chart-bar-32"></i> </div>
                </div>
              </div>
            </div>
            </a> </div>
        </div>
        <!--next leverl-->
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
			     <a href="<?php echo site_url('member/upcomingpayout') ?>">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Upcoming Payout</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">$<?php echo round($upcoming_payout, 2);  ?></span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow"> <i class="ni ni-active-40"></i> </div>
                </div>
              </div>
            </div>
			</a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">TOTAL Withdrawn</h5>
                  <span class="h2 font-weight-bold mb-0 text-white"> $<?php echo round($totalwithdrawn, 2); ?> </span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow"> <i class="ni ni-chart-pie-35"></i> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <a href="<?php echo site_url('member/showlevel') ?>">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Upcoming Commission</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">$<?php echo round($total_upcoming_commission, 2);  ?></span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow"> <i class="ni ni-money-coins"></i> </div>
                </div>
              </div>
            </div>
            </a> </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats bg-default">
            <!-- Card body -->
            <a href="<?php echo site_url('member/mytransactions') ?>">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">TOTAL Commission</h5>
                  <span class="h2 font-weight-bold mb-0 text-white"> $<?php  echo round($commission, 2);  ?>
                  </span> </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow"> <i class="ni ni-chart-bar-32"></i> </div>
                </div>
              </div>
            </div>
            </a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-8">
    <div class="card bg-default">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>
            <h5 class="h3 text-white mb-0">MY BUSINESS</h5>
          </div>
          <div class="col">
            <ul class="nav nav-pills justify-content-end">
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!-- Chart -->
        <div class="chart">
          <!-- Chart wrapper -->
          <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4">
    <div class="card bg-default">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
            <h5 class="text-white h3 mb-0">UPCOMING PAYOUT</h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!-- Chart -->
        <div class="chart">
          <canvas id="chart-bars" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">My Plans</h3>
          </div>
          <!--          <div class="col text-right"> <a href="#!" class="btn btn-sm btn-primary">See all</a> </div>-->
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-dark table-flush">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Plan Name</th>
              <th scope="col">Amount</th>
              <th scope="col">Purchased Date </th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Active</th>
              <th scope="col">Open/Close</th>
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
  </div>
</div>
