
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
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
        <div class="alert alert-success">
          <?php  echo $success;?>
        </div>
        <?php  endif;?>
        <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
        <div class="alert alert-danger">
          <?php  echo $error;?>
        </div>
        <?php  endif;?>
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">My Withdraw Requests</h3>
          </div>
          <div class="float-right" style="margin:10px"> <a href="<?php echo site_url('member/withdrawrequest');?>" class="btn btn-primary">Withdraw Funds</a> </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-dark table-flush">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Amount</th>
              <th>Fee (5%)</th>
              <th>Pay Amount</th>
              <th>Account</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($user_withdraws) > 0){ for($i=0;$i<count($user_withdraws); $i++){ ?>
            <tr>
              <td><?php echo $i+1; ?></td>
              <td>$<?php echo $user_withdraws[$i]['amount']; ?></td>
              <td>$<?php echo $user_withdraws[$i]['trans_fee']; ?></td>
              <td>$<?php echo $user_withdraws[$i]['pay_amount']; ?></td>
              <td><?php echo $user_withdraws[$i]['account']; ?></td>
              <td><?php if($user_withdraws[$i]['is_approved']==0){?>
                Self Approving pending
                <?php }else{?>
                <?php if($user_withdraws[$i]['is_active'] > 0){ echo "Paid"; }else{ echo "Waiting for Admin Approval"; } ?>
                <?php }?>
              </td>
              <td><?php echo $user_withdraws[$i]['date_created']; ?></td>
              <td><?php if($user_withdraws[$i]['is_approved']==0){?>
                <a href="<?php echo site_url('member/withdraw/'.$user_withdraws[$i]['id']);?>" class="btn-blue">Verify</a> | <a onclick="return confirm('Are you sure to delete?');" href="<?php echo site_url('member/requestdelete/'.$user_withdraws[$i]['id']);?>" class="btn-orange">Delete</a>
                <?php }?>
              </td>
            </tr>
            <?php } }else{ ?>
            <tr>
              <td colspan="6"><div class="alert alert-danger">No request available.</div></td>
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
