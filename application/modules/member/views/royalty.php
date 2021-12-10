
<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Royalty</h6>
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
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">My Total Business = $<?php echo $downline_business; ?></h3>
            <br />
            <h3 class="text-white mb-0"><?php echo $left_business. " : ".$rest_member_amount ; ?></h3>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-dark table-flush">
          <thead class="thead-dark">
            <tr>
              <th>Reason</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Payout By Plan</th>
              <th>Commission From</th>
              <th>Commission By Plan</th>
              <th>Transfer To</th>
              <th>Transfer By</th>
              <th>Level</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($user_trans) > 0){ for($i=0;$i<count($user_trans); $i++){ ?>
            <tr>
              <td><?php echo $user_trans[$i]['trans_reason']; ?></td>
              <td><?php echo $user_trans[$i]['trans_type']; ?></td>
              <td><?php echo $user_trans[$i]['amount']; ?></td>
              <td><?php if($user_trans[$i]['payout_plan_id'] > 0){ echo $this->user->get_plan_name($user_trans[$i]['payout_plan_id']); }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['comm_by_plan_id'] > 0){ echo $user_trans[$i]['comm_by_username']; }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['comm_by_plan_id'] > 0){ echo $this->user->get_plan_name($user_trans[$i]['comm_by_plan_id']); }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['trans_type'] == 'debit'){ echo $user_trans[$i]['transfer_to']; }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['trans_type'] == 'credit'){ echo $user_trans[$i]['transfer_by']; }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['comm_by_level'] > 0){ echo $user_trans[$i]['comm_by_level']; }else{ echo "--"; } ?></td>
              <td><?php echo $user_trans[$i]['date_created']; ?></td>
            </tr>
            <?php } }else{ ?>
            <tr>
              <td colspan="10"><div class="alert alert-danger">No transaction available.</div></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="float-right pagination"><?php echo $pager; ?></div>
      </div>
    </div>
  </div>
</div>
<!-- Footer -->


<?php /*?>
<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
		      <div class="haeder-text">
            <h1>Royalty</h1>
            <p>My Total Business = $<?php echo $downline_business; ?></p>
            <p><?php echo $left_business. " : ".$rest_member_amount ; ?></p>
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
          <div class="card-header">
            <h4>Royalty Reward</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Reward Level</th>
                  <th>Business</th>
                  <th>Direct Downline</th>
                  <th>Amount</th>
                  <th>Left Business</th>
                  <th>Right Business</th>
                  <th>ID (Left)</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Paid Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($my_royalty) > 0){ for($i=0;$i<count($my_royalty); $i++){ ?>
                <tr>
                  <td><?php echo $my_royalty[$i]['step']; ?></td>
                  <td><?php echo $my_royalty[$i]['total_business']; ?></td>
                  <td><?php echo $my_royalty[$i]['first_level']; ?></td>
                  <td><?php echo $my_royalty[$i]['amount']; ?></td>
                  <td><?php echo $my_reward[$i]['first_chain_business']; ?></td>
                  <td><?php echo $my_reward[$i]['rest_chain_business']; ?></td>
                  <td><?php echo $this->user->get_id_by_userid($my_reward[$i]['first_chain_user_id']); ?></td>
                  <td><?php echo $my_royalty[$i]['date']; ?></td>
                  <td><?php if($my_royalty[$i]['status'] == 1){ echo "Paid"; }else if($my_royalty[$i]['status'] == 0){ echo "Waiting for Approcal";} else{ echo "Contact Admin"; } ?></td>
                  <td><?php echo $my_royalty[$i]['paid_date']; ?></td>
                </tr>
                <?php } }else{ ?>
                <tr>
                  <td colspan="10"><div class="alert alert-danger">No Royalty Reward grabbed yet.</div></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div>
      </div>

    
    
      </div>
    </div>
  </div>
</div><?php */?>

