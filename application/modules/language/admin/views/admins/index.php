
<div class="main-inner">
  <div class="container"> <br class="clearfloat" />

<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- [Left menu] start -->

<!-- [Content] start -->
<div class="leftmenu12">  <i class="icon-bell"></i>


<h3 style="width:77%" id="page"><?php echo "Administrators"?></h3>



<ul class="quickmenu">

	<li><a href="<?php echo site_url('admin/admins/create')?>" class="first"><?php echo "Add new"?></a></li>
     &nbsp;|&nbsp;
	<li><a href="<?php echo site_url('admin')?>" class="last"><?php echo "Cancel"?></a></li>

</ul>

	</div>	

<br class="clearfloat" />



<hr />

<div class="administrators">



<?php if ($notice = $this->session->flashdata('notification')):?>

<p class="notice"><?php echo $notice;?></p>

<?php endif;?>



<p><?php echo "Here you can see who is managing what."?></p>



<?php if(is_array($admins)) : ?>

<table class="page-list">

	<thead>

		<tr>

				<th width="3%" class="center">#</th>

				<th width="20%"><?php echo "Username"?></th>

				<th width="37%"><?php echo "Level"?></th>

				<th width="40%" colspan="2"><?php echo "Action"?></th>

		</tr>

	</thead>

	<tbody>

<?php $i = 1; $currentmodule = '' ?>



<?php foreach ($admins as $admin): ?>

<?php if ($admin['module'] != $currentmodule) : ?>

<?php $i = 1; $currentmodule = $admin['module'] ;?>

<tr>

	<td colspan="5"><strong><?php echo "Module name"?>: <?php echo ucfirst($admin['module'])?></strong></td>

</tr>

<?php endif;?>

<?php if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>

		<tr class="<?php echo $rowClass?>">

				<td class="center"><?php echo $i?></td>

				<td><?php echo $admin['username']?></td>

				<td><?php echo $admin['level']?></td>

				

				<td>

				

				<a href="<?php echo site_url('admin/admins/edit/'. $admin['id'])?>"><?php echo "Edit"?></a>

				</td>

				<td>

				<a href="<?php echo site_url('admin/admins/delete/'. $admin['id'])?>"><?php echo "Delete"?></a>

				</td>

		</tr>

<?php $i++; endforeach;?>

	</tbody>

</table>

<?//=$pager?>

<?php endif; ?>

</div>

</div>
</div>

<!-- [Content] end -->



