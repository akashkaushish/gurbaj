<div class="dashboard-main">
  <div class="container-fluid">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice" style="clear:both;">
      <?php  echo $notice;?>
    </p>
  <?php  endif;?>
    
    
    <div class="dashboard-top">
    
        <h3>Payment Withdraw Request List</h3>

<div class="data-table">
 <div class="table-responsive">
      <table class="table">
        <thead>
        <tr>
          <!--th scope="col">#</th-->
          <th scope="col">User Name</th>
          <th scope="col">ID</th>
          <th scope="col">Amount</th>
          <th scope="col">Fee (5%)</th>
          <th scope="col">Pay Amount</th>
          <th scope="col">Account</th>
          <th scope="col">Date</th>
          <th scope="col">Pay Status</th>
          <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php  
		
		 if($withdraw){
		
		$i = 1; foreach ($withdraw as $member): ?>
            <tr>
              <!--td class="center"><?php  echo ($i + $start) ?></td-->
              <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
              <td><?php  echo $member['my_ref_code'];?></td>
              <td>$<?php  echo $member['amount'];?></td>
              <td>$<?php  echo $member['trans_fee'];?></td>
              <td>$<?php  echo $member['pay_amount'];?></td>
              <td><?php  echo $member['account'];?></td>
              <td><?php  echo $member['date_created'];?></td>
               <td><?php if($member['is_active'] == 1){ echo "Confirmed"; }else{ echo "Not Confirmed"; } ?>
                </td>
              <td>
                <?php if($member['is_active'] != 1){?>
                <a onclick="return confirm('Are you sure to change the payment status?');" href="<?php  echo site_url($module.'/admin/confirmwithdraw/'.$member['id'])?>">Confirm Payment</a>
                <!--| <a onclick="return confirm('Are you sure to delete the payment request?');" href="<?php  echo site_url($module.'/admin/deletewithdraw/'.$member['id'])?>">Delete</a-->
                <?php }?>
                </td>
            </tr>
            <?php  $i++; endforeach;?>
			
		<?php }else{?> <tr>
                  <td colspan="9"><div class="alert alert-danger">No request found.</div></td>
                </tr>
		<?php }?>	
        </tbody>
      </table>
    </div>
 </div>
 </div>
 </div>
 
 
 
</div>