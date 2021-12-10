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
          <li class="active">My Downline</li>
        </ol>
      </div>
    </div> 

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
            <th scope="col">Parent User</th>
            <th scope="col">Is Paid</th>
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
            <td><?php echo $mydownline[$i]['parentfirst']." ".$mydownline[$i]['parentlast']; ?></td>
           <td><?php if($mydownline[$i]['is_paid'] > 0){ echo "Paid"; }else{ echo "Not Paid"; } ?></td>
           <td><?php if($mydownline[$i]['is_paid'] > 0){ echo $this->user->get_plan_name($mydownline[$i]['user_plan']); }else{ echo "--"; } ?></td>
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
 
 
 
</div>