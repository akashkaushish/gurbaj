<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
            <div class="header-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="haeder-text">
                                <h1>Withdraw Funds</h1>
                                <p>You have total <b>$<?php echo $wallet_total;?></b> in your wallet.</p>
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
                        <?php if($wallet_total > 9){ ?>
                            <form class="form-horizontal" method="POST" action="<?php echo site_url('member/withdrawrequest')?>" >
                                
                               <div class="form-group">
                                    <label class="col-sm-4 control-label">Account Number*</label>
                                    <div class="col-sm-8">
                                    <input type="text" name="account" class="form-control input-solid" placeholder="Account Number"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Amount* $</label>
                                    <div class="col-sm-8">
                                    <input type="text" name="amount" class="form-control input-solid" placeholder="Amount"  required>
                                    </div>
                                </div>
                            	
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="submit" name="submit" value="Submit" class="btn btn-default mr-10">Submit</button>
                                        <a href="<?php echo site_url('member/dashboard');?>" ><button type="button" class="btn btn-orange">Cancel</button></a>
                                    </div>
                                </div>
                            </form>
                            <?php }else{ ?>
                              <div class="alert alert-danger">You do not have enough amount in your wallet to withdraw.</div>
                          <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of buy & sell content -->
        <footer class="footer">
            