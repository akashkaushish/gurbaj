<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Payment Center</h1>
            <p>Welcome to the CrypGrow Payment Center.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
	<?php 
	$color='#212181';
	$address=$account_address;
	$logo =  '1.png' ;
	$imgdata=$this->user->getblabtagimage($logo,$address,$color);
	
	?>
<div class="buySell_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-md-offset-2">
        <div class="form-content">
        <?php if($activeplan == 0){ ?>
          <p>Please transfer the plan amount in this account number: </p>
          <p><b><?php echo $account_address; ?></b> </p>
          <p>
            <?php /*?><img src="https://bitref.com/qrcode.php?data=<?php echo $account_address; ?>" alt="QR Code" /><?php */?>
            <img class="d-block" alt="" src="<?php echo SITEURL;?>script/phpqrcode/temp/<?php echo $imgdata;?>" width="300px;"> </p>
          <p>After that Please enter the Transaction ID in the below textbox. Admin will approve your investment after verification.</p>
          <?php } ?>
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
          <?php if($activeplan == 0){ ?>
          <form class="form-horizontal" method="POST" action="<?php  echo site_url('member/pay/'.$planid)?>">
            <div class="form-group">
              <label class="col-sm-4 control-label">Enter Transaction ID</label>
              <div class="col-sm-8">
                <input type="text" id="transaction_id" name="transaction_id" placeholder="Transaction ID" required class="form-control input-solid">
                <i>In case of cash, Please enter Transaction Id as: 'Cash by John'</i> </div>
            </div>
            <div class="form-group"> </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" name="submit" value="Submit" class="btn btn-default mr-10">Submit</button>
              </div>
            </div>
          </form>
          <?php }else{ ?>
            <p  class="alert alert-success"> You already have a active plan associated with this ID.</p>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.End of buy & sell content -->
<footer class="footer">
