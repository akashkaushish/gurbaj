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
          <div class="card-header"> Total Commission by Downline: $<?php echo round($totalref, 2); ?>
            <!--, Total Possible commission: $<?php echo round($total_could_be_com, 2); ?> -->
          </div>
          <div class="card-body table-responsive">
            <table class="table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">ID</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Parent User ID</th>
                  <!-- <th scope="col">On Level </th>-->
                  <th scope="col">Plan</th>
                  <th scope="col">Level</th>
                  <th scope="col">Join Date</th>
                  <th scope="col">Next Level</th>
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
                <tr class="<?php echo $downline[$i]['id']?>">
                  <td><?php echo $downline[$i]['fname']." ".$downline[$i]['lname'];  ?></td>
                  <td><?php echo $downline[$i]['email']; ?></td>
                  <td><?php echo $downline[$i]['my_ref_code']; ?></td>
                  <td><?php echo $downline[$i]['phone']; ?></td>
                  <td><?php echo $downline['parentName']; ?> (<?php echo $downline[$i]['ref_code_used']; ?>)</td>
                  <td><?php if($downline[$i]['user_plan'] > 0){ echo $this->member_model->get_user_plananame_id($downline[$i]['user_plan']); }else{ echo "No Plan"; } ?></td>
                  <td>1</td>
                  <td><?php echo date('jS M Y',strtotime($downline[$i]['created_date'])); ?></td>
                  <td><input type="button" class="nextbutton" onclick="GetNextLevel('<?php echo $downline[$i]['id'];?>','1')"  id="<?php echo $downline[$i]['id']?>" value="+"/></td>
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
<script>
function GetNextLevel(userid,level){ 
$(document).ready(function(){
    $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>index.php?/member/getnextlevel",
	data: {user_id:userid,level:level},
    success: function(data){
	 $( data).insertAfter( "."+userid);
	 $('#'+userid).hide();
    }
   });
  });
}

</script>
