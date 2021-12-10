<!-- [Left menu] start -->

<div class="main-inner">
  <div class="container"> <br class="clearfloat" />


<div class="leftmenu12">  <i class="icon-bell"></i>

	<h3 id="pageinfo"><?php echo __("Navigation", $module)?></h3>

	<div class="quickend"></div>

</div>

<!-- [Left menu] end -->



<!-- [Content] start -->

<div class="setting">
<h1><?php echo __("Add an administrator", $module)?></h1>
<ul>

			<li><input type="submit" name="submit" value="<?php echo __("Save", $module)?>" class="input-submit" /></li>

			<li><a href="<?php echo site_url('admin/admins')?>" class="input-submit last"><?php echo __("Cancel", $module)?></a></li>

		</ul>
        </div>


<form class="settings" action="<?php echo site_url('admin/admins/save')?>" method="post" accept-charset="utf-8">

		<input type="hidden" name="id" value="<?php echo $admin['id']?>" />

	<hr />

		<div class="settings-info">

		<div id="one">

		

			<label for="username"><?php echo __("Username", $module)?>: </label>

			<input name="username" type='text'  value='<?php echo $admin['username']?>'  class="input-text" />

			<br />

			

			<label for="module"><?php echo __("Module", $module)?>: </label>

			<select name="module" class="input-select" />

			<?php foreach ($this->system->modules as $module) : ?>

			<option value='<?php echo $module['name']?>' <?php echo ($admin['module'] == $module['name'])?'selected':''?>/><?php echo ucfirst($module['name'])?></option>

			<?php endforeach; ?>

			</select>

			<br />

			

			<label for="level"><?php echo __("Level", $module)?>: </label>

			<select name="level" class="input-select" />

			<?php for ($i = 0; $i <= 4; $i++) : ?>

			<option value='<?php echo $i?>' <?php echo ($admin['level'] == $i)?'selected':''?>/><?php echo $levels[$i] ?></option>

			<?php endfor; ?>

			</select>

			

			<br />

		</div>
        </div>

	</form>

</div>
</div>
</div>

<!-- [Content] end -->

