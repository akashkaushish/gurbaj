<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Upcoming Payouts</h1>
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
      <div class="col-md-12 dataTab">
        <div class="card card-table">
          <div class="card-body table-responsive">
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
            <table class="table table-striped table-hover">
              <thead>
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
                  <td>$<?php echo $upcomingpayout[$i]['pay_amount']; ?></td>
                  <td><?php echo $upcomingpayout[$i]['percentage']; ?></td>
                  <td><?php echo $upcomingpayout[$i]['month']; ?></td>
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
        <div></div>
      </div>
    </div>
  </div>
</div>
