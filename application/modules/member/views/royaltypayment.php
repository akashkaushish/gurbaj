<section class="pricing-section sec-pad" id="pricing">
  <div class="container-fluid">
    <div class="annual-sales brands-list">
      <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
      <p class="notice" style="clear:both;">
        <?php  echo $notice;?>
      </p>
      <?php  endif;?>
      <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
      <div class="alert alert-success">
        <?php  echo $success;?>
      </div>
      <?php  endif;?>
      <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
      <div class="alert alert-danger">
        <?php  echo $error;?>
      </div>
      <?php  endif;?>
      <?php /*?> <div class="head">
        <h2 class="d-inline-block">Users List</h2>
        <div class="float-right">
          <form class="form-inline float-left mr-3" method="post" action="<?php  echo site_url('member/admin/listall') ?>">
            <input class="form-control mr-sm-2" type="search" name="mfilter" value="<?php echo $mfilter;?>" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </div><?php */?>
      <div class="data-table">
        <div class="table-responsive">
          <table class="table table-bordered table-striped"  id="sampleTable" style="width:100%">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Total Business</th>
                <th scope="col">Level</th>
                <th scope="col">Amount</th>
                <th scope="col">Step</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
			
			<?php if(count($members) > 0){?>
              <?php  $i = 1; foreach ($members as $member): ?>
              <tr>
                <td class="center"><?php  echo ($i + $start) ?></td>
                <td><?php  echo $member['fname'].' '.$member['lname'];?></td>
                <td><?php  echo $member['my_ref_code']?></td>
                <td><?php  echo $member['email']?></td>
                <td><?php  echo $member['total_business'];?></td>
                <td><?php  if($member['first_level'] != ""){ echo $member['first_level']; }else{ echo "--"; } ?></td>
                <td><?php  echo $member['amount'];?></td>
                <td><?php echo $member['step']; ?></td>
                <td><?php echo date('jS M, Y',strtotime($member['date'])); ?></td>
                <td><?php if($member['status'] ==0){?>
                  <a onclick="return confirm('Are you sure to want to pay?');" href="<?php  echo site_url($module.'/admin/payrotalty/'.$member['id'])?>">Pay Royalty</a>
                  <?php }?>
                </td>
              </tr>
              <?php  $i++; endforeach;?>
			  
			   <?php  }else{ ?>
                <tr>
                  <td colspan="10"><div class="alert alert-danger">No request available.</div></td>
                </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="float-right pagination"><?php echo $pager; ?></div>
    </div>
  </div>
  <!-- /.thm-container -->
</section>
