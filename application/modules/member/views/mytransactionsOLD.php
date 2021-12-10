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
          <li class="active">Transaction</li>
        </ol>
      </div>
    </div> 
  <div class="container-fluid">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
            <p class="notice" style="clear:both;">
              <?php  echo $notice;?>
            </p>
            <?php  endif;?>
    
        <h3>My Transactions</h3>

<div class="data-table">
 <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Reason</th>
            <th scope="col">Type</th>
            <th scope="col">Amout</th>
            <th scope="col">Payout By Plan</th>
            <th scope="col">Commission From</th>
            <th scope="col">Commission By Plan</th>
            <th scope="col">Transfer To</th>
            <th scope="col">Transfer By</th>
            <th scope="col">Level</th>
            <th scope="col">Date</th>
            
          </tr>
        </thead>
        <tbody>
          <?php for($i=0;$i<count($user_trans); $i++){ ?>
          <tr>
            <td><?php echo $i+1; ?></td>
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
          <?php } ?>
        
        </tbody>
      </table>
      <div class="float-right pagination"><?php echo $pager; ?></div>
    </div>
 </div>
 </div>
 </div>
 
 
 </div>
</div>
