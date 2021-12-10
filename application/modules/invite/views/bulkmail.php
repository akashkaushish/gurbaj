<main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-th-list"></i> Select Members For Mail</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Bulk Mail Members List</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <?php /*?><div class="row">
          <form action="<?php  echo site_url($this->uri->uri_string()) ?>" method="post" name="myform" class="myform" style="width:100%">
            <div class="col-sm-12  col-md-6 col-xl-6 float-left">
              <div class="dataTables_length" id="sampleTable_length">
                <label>Sort By
                <select name="sorting" class="form-control form-control-sm"onchange="javascript:submitdata();">
                  <option value="" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='')){?>selected<?php }?>>Sort Data</option>
                  <option value="registered" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='registered')){?>selected<?php }?>>By Register Date</option>
                  <option value="name" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='name')){?>selected<?php }?>>By Name</option>
                </select>
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-6 float-right">
              <div id="sampleTable_filter" class="dataTables_filter">
                <label>Search:
                <input type="text" class="input-text" name="filter" value="<?php  echo $this->input->post('filter') ?>" />
                &nbsp;
                <input type="submit" class="input-submit" id="submit" name="submit" value="<?php  echo "Search"; ?>" />
                <!-- <input class="form-control form-control-sm" placeholder="" aria-controls="sampleTable" type="search">-->
                </label>
              </div>
            </div>
          </form>
        </div><?php */?>   
        
        <?php  if($members) : ?>

        <h5 style="margin-bottom: 5px;">Select Mail Template</h5>
        <select id="selectedtemp" class="form-control" style="margin-bottom: 40px;">
          <option >Select Mail Template</option>
          <?php foreach ($mails as $m) { ?>
            <option value="<?=$m['id']?>"><?=$m['subject']?></option>
          <?php } ?>
        </select>
        <table>
          <tr>
            <td style="padding-left: 10px;padding-bottom: 35px;">Select All Users :</td>
            <td style="padding-left:60px;padding-bottom:35px;"><input type="checkbox" name="nusermail" id="all" class="chkboxx" value="all"/></td>
          </tr>
        </table>
        <!-- <h5 style="margin-bottom: 5px;">Select All Users</h5>
        <input type="checkbox" name="all" id="all" /> -->
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th width="3%" class="center">#</th>
              <th width="15%"><?php  echo "Name"; ?></th>
              <th width="20%"><?php  echo "Email"; ?></th>
              <th width="15%"><?php  echo "Phone"; ?></th>
              <th width="15%"><?php  echo "Register Date"; ?></th>
              <th width="15%"><?php  echo "Birthday"; ?></th>
              <th width="15%"><?php  echo "Login Count"; ?></th>
              <th width="5%" ><?php  echo "Select"; ?></th>
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
              <td><input type="checkbox" name="usermail" id="<?=$member['id']?>" class="chkboxx" value="<?=$member['email']?>"/></td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
        <button type="submit"  name="sendmail" value="<?php  echo "Send Mail";?>" class="btn btn-primary" id="sendmail" style="margin-top: 22px;">
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Send Mail
            </button>
        <?php  else: ?>
        <?php  echo "No member found"; ?>
        <?php  endif ; ?>
        <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
          <ul class="pagination">
            <?php  //echo $pager;?>
          </ul>
        </div>
      </div>
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
