<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
		      <div class="haeder-text">
            <h1>Royalty</h1>
            <p>My Total Business = $<?php echo $downline_business; ?></p>
            <p><?php echo $left_business. " : ".$rest_member_amount ; ?></p>
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
          <div class="card-header">
            <h4>Royalty Reward</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Reward Level</th>
                  <th>Business</th>
                  <th>Direct Downline</th>
                  <th>Amount</th>
                  <th>Left Business</th>
                  <th>Right Business</th>
                  <th>ID (Left)</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Paid Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($my_royalty) > 0){ for($i=0;$i<count($my_royalty); $i++){ ?>
                <tr>
                  <td><?php echo $my_royalty[$i]['step']; ?></td>
                  <td><?php echo $my_royalty[$i]['total_business']; ?></td>
                  <td><?php echo $my_royalty[$i]['first_level']; ?></td>
                  <td><?php echo $my_royalty[$i]['amount']; ?></td>
                  <td><?php echo $my_reward[$i]['first_chain_business']; ?></td>
                  <td><?php echo $my_reward[$i]['rest_chain_business']; ?></td>
                  <td><?php echo $this->user->get_id_by_userid($my_reward[$i]['first_chain_user_id']); ?></td>
                  <td><?php echo $my_royalty[$i]['date']; ?></td>
                  <td><?php if($my_royalty[$i]['status'] == 1){ echo "Paid"; }else if($my_royalty[$i]['status'] == 0){ echo "Waiting for Approcal";} else{ echo "Contact Admin"; } ?></td>
                  <td><?php echo $my_royalty[$i]['paid_date']; ?></td>
                </tr>
                <?php } }else{ ?>
                <tr>
                  <td colspan="10"><div class="alert alert-danger">No Royalty Reward grabbed yet.</div></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div>
      </div>

    
    
      </div>
    </div>
  </div>
</div>
