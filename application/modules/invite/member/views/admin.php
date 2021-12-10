<section class="pricing-section sec-pad" id="pricing">
  <div class="container-fluid">
   
    <div class="annual-sales brands-list">
      <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
      <p class="notice" style="clear:both;">
        <?php  echo $notice;?>
      </p>
      <?php  endif;?>
      <div class="head">
        <h2 class="d-inline-block">Users List</h2>
        <div class="float-right">
          <form class="form-inline float-left mr-3" method="post" action="<?php  echo site_url('member/admin/listall') ?>">
            <input class="form-control mr-sm-2" type="search" name="mfilter" value="<?php echo $mfilter;?>" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </div>
	  <div class="data-table">
      <div class="table-responsive">
        <table class="table table-bordered table-striped"  id="sampleTable" style="width:100%">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Phone</th>
              <th scope="col">Ref Code Used</th>
              <th scope="col">Password</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php  $i = 1; foreach ($members as $member): ?>
            <tr>
              <td class="center"><?php  echo ($i + $start) ?></td>
              <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
              <td><?php  echo $member['email']?></td>
              <td><?php  echo "+".$member['countrycode']."-".$member['phone'];?></td>
              <td><?php  if($member['ref_code_used'] != ""){ echo $member['ref_code_used']; }else{ echo "--"; } ?></td>
              <td><?php  echo $this->user->decryptval($member['display_key']);?></td>
              <td><?php if($member['is_active'] == 1){ echo "Active"; }else{ echo "Disabled"; } ?></td>
              <!--td><div class="btn-group">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Choose.. </button>
                  <div class="dropdown-menu"> <a class="dropdown-item" href="<?php  echo site_url($module.'/admin/edit/'.$member['id'])?>">Edit</a> <a class="dropdown-item" onclick="return confirm('Are you sure to delete?');" href="<?php  echo site_url($module.'/admin/deleteuser/'.$member['id'])?>">Delete</a> </div>
                </div></td-->
                <td>
                <?php if($member['is_active'] != 1){?>
                <a onclick="return confirm('Are you sure to activate this user?');" href="<?php  echo site_url($module.'/admin/activateuser/'.$member['id'])?>">Activate</a>
                <?php }?>
                </td>
            </tr>
            <?php  $i++; endforeach;?>
          </tbody>
        </table>
      </div>
	  </div>
    <div class="float-right pagination"><?php echo $pager; ?></div>
    </div>
  </div>
  <!-- /.thm-container -->
</section>
