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
   <div class="float-right"><h2>Register</h2></div>
   </div>
   <div class="pt-2"><p>Sign In With Credentials:</p></div>
   <?php if ($notice = $this->session->flashdata('notification')):?>
    <p class="notice"><?php echo $notice;?></p>
    <?php endif;?>
    <p><?php echo validation_errors(); ?></p>
    <form name="loginform" method="POST" action="<?php echo site_url('member/signup')?>">
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-user"></i></span> </div>
                  <input class="form-control" placeholder="First Name" type="text" name="first_name" value='<?php echo set_value('first_name'); ?>' required>
                </div>
              </div>
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-user"></i></span> </div>
                  <input class="form-control" placeholder="Last Name" type="text" name="last_name" value='<?php echo set_value('last_name'); ?>' required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span> </div>
                  <input class="form-control" placeholder="Email" type="email" name="email" value='<?php echo set_value('email'); ?>' required>
                </div>
              </div>
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span> </div>
                  <input class="form-control" placeholder="Phone" type="text" name="phone" value='<?php echo set_value('Phone'); ?>' required>
                </div>
              </div>
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-user"></i></span> </div>
                  <select class="form-control"  name="type" value='<?php echo set_value('type'); ?>' required>
                    <option>Select Role</option>
                    <?php foreach($roles as $role){?>
                    <option value="<?php echo  $role['id'];?>"><?php echo  $role['type'];?></option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span> </div>
                  <input class="form-control" placeholder="Password" type="password" name="password" value='<?php echo set_value('password'); ?>' required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span> </div>
                  <input class="form-control" placeholder="Confirm Password" type="password" name="passconf" value='<?php echo set_value('passconf'); ?>' required>
                </div>
              </div>
              
              <div class="text-center">
                <button type="submit" name="submit" value="Submit" class="btn btn-warning my-4 btn-block">Sign in</button>
              </div>
            </form>

   
  </div>
 </div>
</div>

<!--login form-->
<!--footer-->
<div class="footer">
<ul class="nav justify-content-center">
<li class="nav-item"><a class="nav-link" href="#">Terms of Service</a></li>
<li class="nav-item"><a class="nav-link" href="#">Privacy Policy</a></li>
<li class="nav-item"><a class="nav-link" href="#">Help</a></li>
</ul>
<p>Copyright © 2019 Zeesoftech . All rights reserved.</p>
</div>



</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
