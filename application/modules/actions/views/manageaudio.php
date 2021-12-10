<!--audio start here-->
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
			
			<li><a href="<?php  echo site_url('audio/admin/createnewaudio')?>" class="input-submit last"><?php  echo "Create new";?></a></li>
		</ul>
  </div>
 
   <div class="subscribe-main">
   <h1>audio</h1>
	
   <?php if(count($manageaudio) >0) { ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th><?php  echo "Title"; ?></th>
				<th><?php  echo "Audio"; ?></th>
				<th colspan="2"><?php echo "Action"; ?></th>
			</tr>
		</thead> 
	<tbody>
	<?php 
	$i = 1;   
   foreach($manageaudio as $audioData): 
	   
   $audioName = $audioData['audio_image'];
   ?>
		<tr>
			<td><?php  echo ($i + $start) ?></td>
			<td><?php  echo $audioData['audio_title'];?></td>
			
			<td><?php  if($audioName !="") {	?>
				 <audio controls>
				  <source src="<?php echo base_url()."/media/audioimage/".$audioName;?>" type="audio/ogg">
				  <source src="<?php echo base_url()."/media/audioimage/".$audioName;?>" type="audio/mpeg">				  
				</audio>
			<?php
			
			} else{ echo "No file"; } ?></td>		
			<td><?php  echo ($audioData['is_active']==1)?"Active":"Not Active";?></td>
			<td><a onclick="return confirm('Are you sure to delete?');" href="<?php echo site_url($module.'/deleteaudio/'.$audioData['id'])?>"><?php  echo "Delete"; ?></a></td>
		</tr>
    <?php  $i++; endforeach;  ?>
		 </tbody>
	</table>
	<?php
   }
   else{
   ?>
    <div class="subscribe-person"> No audio exist </div>
   <?php   
   }	
   ?>
	<div class="pagging-new"><ul><?php  echo $pager?></ul></div>
  </div>
  
</div>
<!--audio end here-->
