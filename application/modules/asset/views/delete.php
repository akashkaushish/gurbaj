<!-- [Content] start -->
<div class="content wide">

<h1 id="delete"><?php echo "Delete"; ?></h1>

<hr />

<p style="margin-bottom: 2em;"><?php echo sprintf("Do you really want to remove %s from this site? All information about that member will be removed.", $username); ?>

<form class="delete" action="<?php echo site_url('member/admin/delete/'.$username.'/1')?>" method="post">
	<p>
		<input type="button" name="noway" value="<?php echo "No"; ?>" onclick="parent.location='<?php echo site_url('admin/member')?>'" class="input-submit" style="margin-right: 2em;" />
		<input type="submit" name="submit" value="<?php echo "Yes"; ?>" class="input-submit" id="submit" />
	</p>
</form>

</div>
<!-- [Content] end -->