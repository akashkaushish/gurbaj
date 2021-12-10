<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>My Transactions</h1>
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
            <table class="table table-striped table-hover">
              <thead>
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
        <div></div>
      </div>
    </div>
  </div>
</div>
