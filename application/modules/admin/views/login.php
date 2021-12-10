<div class="dashboard-main">
<div class="container-fluid">
<div class="login-sec">
<div class="thm-container">
  <div class="login-header">
    <h2>Login</h2>
    <p>Login With Credentials:</p>
  </div>
  <form name="loginform" method="POST" action="<?php echo site_url('admin/login')?>">
    
    <div class="form-group">
      <label for="exampleInputEmail1">Username*</label>
      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" name="username">
    </div>
    
    <div class="form-group">
      <label for="exampleInputEmail1">Password</label>
      <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="Password">
    </div>
    
   
    <button type="submit" name="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
    
  </form>
</div>
</div>
</div>
</div>
