<div class="container">
<div class="content wide">
  <h1 id="page">
    <?php  echo "Member administration" ;?>
  </h1>
  <!--<ul class="manage">
	<li><a href="<?php  echo site_url('admin/member/create')?>"><?php  echo "Add a new user";?></a></li>
	<li><a href="<?php  echo site_url('admin')?>" class="last"><?php  echo "Cancel";?></a></li>
</ul> -->
  <br class="clearfloat" />
  <hr />
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <table style="width:100%">
    <form action="<?php  echo site_url($this->uri->uri_string()) ?>" method="post" name="myform" class="myform" >
      <tr>
        <td></td>
        <td width="20%"><input type="text" class="input-text" name="filter" value="<?php  echo $this->input->post('filter') ?>" />
        </td>
        <td><input type="submit" class="input-submit" id="submit" name="submit" value="<?php  echo "Search"; ?>" />
        </td>
        <td align="right"><select name="sorting" onchange="javascript:submitdata();">
            <option value="" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='')){?>selected<?php }?>>Sort Data</option>
            <option value="registered" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='registered')){?>selected<?php }?>>By Register Date</option>
            <option value="name" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='name')){?>selected<?php }?>>By Name</option>
          </select>
        </td>
      </tr>
    </form>
  </table>
  <?php  if($members) : ?>
  <table class="page-list">
    <thead>
      <tr>
        <th width="3%" class="center">#</th>
        <th width="15%"><?php  echo "Name"; ?></th>
        <th width="20%"><?php  echo "Email"; ?></th>
        <th width="15%"><?php  echo "Phone"; ?></th>
        <th width="15%"><?php  echo "Register Date"; ?></th>
        <th width="15%"><?php  echo "Birthday"; ?></th>
        <th width="15%"><?php  echo "Login Count"; ?></th>
        <th width="30%" colspan="2"><?php  echo "Action"; ?></th>
      </tr>
    </thead>
    <tbody>
      <?php  $i = 1; foreach ($members as $member): ?>
      <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
      <tr class="<?php  echo $rowClass?>">
        <td class="center"><?php  echo ($i + $start) ?></td>
        <td><?php  echo $member['name'];?></td>
        <td><?php  echo $member['email']?></td>
        <td><?php  echo $member['phone'];?></td>
        <td><?php  echo $member['registered']?></td>
        <td><?php  echo $member['birthday'];?></td>
        <td><?php  echo $member['login_count']?></td>
        <td><a href="<?php  echo site_url($module.'/admin/edit/'.$member['id'])?>">
          <?php  echo "Edit"; ?>
          </a></td>
        <td><a onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteuser/'.$member['id'])?>">
          <?php  echo "Delete"; ?>
          </a></td>
      </tr>
      <?php  $i++; endforeach;?>
    </tbody>
  </table>
  <?php  else: ?>
  <?php  echo "No member found"; ?>
  <?php  endif ; ?>
  <div class="pagging-new">
    <ul>
      <?php  echo $pager?>
    </ul>
  </div>
</div>
</div>
<script>
		function submitdata(){ 
			$(document).ready(function () {
			     $("#submit").click();
			});
		
		}
	</script>
<!-- [Content] end -->
