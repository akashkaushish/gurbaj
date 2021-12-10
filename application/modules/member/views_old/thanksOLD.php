<section class="pricing-section sec-pad" id="pricing">
  <div class="thm-container">
    <div class="sec-title text-center"> <!--span>Welcome to the CrypGrow Payment Center</span-->
      <h2> Welcome to the CrypGrow Payment Center </h2>
    </div>
    <!-- /.sec-title -->
    <!-- /.tab-btn -->
    <div class="login-sec">
      <div class="thm-container" style="text-align:center">
        <div class="login-header">
          <h2>Thanks To Purchase a Plan</h2>
        </div>
        <?php if ($notice = $this->session->flashdata('notification')):?>
        <p class="notice" style="text-align:center"><?php echo $notice;?></p>
        <br />
        <?php endif;?>
        <a class="join-btn" href="<?php echo base_url();?>index.php?/member/dashboard">Back</a> </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.thm-container -->
</section>
<style>    
.join-btn{display: inline-block;
    background: #4c57e5;
    padding: 10.5px 31px;
    color: #FFFFFF;
    text-transform: uppercase;
    border-radius: 20px;
    -webkit-transition: all .4s ease;
    transition: all .4s ease;
}
</style>
