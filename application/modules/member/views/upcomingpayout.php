
<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Upcoming Payouts</h6>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <!--<div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">My Transactions</h3>
          </div>
        </div>
      </div>-->
      <div class="table-responsive">
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
        <div class="alert alert-success" style="clear:both;">
          <?php  echo $success;?>
        </div>
        <?php  endif;?>
        <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
        <div class="alert alert-danger" style="clear:both;">
          <?php  echo $error;?>
        </div>
        <?php  endif;?>
        <!-- Projects table -->
        <table class="table align-items-center table-dark table-flush">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Plan</th>
              <th>Pay Amount</th>
              <th>Percent (%)</th>
              <th>Month</th>
              <th>Pay Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($upcomingpayout) > 0){ for($i=0;$i<count($upcomingpayout); $i++){ ?>
            <tr>
              <td><?php echo $i+1; ?></td>
              <td>$<?php echo $upcomingpayout[$i]['plan_price']; ?></td>
              <td>$<?php echo round($upcomingpayout[$i]['pay_amount'],2); ?></td>
              <td><?php echo $upcomingpayout[$i]['percentage']; ?></td>
              <td><?php if($upcomingpayout[$i]['created_date'] == '2020-12-30'){ echo $upcomingpayout[$i]['month']-1; }else{ echo $upcomingpayout[$i]['month']; } ?></td>
              <td><?php echo $upcomingpayout[$i]['pay_date']; ?></td>
              <td><?php if($upcomingpayout[$i]['status'] == 1){ echo "Paid"; }else{ echo "Unpaid"; } ?></td>
            </tr>
            <?php } }else{ ?>
            <tr>
              <td colspan="6"><div class="alert alert-danger">No Upcoming Payout available.</div></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="float-right pagination"><?php echo $pager; ?></div>
  </div>
</div>
<!-- Footer -->
