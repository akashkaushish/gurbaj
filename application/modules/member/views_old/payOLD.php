<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> <!--span>Welcome to the CrypGrow Payment Center</span-->
      <h2> Welcome to the CrypGrow Payment Center </h2>
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
    <div class="login-sec">
      <div class="thm-container">
        <div class="login-header">
          <p>Please transfer the package amount in this account number: <b><?php echo $account_address; ?></b> <br/>
          <img src="https://bitref.com/qr.php?data=<?php echo $account_address; ?>" alt="QR Code" />
          <br/> After that Please enter the Transaction ID in the below textbox. Admin will approve your investment after verification.</p>
        </div>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <p><?php echo validation_errors(); ?></p>
        <form class="settings"  name="myForm" action="<?php  echo site_url('member/pay/'.$planid)?>" method="post" accept-charset="utf-8" >
          <div class="form-group">
            <label for="exampleInputEmail1">Enter Transaction Id</label>
            <input type="text" id="transaction_id" name="transaction_id" class="form-control" placeholder="Enter Transaction Id" reuired>
          </div>
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>
