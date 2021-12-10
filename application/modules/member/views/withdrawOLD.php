<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> 
      <h2> Withdraw Funds: You have total $<?php echo $wallet_total;?> in your wallet.</h2>
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
    <div class="login-sec">
      <div class="thm-container">
        <div class="login-header">
<?php if($wallet_total > 9){ ?> <p>Submit form with credentials:</p>  <?php } ?>
        </div>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <p><?php echo validation_errors(); ?></p>
        <?php if($wallet_total > 9){ ?>
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/withdraw')?>" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="exampleInputEmail1">Account Number*</label>
            <input type="text" name="account" class="form-control" placeholder="Account Number"  required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Amount*</label>
            <input type="text" name="amount" class="form-control" placeholder="Amount"  required>
          </div>
          
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
        <?php }else{ ?>
          <div class="form-group">
            <label for="exampleInputEmail1">You do not have enough amount in your wallet to withdraw.</label>
            
          </div>
          <?php } ?>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>