<div class="dashboard-main">
  <div class="container-fluid">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice" style="clear:both;">
      <?php  echo $notice;?>
    </p>
  <?php  endif;?>
    
    
    <div class="dashboard-top">
    
        <h3>Payment Approval Request List</h3>

<div class="data-table">
 <div class="table-responsive">
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">User Name</th>
          <th scope="col">Transaction Id</th>
          <th scope="col">Payment Amount</th>
          <th scope="col">Payment Date</th>
          <th scope="col">Plan Name</th>
          <th scope="col">Pay Status</th>
          <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php  $i = 1; foreach ($members as $member): ?>
            <tr>
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
              <td><?php  echo $member['transaction_id']?></td>
              <td><?php  echo $member['payment_amount'];?></td>
              <td><?php  echo $member['payment_date'];?></td>
              <td><?php  echo $member['plan_name'];?></td>
              <td><?php if($member['is_confirmed'] == 1){ echo "Confirmed"; }else{ echo "Not Confirmed"; } ?>
                </td>
              <td>
                <?php if($member['is_confirmed'] != 1){?>
                <a onclick="return confirm('Are you sure to change the payment status?');" href="<?php  echo site_url($module.'/admin/confiruserplan/'.$member['id'])?>">Confirm Payment</a>
                <?php }?>
                </td>
            </tr>
            <?php  $i++; endforeach;?>
        </tbody>
      </table>
      <div class="float-right pagination"><?php echo $pager; ?></div>
    </div>
 </div>
 </div>
 </div>
 
 
 
</div>