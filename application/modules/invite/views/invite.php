<!--body start here-->

<header class="bg-gradient">
  <div class="container mt-5">
    <h1 class="head">Blabeey</h1>
  	<h5 class="" style="color: white;">Blabeey gives you ability to create 3D representation of you that not only talks and expresses a full array of emotions, but it is also fully animated and brings your fun and exciting messages into the REAL WORLD environment with Augemented Reality implementation. You also have the ability to actually LEAVE your Blavatar anywhere with any message with our amazing “Dual sided” Geotagging feature. This means wherever you leave your Blavatar, your friends will be able to see and interact with it in that location in the real world.</h5>
  	<br>
    <h1 class="head">Join Your Friend On Blabeey</h1>
    <h5 class="" style="color: white;">Get connected to your friend by simply providing your mobile number from which you will sign up, and we will handle the rest.<br>So what are you waiting for, Simply register your number and press Get Blabeey button below to get your very own Blavatar.<br><br></h5>
  </div>
</header>
<div class="section light-bg">
  <div class="container">
    <div class="login-content">
      <form action="<?php  echo site_url('invite/savereferal/')?>" method="post">
        <div class="form-group">
          <label class="">Enter Your Mobile Number</label>
          <input class="form-control" type="text" name="mobile" placeholder="Mobile Number" />
          <input class="form-control" type="hidden" name="referal" value="<?=$r?>" />
        </div>
        <div class="form-group">
          <input class="form-control" type="submit" name="submit" value="Register" />
        </div>

        <div class="form-group" style="text-align: center;">
          <a class="btn btn-lg btn-primary" href="https://appurl.io/jig1zyrg">Get Blabeey</a>
        </div>
      </form>
    </div>
  </div>
</div>
