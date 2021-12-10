<div class="dashboard-main">
  <div class="container-fluid">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
            <p class="notice" style="clear:both;">
              <?php  echo $notice;?>
            </p>
            <?php  endif;?>
    
        <h3>My Downline</h3>
<div class="right-side-box" style="margin-right:20px;"> Total Commission by Downline: $<?php echo round($totalref, 2); //echo $totalref; ?>, Total Possible commission: $<?php echo round($total_could_be_com, 2); ?></div>
<div class="data-table">
 <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Level</th>
            <th scope="col">Plan</th>
            <th scope="col">Join Date</th>
            
          </tr>
        </thead>
        <tbody>
          <?php for($i=0;$i<count($mydownline); $i++){ ?>
          <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $mydownline[$i]['fname']." ".$mydownline[$i]['lname']; ?></td>
            <td><?php echo $mydownline[$i]['email']; ?></td>
            <td><?php echo $mydownline[$i]['phone']; ?></td>
            <td>First Level</td>
           <td><?php echo $this->user->get_plan_name($mydownline[$i]['user_plan']); ?></td>
           <td><?php echo $mydownline[$i]['created_date']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
 </div>
 </div>
 </div>
 
 
 
</div>