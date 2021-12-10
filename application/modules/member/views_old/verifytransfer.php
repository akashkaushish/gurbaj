<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Transfer Funds Verification To Your Friend</h1>
            <p>Wallet Amount: <b>$
              <?php  echo round($totalwallet, 2);  ?>
              </b></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="buySell_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-md-offset-2">
        <div class="form-content">
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
        <p><?php echo validation_errors(); ?></p>
        <form class="form-horizontal" method="POST" action="<?php echo site_url('member/verifytransfer')?>" >
          <div class="form-group">
            <label class="col-sm-4 control-label">Enter Verification Code*</label>
            <div class="col-sm-8">
              <input type="text" name="verificationcode" class="form-control input-solid" placeholder="Verification Code" required>
            </div>
          </div>
          </div> 
          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" name="submit" value="Submit" class="btn btn-default mr-10">Submit</button>
              <a href="<?php echo site_url('member/dashboard');?>" >
              <button type="button" class="btn btn-orange">Cancel</button>
              </a> </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /.End of buy & sell content -->
<footer class="footer">
