<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <!--          <h6 class="h2 text-white d-inline-block mb-0">My Transactions</h6>-->
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
            <h3 class="text-white mb-0">My Transactions</h3>
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
              <td><?php echo round($user_trans[$i]['amount'],2); ?></td>
              <td><?php if($user_trans[$i]['payout_plan_id'] > 0){ echo $this->user->get_plan_name($user_trans[$i]['payout_plan_id']); }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['comm_by_plan_id'] > 0){ echo $user_trans[$i]['comm_by_username']." "; $comm_by_user_id = $this->user->get_id_by_userid($user_trans[$i]['comm_by_user_id']); echo "(".$comm_by_user_id.")"; }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['comm_by_plan_id'] > 0){ echo $this->user->get_plan_name($user_trans[$i]['comm_by_plan_id']); }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['trans_type'] == 'debit'){ echo $user_trans[$i]['transfer_to']." "; if($user_trans[$i]['transfer_to_id'] > 0){ $transfer_to_id= $this->user->get_id_by_userid($user_trans[$i]['transfer_to_id']); echo "(".$transfer_to_id.")"; } }else{ echo "--"; } ?></td>
              <td><?php if($user_trans[$i]['trans_type'] == 'credit'){ echo $user_trans[$i]['transfer_by']." "; if($user_trans[$i]['transfer_by_id'] > 0){ $transfer_by_id= $this->user->get_id_by_userid($user_trans[$i]['transfer_by_id']); echo "(".$transfer_by_id.")"; } }else{ echo "--"; } ?></td>
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
