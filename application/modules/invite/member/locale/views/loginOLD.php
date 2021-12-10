<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Zeesotech</title>
  <!-- Favicon -->
  <link href="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/css/all.min.css" rel="stylesheet">
  <!-- main CSS -->
  <link type="text/css" href="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/css/style.css" rel="stylesheet">
</head>

<body class="bg-default">
  <div class="main-content">
    <div class="header py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-4">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
			  <a class="navbar-brand" href="index.html"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/logo1.png" /></a>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-1">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
		  <div class="card-header bg-transparent pb-3">
              <div class="text-muted text-center mt-2 mb-3"><h3>Login</h3></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Sign In With Credentials</small>
              </div>
              <?php if ($notice = $this->session->flashdata('notification')):?>
              <p></p>
                <p class="notice"><?php echo $notice;?></p>
                <?php endif;?>
            
                <p><?php echo validation_errors(); ?></p>
                <form name="loginform" method="POST" action="<?php echo site_url('member/login')?>">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="Username" name="email" value='<?php echo set_value('email'); ?>'>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" name="password" value='<?php echo set_value('password'); ?>'>
                  </div>
                </div>
                <!--div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div-->
                <div class="text-center">
                  <button type="submit" name="submit" value="Submit" class="btn btn-warning my-4 btn-block">Sign in</button>
                </div>
              </form>
			<div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-dark"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="<?php echo site_url('member/signup')?>" class="text-dark"><small>Create new account</small></a>
            </div
          </div>
            </div>
			
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-12">
          <div class="copyright text-center text-light">
            Copyright &copy; 2019 Zeesoftech . All rights reserved. 
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- Optional JS -->
  <script src="js/Chart.min.js"></script>
  <script src="js/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="js/common.js"></script>
</body>

</html>