<!--body start here-->
<div class="container">
  <div class="wrap">
    <ul class="breadcrumb">
      <li>Home <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li>My Account <span class="divider"><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/arrow.png" alt=""></span></li>
      <li><a href="" class="aciveurl-breadcrumb">Products</a> </li>
    </ul>
  </div>
</div>
<div class="container">
  <div class="topbutton">
     <ul>
			
			<li><a href="<?php  echo site_url('bodies/createnewbody')?>" class="input-submit last"><?php  echo "Create new Body"; ?></a></li>
		</ul>
  </div>
 
   <div class="subscribe-main">
   <h1>Bodies</h1>
	
   <?php if(count($managebody) >0) { ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th><?php  echo "Title"; ?></th>
				<th><?php  echo "Body Image"; ?></th>
				<th colspan="2"><?php echo "Action"; ?></th>
			</tr>
		</thead> 
	<tbody>
	<?php 
	$i = 1;   
   foreach($managebody as $bodyData): 
	   
   $imageName = $bodyData['body_image'];
   ?>
		<tr>
			<td><?php  echo ($i + $start) ?></td>
			<td><?php  echo $bodyData['body_title'];?></td>
			<td><?php  echo $bodyData['body_image'];?></td>
			<td><?php  if($imageName !="") {echo "<img src ='".base_url()."/media/body/thumb/".$imageName."'";} else{ echo "No Image"; } ?></td>		
			<td><?php  echo ($bodyData['is_active']==1)?"Active":"Not Active";?></td>
			<td><a onclick="return confirm('Are you sure to delete?');" href="<?php echo site_url($module.'/deletebody/'.$bodyData['id'])?>"><?php  echo "Delete"; ?></a></td>
		</tr>
    <?php  $i++; endforeach;  ?>
		 </tbody>
	</table>
	<?php
   }
   else{
   ?>
    <div class="subscribe-person"> No Body exist </div>
   <?php   
   }	
   ?>
	<div class="pagging-new"><ul><?php  echo $pager?></ul></div>
  </div>
  
</div>
<!--body end here-->
