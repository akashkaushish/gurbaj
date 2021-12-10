<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>My Downline</h1>
            <p>My Total Business = $<?php echo $downline_business; ?></p>
            <p><?php echo $left_business. " : ".$rest_member_amount ; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="dashboard_content">
  <div class="container">
    <div class="row">
      <div class="col-md-12 dataTab">
        <div class="card card-table">
          <div class="card-header"> Total Commission by Downline: $<?php echo round($totalref, 2); ?> <!--, Total Possible commission: $<?php echo round($total_could_be_com, 2); ?> --></div>
          <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">ID</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Parent User ID</th>
                  <!-- <th scope="col">On Level </th>-->
                  <th scope="col">Plan</th>
                  <th scope="col">Open Level</th>
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
                  <?php /*?>    <td><?php echo $i+1; ?></td><?php */?>
                  <td><?php if($downline[$i]['user_plan'] > 0){ echo $this->member_model->get_user_plananame_id($downline[$i]['user_plan']); }else{ echo "No Plan"; } ?></td>
                  <td><?php if($downline[$i]['level_bonus'] > 8){echo "7";}else{echo $downline[$i]['level_bonus'];} ?></td>
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
        <div></div>
      </div>
    </div>
  </div>
</div>
