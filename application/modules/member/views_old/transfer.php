<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Transfer Funds To Your Friend</h1>
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
          <form class="form-horizontal" method="POST" action="<?php echo site_url('member/transferrequest')?>" >
            <div class="form-group">
              <label class="col-sm-4 control-label">Recipient ID*</label>
              <div class="col-sm-8">
                <input type="text" name="email" class="form-control input-solid" placeholder="Recipient ID" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Amount* $</label>
              <div class="col-sm-8">
                <select name="amount" class="form-control">
                  <option value="">Choose Amount</option>
				   <option value="5">5</option>
				   <option value="10">10</option>
				   <option value="15">15</option>
				   <option value="20">20</option>
				   <option value="25">25</option>
				   <option value="30">30</option>
				   <option value="35">35</option>
				   <option value="40">40</option>
				   <option value="45">45</option>
				   <option value="50">50</option>
				   <option value="55">55</option>
				   <option value="60">60</option>
				   <option value="65">65</option>
				   <option value="70">70</option>
				   <option value="75">75</option>
				   <option value="80">80</option>
				   <option value="85">85</option>
				   <option value="90">90</option>
				   <option value="95">95</option>
                  <?php for($i=0;$i<count($plans);$i++){ ?>
                  <option value="<?php echo $plans[$i]['price']; ?>"><?php echo $plans[$i]['price']; ?></option>
                  <?php } ?>
                </select>
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
