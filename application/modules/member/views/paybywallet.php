<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Payment Center</h1>
            <p>Your wallet amount is $<?php echo $userdata['wallet_total']; ?></p>
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
        <?php if($activeplan == 0){ ?>
        <div class="form-content">
          <p>The plan amount is deducted from the your wallet. Plan cost is $<?php echo $plandata['price']; ?></p>
          <p><?php echo validation_errors(); ?></p>
          <form class="form-horizontal" method="POST" action="<?php  echo site_url('member/paybywallet/'.$planid)?>">
            <div class="form-group">
              <label class="col-sm-4 control-label">Plan Price</label>
              <div class="col-sm-8">
                <input type="text" id="transaction_id" name="transaction_id" placeholder="price" value="<?php echo $plandata['price']; ?>"  readonly="" required class="form-control input-solid">
              </div>
            </div>
            <div class="form-group"> </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" name="submit" value="Submit" class="btn btn-default mr-10">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <?php }else{ ?>
        <p  class="alert alert-success"> You already have a active plan associated with this ID.</p>
      <?php } ?>
      </div>
    </div>
  </div>
</div>
<!-- /.End of buy & sell content -->
<footer class="footer">
