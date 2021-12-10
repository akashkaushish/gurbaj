<!--login form-->

<div class="form-container">
  <div class="card p-4">
    <div class="head-section">
      <div class="float-left"><img src="<?php echo base_url()?>application/views/themes/admin/images/logo1.png" alt=""></div>
      <div class="float-right">
        <h2>Login</h2>
      </div>
    </div>
    <div class="pt-4">
      <?php if ($notice = $this->session->flashdata('notification')):?>
      <span class="notice"><?php echo $notice;?></span>
      <?php endif;?>
    </div>
    <form class="login-form" method="post" action="<?php echo site_url('admin/login')?>">
      <div class="form-group">
        <label for="exampleFormControlInput1">Username* </label>
        <input class="form-control" type="text" placeholder="Username" name="username" autofocus>
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Password* </label>
        <input class="form-control" type="password" name="password"  id="inputPassword" placeholder="Password">
      </div>
      <!-- <div class="custom-control custom-control-alternative custom-checkbox">
            <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
            <label class="custom-control-label mt-1" for=" customCheckLogin"> <span class="text-muted">Remember me</span> </label>
          </div>-->
      <div class="form-group">
        <button type="submit" value="Login &raquo;" name="submit" class="btn btn-success my-4 btn-block" >Sign in</button>
      </div>
    </form>
    <!-- <div class="row">
      <div class="col-6"> <a href="#" class="text-dark">
        <p>Forgot password?</p>
        </a> </div>
      <div class="col-6 text-right"> <a href="signup.html" class="text-dark">
        <p>Create new account</p>
        </a> </div>
    </div>-->
  </div>
</div>
<!--login form-->
<?php /*?><section class="material-half-bg">
  <div class="cover"></div>
</section>
<section class="login-content">
<div class="logo">
  <h1>ZeesoTech</h1>
</div>
<div class="login-box">
  <form class="login-form" method="post" action="<?php echo site_url('admin/login')?>">
    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
    <?php if ($notice = $this->session->flashdata('notification')):?>
    <span class="notice"><?php echo $notice;?></span>
    <?php endif;?>
    <div class="form-group">
      <label class="control-label">USERNAME</label>
      <input class="form-control" type="text" placeholder="Username" name="username" autofocus>
    </div>
    <div class="form-group">
      <label class="control-label">PASSWORD</label>
      <input class="form-control" type="password" name="password" placeholder="Password">
    </div>
    <div class="form-group btn-container">
      <!--  <input type="submit" name="submit" value="Login &raquo;" id="submit" class="input-submit" />-->
      <button class="btn btn-primary btn-block" type="submit" value="Login &raquo;" name="submit" ><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
    </div>
  </form>
  <form class="forget-form" action="<?php echo site_url('admin/forgotpassword')?>" method="post">
    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
    <div class="form-group">
      <label class="control-label">EMAIL</label>
      <input class="form-control" type="text" placeholder="Email" name="email">
    </div>
    <div class="form-group btn-container">
      <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
    </div>
    <div class="form-group mt-3">
      <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
    </div>
  </form>
</div>
<?php */?>
