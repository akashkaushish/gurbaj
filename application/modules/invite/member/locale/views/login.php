<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Zeesotech</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<meta name="" content="yes" /> 
<meta name="" content="grey" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" /> 
<meta name="viewport" content="width=device-width">
<link href="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/css/style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700"rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div class="login-section">
<!--body-->
<div class="container-fluid main-contain">

<!--login form-->
<div class="form-container">
 <div class="card p-4">
   <div class="head-section">
   <div class="float-left"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/logo1.png" alt=""></div> 
   <div class="float-right"><h2>Login</h2></div>
   </div>
   <div class="pt-2"><p>Sign In With Credentials:</p></div>
   <?php if ($notice = $this->session->flashdata('notification')):?>
    <p class="notice"><?php echo $notice;?></p>
    <?php endif;?>
    <p><?php echo validation_errors(); ?></p>
  <form name="loginform" method="POST" action="<?php echo site_url('member/login')?>">
  <div class="form-group">
    <label for="exampleFormControlInput1">Username* </label>
    <input type="text" class="form-control" name="email" id="inputPassword" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Password* </label>
    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
  </div>
  <!--div class="custom-control custom-control-alternative custom-checkbox">
    <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
      <label class="custom-control-label mt-1" for=" customCheckLogin">
        <span class="text-muted">Remember me</span>
      </label>
  </div-->
  <div class="form-group">
  <button type="submit" name="submit" value="Submit" class="btn btn-success my-4 btn-block">Sign in</button>
  </div>
</form>
<div class="row">
   <div class="col-6">
    <a href="#" class="text-dark"><p>Forgot password?</p></a>
   </div>
   <div class="col-6 text-right">
     <a href="<?php echo site_url('member/signup')?>" class="text-dark"><p>Create new account</p></a>
   </div>
  </div>
 </div>
</div>

<!--login form-->


</div>
<!--body end-->

<!--footer-->
<div class="footer">
<ul class="nav justify-content-center">
<li class="nav-item"><a class="nav-link" href="#">Terms of Service</a></li>
<li class="nav-item"><a class="nav-link" href="#">Privacy Policy</a></li>
<li class="nav-item"><a class="nav-link" href="#">Help</a></li>
</ul>
<p>Copyright © 2019 Zeesoftech . All rights reserved.</p>
</div>
<!--footer end-->
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
