<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Level Commission</h1>
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
                  <th>Commission Amount ($)</th>
                  <th>Date</th>
                  <th>Commission Percentage (%)</th>
                  <th>By Level</th>
                  <th>By User (ID)</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($bonus) > 0){ for($i=0;$i<count($bonus); $i++){
				      $userdata=$this->member_model->get_user_by_id($bonus[$i]['comm_by_user_id']);
					 
				 ?>
                <tr>
                  <td><?php echo $i+1; ?></td>
                  <td>$ <?php echo $bonus[$i]['commission_amount']; ?></td>
                  <td><?php echo date('jS M Y',strtotime($bonus[$i]['commission_month'])); ?></td>
                  <td><?php echo $bonus[$i]['commission_percentage']; ?></td>
                  <td><?php echo $bonus[$i]['comm_by_level']; ?></td>
                  <td><?php echo $bonus[$i]['comm_by_username']; ?> (<?php echo $userdata['my_ref_code']; ?>)</td>
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
   <div class="float-right pagination"><?php echo $pager; ?></div>
    </div>
  </div>
</div>
