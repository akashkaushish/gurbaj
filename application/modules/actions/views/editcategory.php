<div class="content slim">
<div class="container">
<h1 id="settings"><?php  echo "Edit Category"; ?></h1>

 <?php
    $is_active = array("0"=>"No","1"=>"Yes");
 ?>

<form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php echo site_url('audio/admin/editcat/'.$id)?>" method="post" enctype="multipart/form-data">
		
		<ul>
			<li><input type="submit" name="submit" value="<?php  echo "Save"; ?>" class="input-submit" /></li>
			<li><a href="<?php echo site_url('audio/admin/adcategorylist')?>" class="input-submit last"><?php  echo "Cancel"; ?></a></li>
		</ul>
		
		<br class="clearfloat" />

		<hr />
		<?php  echo validation_errors(); ?>
		<div id="one">
		
			
			<label for="name"><?php  echo "Name*"; ?>: </label>
			<input id="name" name="name" type='text' value='<?php  echo $category['name']?>' class="input-text" />
			<br>  
			<label for="short_description"><?php  echo "Description*"; ?>: </label>
			<textarea id="short_description" name="short_description"  rows="5" cols="15" class="input-text" ><?php  echo $category['short_description']?></textarea>

			<br>
			<label for="description"><?php  echo "Full Description*"?>: </label>
			<textarea id="description" name="description"  rows="5" cols="15" class="input-text" ><?php  echo $category['description']?></textarea>

			<br>
			<label for="category_image"><?php  echo "Image*"; ?>: </label>
			<input id="category_image" name="category_image" type='file' class="input-text" />
			<br>
			
			<!--  <label for="display_row_no"><?php  echo "Display Row No*"; ?>: </label>
			
			<select id="display_row_no" name="display_row_no" class="form-control" style="width: 150px;">
				<option value="0">-- Select --</option>
				<option value="22">22</option>
				<option value="34">34</option>
				<option value="43">43</option>
				<option value="44">44</option>
			</select>
			<br>

			<label for="display_row_no"><?php  echo "Price*"; ?>: </label>
			<select class="form-control" id="price" name="price">
			<option selected="selected" value="0">Free</option>
			<option value="1">0.99</option>
			<option value="2">1.99</option>
			<option value="3">2.99</option>
			</select>
			<br>	

			<label for="sentiment"><?php  echo "Sentiment"; ?>: </label>
			<select class="form-control" id="sentimentType" name="Sentiment">
			<option value="">--Normal--</option>
			<option value="Happy">Happy</option>
			<option value="Laughing">Laughing</option>
			<option value="Sad">Sad</option>
			<option value="Angry">Angry</option>
			<option value="Crying">Crying</option>
			<option value="Praying">Praying</option>
			<option value="Flirty">Flirty</option>
			</select> 	
			<br>
			<label for="gender_check"><?php  echo "Gender Check*"; ?>: </label>
			<input id="gender_check" name="gender_check" type='checkbox' value='<?php  echo $category['gender_check']?>' class="input-text" />
			<br>
			<label for="have_subcat"><?php  echo "Have Subcategory"; ?>: </label>
			<input id="have_subcat" name="have_subcat" type='checkbox' value='<?php  echo $category['have_subcat']?>' class="input-text" />
			<br> -->

			<label for="is_active"><?php  echo "Is Active"; ?>:</label>
			<select name="is_active">
				<?php foreach($is_active as $key=>$title){
					$selected=($category['is_active']==$key)?"selected='selected'":"";
				   echo "<option value='".$key."' $selected>".$title."</option>";
				}?>			
			</select>
			<br />		
		</div>
	</form>
<script>

  $(document).ready(function(){
    $("#tabs").tabs();
  });

</script>
</div></div>
<!-- [Content] end -->
