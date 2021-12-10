<!--body start here-->
<style>
body{ margin:0px; padding:0px;}
.center{ padding-top:10px; text-align:center; clear:both;}
.subscribe-main h2 {
    color: #3b5998;
    font-size: 14px;
    font-weight: bold;
	margin-top:0px;
	text-align:justify;
	margin-bottom:10px;
}
.subscribe-main h1 {
    color:#1c5394;
    font-size:28px;
    font-weight: bold;
    padding-bottom: 6px;
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 6px;
    text-transform: uppercase;
	font-family:Arial, Helvetica, sans-serif;
	margin-bottom:30px;

	text-align:center;
}

.media-aset {
    color: #636465;
    float: left;
    font-size: 13px;
    width:95%;
	font-family:Arial, Helvetica, sans-serif; border-top:0px;
}

		  .media-aset span{margin-bottom:10px; display:block; width:100%; margin-top:20px;}
		  .popup-right{width:44%; float:right; padding:10px; text-align:left;}
		  .popup-left{width:50%; float:left; height:100%; display:flex; align-items:center; background:#000;}
		  .popup-left img { vertical-align:middle; width:100%;}
		  .popup-left a{width:100%;}
</style>
<div class="wrap">
<div>

  <div class="account-main">
    <div class="account-link">
      <h2>My Account</h2>
      <ul>
        <li><a href="<?php echo site_url('member/products')?>" ><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Products</a></li>
        <li><a href="<?php echo site_url('member/services')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/services-icon.png" alt=""/></span>Services</a></li>
        <li><a href="<?php echo site_url('member/video')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/videoicon1.png" alt=""/></span>Training Video</a></li>
        <?php if ($_SESSION['is_coach']==0){?>
        <li><a href="<?php echo site_url('member/coach')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/product-icon.png" alt=""/></span>Become a Coach</a></li>
        <?php }?>
        <?php if (($_SESSION['is_coach']==1) && ($_SESSION['is_paid']==0)){?>
        <li><a href="#"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/upgrade-icon.png" alt=""/></span>Upgrade Membership</a></li>
        <?php }?>
        <li><a href="<?php echo site_url('member/changepassword')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/changepass-icon.png" alt=""/></span>Change Password</a></li>
        <?php if ($_SESSION['is_coach']==1 && $_SESSION['is_paid']==1){?>
        <li><a href="<?php echo site_url('member/mycustomer')?>"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/mycustomer-icon.png" alt=""/></span>My Downline</a>
        <li><a href="#" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
          <ul>
            <li><a href="<?php echo site_url('member/allnotification')?>">Gallery</a></li>
            <li><a href="<?php echo site_url('member/sentnotification')?>">Sent</a></li>
            <li><a href="<?php echo site_url('member/receivednotification')?>">Received</a></li>
          </ul>
        </li>
        <?php }else{  ?>
        <li><a href="<?php echo site_url('member/receivednotification')?>" class="aciveurl-breadcrumb1"><span><img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/notifi-icon.png" alt=""/></span>Notification</a>
          <?php } ?>
      </ul>
    </div>
  </div>
  <div class="subscribe-main">
    <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice center">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
    <h1 style="font-size:18px; color:#fff;">Send Media To </h1>
    <?php //$findExt = explode(".",$media['media']);
		  //$ext = $findExt[count($findExt)-1];	

		  ?>
    <div class="media-aset">
      <div class="message-div">
        <div class="popup-left" style="text-align:center;">
          <?php if ( $media[0]['media_type_id']==1){?>
          <img src="<?=base_url()?>media/media_type/photo/<?php echo  $media[0]['media']; ?>" alt="Photo">
          <?php }else if($media[0]['media_type_id']==2){  ?>
          <?php if(1){?>
          <object width="650" height="400" id="undefined" name="undefined" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
            <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
            <param name="allowfullscreen" value="true" />
            <param name="allowscriptaccess" value="always" />
            <param name="flashvars" value='config={"clip":{"url":"<?php echo base_url();?>media/media_type/video/<?php  echo $media[0]['media']?>"},"playlist":[{"url":"<?php echo base_url();?>media/media_type/video/<?php  echo $media[0]['media']?>"}]}' />
          </object>
          <?php }else{ ?>
          <video width="100%" height="auto" controls autoplay>
            <source src="<?php echo base_url();?>media/media_type/video/<?php  echo $media[0]['media']?>" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
            Your browser does not support the video tag. </video>
          <?php  }?>
          <!--<img src="<?=base_url()?>application/views/<?php echo $this->
          system->theme_dir . $this->system->theme ?>/images/video-icon.png" alt="video">-->
          <?php }else if($media[0]['media_type_id']==3){ ?>
          <!--img src="<?=base_url()?>application/views/<?php echo $this->
          system->theme_dir . $this->system->theme ?>/images/audio-icon.png" alt=""-->
          <audio controls >
            <source src="horse.ogg" type="audio/ogg">
            <source src="<?php echo base_url();?>media/media_type/audio/<?php  echo $media[0]['media']?>" type="audio/mpeg">
            Your browser does not support the audio element. </audio>
          <?php }else if($media[0]['media_type_id']==4){ ?>
          <a  href="<?php echo base_url();?>media/media_type/text/<?php  echo $media[0]['media']?>"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/text-icon-list.png" alt="Text" style="width:auto;"></a>
          <?php }else if($media[0]['media_type_id']==5){ ?>
          <?php if(1){ ?>
          <object width="650" height="400" id="undefined" name="undefined" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
            <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
            <param name="allowfullscreen" value="true" />
            <param name="allowscriptaccess" value="always" />
            <param name="flashvars" value='config={"clip":{"url":"<?php echo base_url();?>media/media_type/walkout/<?php  echo $media[0]['media']?>"},"playlist":[{"url":"<?php echo base_url();?>media/media_type/walkout/<?php  echo $media[0]['media']?>"}]}' />
          </object>
          <?php }else{ ?>
          <video width="100%" height="auto" controls autoplay>
            <source src="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media[0]['media']?>" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
            Your browser does not support the video tag. </video>
          <?php  }?>
          <!--<video width="100%" height="auto" controls autoplay>
						<source src="" type="video/mp4">
						<source src="movie.ogg" type="video/ogg">
						<source src="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media[0]['media']?>" type="video/flv">
						Your browser does not support the video tag.
						</video>-->
          <?php }else if($media[0]['media_type_id']==6){ ?>
          <?php /*?><embed src="<?php echo base_url();?>media/media_type/swf/<?php  echo $media[0]['media']?>"><?php */?>
          <object width="650" height="400" data="<?php echo base_url();?>media/media_type/swf/<?php  echo $media[0]['media']?>">
          </object>
          <?php 	} ?>
        </div>
        <div class="popup-right">
          <h2 style="float:left; padding-left:0px;"><?php echo $media[0]['title']?></h2>
          </br>
          <span>Date :
          <?php  echo date('d M Y',strtotime($media[0]['date_created']));?>
          </span>
          <form name="" action="<?php  echo site_url('member/sentmediaindividual/'.$media_id)?>" method="post">
            <p> <?php echo $media[0]['description']?></p>
            </br>
            </br>
            <select name="receiver_id" class="input-text" style="width:50%; padding:5px;">
              <option value=""> Select User</option>
              <?php foreach ($userdata as $userdetails){?>
              <option value="<?php echo $userdetails['id'];?>"><?php echo $userdetails['first_name'].' '.$userdetails['last_name']?></option>
              <?php }?>
            </select>
            <input type="submit"  style="width:50px; padding:8px; background-color:#0162b3; color:#fff; border:0px; text-align:center;" value="Send"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!--body end here-->
