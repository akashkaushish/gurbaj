<!--body start here-->

<header class="bg-gradient">
  <div class="container mt-5">
    <h1 class="head">Refer Your Freind</h1>
  </div>
</header>
<div class="section light-bg">
  <div class="container">
    <div class="login-content">
      <form action="<?php  echo site_url("invite/referalcode/$r")?>" method="post">
        <div class="form-group">
          <label class="">Thanks For Refering Your Friend</label>
          <input class="form-control" type="hidden" name="referal" value="<?=$r?>" />
        </div>
        <div class="form-group">
          <a class="btn btn-sm btn-success" href="<?php echo base_url().'index.php?invite/referalcode/'.$r;?>">Refer Another Friend</a>
          <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>">Back To Home</a>
        </div>
        <div class="form-group" style="text-align: center;">
          <a class="btn btn-lg btn-primary" href="https://appurl.io/jig1zyrg">Get Blabeey</a>
        </div>
      </form>
    </div>
  </div>
</div>
