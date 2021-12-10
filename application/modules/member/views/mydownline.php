
<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <!--          <h6 class="h2 text-white d-inline-block mb-0">My Transactions</h6>-->
          <p></p>
		  <h6 class="h2 text-white d-inline-block mb-0">My Total Business = $<?php echo $downline_business; ?></h6><br />
		   <h6 class="h2 text-white d-inline-block mb-0"><?php echo $left_business. " : ".$rest_member_amount ; ?></h6>
       
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">My Downline</h3>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-dark table-flush">
          <thead class="thead-dark">
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
        <div class="float-right pagination"><?php echo $pager; ?></div>
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
