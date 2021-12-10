<div class="dashboard-main">
  <div class="container-fluid">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
            <p class="notice" style="clear:both;">
              <?php  echo $notice;?>
            </p>
            <?php  endif;?>
    
        <h3>My Withdraw Requests</h3>
<div class="right-side-box"> <a class="join-btn" href="<?php echo site_url('member/withdraw');?>">Withdraw Funds</a> </div>
<div class="data-table">
 <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Amout</th>
            <th scope="col">Account</th>
            <th scope="col">Status</th>
            <th scope="col">Date</th>
            
          </tr>
        </thead>
        <tbody>
          <?php for($i=0;$i<count($user_withdraws); $i++){ ?>
          <tr>
            <td><?php echo $i+1; ?></td>
            <td>$ <?php echo $user_withdraws[$i]['amount']; ?></td>
            <td><?php echo $user_withdraws[$i]['account']; ?></td>
            <td><?php if($user_withdraws[$i]['is_active'] > 0){ echo "Paid"; }else{ echo "Waiting for Admin Approval"; } ?></td>
            <td><?php echo $user_withdraws[$i]['date_created']; ?></td>
            
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
 </div>
 </div>
 </div>
 
 
 
</div>