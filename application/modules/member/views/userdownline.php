<div class="dashboard-main">
  <div class="container-fluid">
    <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice" style="clear:both;">
      <?php  echo $notice;?>
    </p>
    <?php  endif;?>
    <div class="head">
      <h2 class="d-inline-block">Users List</h2>
      <div class="float-right">
        <form class="form-inline float-left mr-3" method="post" action="<?php  echo site_url('member/admin/userdownline/'.$member['id']) ?>">
          <input class="form-control mr-sm-2" type="search" name="mfilter" value="<?php echo $mfilter;?>" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </div>
    <h3><?php echo $member['fname']." ".$member['lname']; ?> Downline</h3>
    <!--div class="right-side-box" style="margin-right:20px;"> Total Commission by Downline: $<?php echo round($totalref, 2); //echo $totalref; ?>, Total Possible commission: $<?php echo round($total_could_be_com, 2); ?></div-->
    <div class="data-table">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Email</th>
              <th scope="col">ID</th>
              <th scope="col">Phone</th>
              <th scope="col">Parent User (ID)</th>
              <!--<th scope="col">Is Paid</th>-->
              <th scope="col">Plan</th>
              <th scope="col">Level</th>
              <th scope="col">Join Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if($downline){?>
            <?php 

							$parentName =[];
							$userid=$member['id'];
							$name=$member['fname'].' '.$member['lname'];;
							$parentName[$userid]= $name;
				  for($i=0;$i<count($downline);$i++){ 
				   
				   // print_r($downline); exit;
							  $userName = $downline[$i]['fname'].' '.$downline[$i]['lname'];
							$parentId = $downline[$i]['id'];
							$refId	= $downline[$i]['ref_id'];
							if(!in_array($parentId, array_keys($parentName))){
							   $parentName[$parentId] = $userName;
							}
							
							 $downline['parentName'] = $parentName[$refId];
							 
					if($refId ==''){ continue;}		 
							 
				  ?>
            <tr>
              <td><?php echo $downline[$i]['fname']." ".$downline[$i]['lname'];  ?></td>
              <?php /*?> <td><?php echo $downline['parentName']; ?></td><?php */?>
              <td><?php echo $downline[$i]['email']; ?></td>
			   <td><?php echo $downline[$i]['my_ref_code']; ?></td>
              <td><?php echo $downline[$i]['phone']; ?></td>
              <td><?php echo $downline['parentName']; ?> (<?php echo $downline[$i]['ref_code_used']; ?>)</td>
             <!-- <td><?php if($downline[$i]['is_premium'] == 1){ echo "Premium"; }else{ echo "Free"; } ?></td>-->
             <td><?php if($downline[$i]['user_plan'] > 0){ echo $this->member_model->get_user_plananame_id($downline[$i]['user_plan']); }else{ echo "No Plan"; } ?></td>
              <td><?php echo $downline[$i]['level_bonus']; ?></td>
              <td><?php echo date('jS M Y',strtotime($downline[$i]['created_date'])); ?></td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
              <td colspan="9"><div class="alert alert-danger">No Data Found According To The Search</div></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
