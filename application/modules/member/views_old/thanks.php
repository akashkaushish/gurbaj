<div class="page_header" data-parallax-bg-image="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
            <div class="header-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="haeder-text">
                                <h1>Payment Center</h1>
                                
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
                               
                               <div class="form-group">
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
                                </div>
                                
                            	
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                    <a href="<?php echo base_url();?>index.php?/member/dashboard"><button class="btn btn-default mr-10">BACK</button></a>
                                       
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of buy & sell content -->
        <footer class="footer">
            