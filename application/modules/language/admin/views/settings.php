<!-- [Left menu] start -->

<div class="main-inner">
  <div class="container"> <br class="clearfloat" />
    
<div class="leftmenu12">  <i class="icon-bell"></i>

	<h3 style="width:77%" id="quicklaunch">Page informations</h3>
	
	<ul class="quickmenu">
		<li><a href="#one"><span><?php echo "General settings";?></span></a></li>
         &nbsp;|&nbsp;
		<li><a href="#two"><span><?php echo "Theme settings";?></span></a></li>
	</ul>
	<div class="quickend"></div>

</div>
<!-- [Left menu] end -->

<!-- [Content] start -->
<div class="content slim1">

      
      	
        
<form class="settings" action="<?php echo site_url('admin/settings')?>" method="post" accept-charset="utf-8">
<div class="setting">
  <h1>Setting</h1>
       <ul>
			<li><input type="submit" name="submit" value="Save Settings" class="input-submit" /></li>
			<li><a href="<?php echo site_url('admin')?>" class="input-submit last">Cancel</a></li>
		</ul>
       </div>
		
<hr />

<div class="settings-info">
		
		<?php if ($notice = $this->session->flashdata('notification')):?>
		<p class="notice"><?php echo $notice;?></p>
		<?php endif;?>
		
		<p><?php echo "Use this page to change the global settings for your site."; ?></p>
		
		<div id="one">
		
			<label for="site_name">Site Name:</label>
			<input type="text" name="site_name" value="<?php echo $this->system->site_name?>" id="site_name" class="input-text" /><br />
		
			<label for="meta_keywords">META keywords:</label>
			<input type="text" name="meta_keywords" value="<?php echo $this->system->meta_keywords?>" id="meta_keywords" class="input-text" /><br />
		
			<label for="description">META description:</label>
			<input type="text" name="meta_description" value="<?php echo $this->system->meta_description?>" id="meta_description" class="input-text" /><br />

			<label for="admin_email">Admin email:</label>
			<input type="text" name="admin_email" value="<?php echo $this->system->admin_email?>" id="admin_email" class="input-text" /><br />
			
			<label for="cache">Output Cache:</label>
			<div id="cache">
				<input <?php if ($this->system->cache == 1):?>checked="checked"<?php endif;?> type="radio" name="cache" value="1" /> On<br />
				<input <?php if ($this->system->cache == 0):?>checked="checked"<?php endif;?> type="radio" name="cache" value="0" /> Off<br />
			</div>
			
			<label for="cache_time">Cache Time:</label>
			<input type="text" name="cache_time" value="<?php echo $this->system->cache_time?>" id="cache_time" class="input-text" /><br />

			<label for="cache">Debug:</label>
			<div id="cache">
				<input <?php if ($this->system->debug == 1):?>checked="checked"<?php endif;?> type="radio" name="debug" value="1" /> On<br />
				<input <?php if ($this->system->debug == 0):?>checked="checked"<?php endif;?> type="radio" name="debug" value="0" /> Off<br />
			</div>
			
		</div>
		<div id="two">
        	
            <label for="theme-folder">Theme Folder:</label>
			<input type="text" name="theme_dir" value="<?php echo $this->system->theme_dir?>" id="theme-folder" class="input-text" /><br class="clear"/>
            
			<label for="theme">Theme:</label>
				<select name="theme" class="input-select" id="theme">
				<?php foreach ($themes as $theme):?>
					<option <?php if ($theme == $this->system->theme):?>selected='selected' <?php endif;?>value="<?php echo $theme?>"><?php echo ucwords(str_replace('_', ' ', $theme))?></option>
				<?php endforeach;?>
				</select><br />
		</div>
		 <div><br /><br /></div>
		<div id="two" class="three">
        	
            <label for="theme-folder">Advertisement CPM:</label>
			<input type="text" name="ads_cpm_cost" value="<?php echo $this->system->ads_cpm_cost; ?>" id="ads_cpm_cost" class="input-text" /><span class="cpm_cost">In USD</span><br class="clear"/>
            
			<label for="cost_per_click">Cost per Click :</label>
			<input type="text" name="cost_per_click" value="<?php echo $this->system->cost_per_click; ?>" id="cost_per_click" class="input-text" /><span class="cpc_cost">In USD </span> <br class="clear"/>

			<label for="ad_cpm_user_percentage">User Advertisement Payment :</label>
				<input type="text" name="ad_cpm_user_percentage" value="<?php echo $this->system->ad_cpm_user_percentage; ?>" id="ad_cpm_user_percentage" class="input-text" /><span class="cpm_percentage">%  per CPM </span> <br class="clear"/>
<?php
$proxy = $this->db->get_where('proxi',array('user'=>'admin'))->result_array()[0];
?>
			<label for="ad_cpm_user_percentage">Geo Approximate :</label>
				<input type="text" name="approximate" value="<?php echo $this->system->approximate; //echo $proxy['proxy']; ?>" id="approximate" class="input-text" />
		</div>


        </div>
	</form>

</div>
  </div>
</div>
<!-- <script>  

  $(document).ready(function(){
    $("#tabs").tabs();
  });

</script> -->
<!-- [Content] end -->
