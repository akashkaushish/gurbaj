<div class="dashboard-main">
  <div class="container-fluid">
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
    <div class="dashboard-top">
      <h3>Payment Approval Request List</h3>
      <div class="data-table">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">ID</th>
                <th scope="col">Ref ID</th>
                <th scope="col">Transaction Id</th>
                <th scope="col">Amount</th>
                <th scope="col">Payment Date</th>
                <th scope="col">Start</th>
                <th scope="col">End</th>
                <th scope="col">Plan Name</th>
                <th scope="col">Pay Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php  $i = 1; foreach ($members as $member):  ?>
              <tr>
                <td class="center"><?php  echo ($i + $start) ?></td>
                <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
                <td><?php  echo $member['my_ref_code']?></td>
                <td><?php  echo $member['ref_code_used']?></td>
                <td><?php  echo $member['transaction_id']?></td>
                <td><?php  echo $member['payment_amount'];?></td>
                <td><?php  echo $member['payment_date'];?></td>
                <td><?php  echo $member['plan_activation_date'];?></td>
                <td><?php  echo $member['plan_end_date'];?></td>
                <td><?php  echo $member['plan_name'];?></td>
                <td><?php if($member['is_confirmed'] == 1){ echo "Confirmed"; }else{ echo "Not Confirmed"; } ?>
                </td>
                <td><?php if($member['is_confirmed'] != 1){?>
                  <a onclick="return confirm('Are you sure to change the payment status?');" href="<?php  echo site_url($module.'/admin/confiruserplan/'.$member['id'])?>">Confirm Payment</a> <a onclick="return confirm('Are you sure to delete it?');" href="<?php  echo site_url($module.'/admin/deleteplan/'.$member['id'])?>">Delete Payment</a>
                  <?php }?>
                  <?php 
				   //$user=$this->member_model->get_user_by_id($member['user_id']);				  
				  if($member['is_confirmed'] == 1 && $member['is_level_bonus_paid']==0){?>
                  <a onclick="return confirm('Are you sure to set show commission?');" href="<?php  echo site_url($module.'/admin/bonuslevel/'.$member['id'])?>">Add Show Payment</a>
                  <?php }
                  $exceptuser = array(17, 18, 22, 23, 24, 25,26);
                  ?>
                  
                  <?php  if($member['is_level_bonus_paid']==1 && $member['is_paid']==1  && $member['user_plan']!=0 && $member['is_upcoming_payout_paid']==0 && !in_array($member['user_id'], $exceptuser)){?>
                    <a onclick="return confirm('Are you sure to Pay Upcoming Payout?');" href="<?php  echo site_url($module.'/admin/addupcomingpayout/'.$member['id'])?>">Pay Payout</a>
                  <?php }?>
                  <?php  if($member['is_level_bonus_paid']==1 && $member['is_upcoming_payout_paid']==1){?>---<?php }?>
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
