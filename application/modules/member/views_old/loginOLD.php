
<div class="dashboard-main">
<div class="container-fluid">
<div class="login-sec">
<div class="thm-container">
  <div class="login-header">
    <h2>Login</h2>
    <p>Login With Credentials:</p>
  </div>
  <?php if ($notice = $this->session->flashdata('notification')):?>
  <p class="notice"><?php echo $notice;?></p>
  <?php endif;?>
  <p><?php echo validation_errors(); ?></p>
  <form name="loginform" method="POST" action="<?php echo site_url('member/login')?>">
    
    <div class="form-group">
      <label for="exampleInputEmail1">Email</label>
      <input type="text" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email">
    </div>
    
    <div class="form-group">
      <label for="exampleInputEmail1">Password</label>
      <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="Password">
    </div>
    
   
    <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
    <div class="row">
      <div class="col-md-6">
        <a href="<?php echo site_url('member/forgotpassword');?>"><small>Forgot password?</small></a>
      </div>
      <div class="col-md-6 text-right">
          <a href="<?php echo site_url('member/signup');?>"><small>Sign Up</small></a>
      </div>
    </div>
  </form>
</div>
</div>
</div>
</div>
