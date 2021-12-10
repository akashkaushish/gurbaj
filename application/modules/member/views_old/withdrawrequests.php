<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>My Withdraw Requests</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="dashboard_content">
  <div class="container">
    <div class="row">
      <div class="col-md-12 dataTab">
        <div class="card card-table">
          <div class="card-body table-responsive">
            <div class="float-right" style="margin:10px"> <a href="<?php echo site_url('member/withdrawrequest');?>" class="btn nav-btn btn-orange">Withdraw Funds</a> </div>
			      <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
          <p class="notice" style="clear:both;">
            <?php  echo $notice;?>
          </p>
          <?php  endif;?>
          <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
          <div class="alert alert-success" style="clear:both;">
            <?php  echo $success;?>
          </div>
          <?php  endif;?>
          <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
          <div class="alert alert-danger" style="clear:both;">
            <?php  echo $error;?>
          </div>
          <?php  endif;?>
    
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Account</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($user_withdraws) > 0){ for($i=0;$i<count($user_withdraws); $i++){ ?>
                <tr>
                  <td><?php echo $i+1; ?></td>
                  <td>$ <?php echo $user_withdraws[$i]['amount']; ?></td>
                  <td><?php echo $user_withdraws[$i]['account']; ?></td>
                  <td><?php if($user_withdraws[$i]['is_approved']==0){?>
                    Self Approving pending
                    <?php }else{?>
                    <?php if($user_withdraws[$i]['is_active'] > 0){ echo "Paid"; }else{ echo "Waiting for Admin Approval"; } ?>
                    <?php }?>
                  </td>
                  <td><?php echo $user_withdraws[$i]['date_created']; ?></td>
                  <td><?php if($user_withdraws[$i]['is_approved']==0){?>
                    <a href="<?php echo site_url('member/withdraw/'.$user_withdraws[$i]['id']);?>" class="btn-blue">Verify</a> |
                    <?php }?>
                    <a onclick="return confirm('Are you sure to delete?');" href="<?php echo site_url('member/requestdelete/'.$user_withdraws[$i]['id']);?>" class="btn-orange">Delete</a></td>
                </tr>
                <?php } }else{ ?>
                <tr>
                  <td colspan="6"><div class="alert alert-danger">No request available.</div></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div></div>
      </div>
    </div>
  </div>
</div>
