<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> 
      <h2> Transfer Funds To Your Friend</h2>
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
    <div class="login-sec">
      <div class="thm-container">
        <div class="login-header">
          <p>Wallet Amount: <b>$<?php  echo round($totalwallet, 2);  ?></b></p>
        </div>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="clear:both;">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <p><?php echo validation_errors(); ?></p>
        <form class="settings" onsubmit="return validateForm()" enctype="multipart/form-data" name="myForm" action="<?php echo site_url('member/transfer')?>" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="exampleInputEmail1">Recipient Email*</label>
            <input type="text" id="transaction_id" name="email" class="form-control" placeholder="Email of recipient" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Amount*</label>
            <select name="amount" class="form-control">
            <option value="">Choose Amount</option>
              <?php for($i=0;$i<count($plans);$i++){ ?>
              <option value="<?php echo $plans[$i]['price']; ?>"><?php echo $plans[$i]['price']; ?></option>
              <?php } ?>
            </select>
          </div>
          
          <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
        </form>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>