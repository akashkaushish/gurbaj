<!--body start here-->
<style>
body{ margin:0px; padding:0px;}
.center{ padding-top:10px; text-align:center; clear:both;}
.subscribe-main h2 {
    color: #3b5998;
    font-size: 14px;
    font-weight: bold;
	margin-top:0px;
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
	border-bottom:1px solid #ccc;
	text-align:center;
}

.media-aset {
    color: #636465;
    float: left;
    font-size: 13px;
    width:100%;
	font-family:Arial, Helvetica, sans-serif;
}
.subscribe-main {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: #fff;
    background-image: none;
    background-origin: padding-box;
    background-position: 0 0;
    background-repeat: repeat;
    background-size: auto auto;
    margin-left: 0;
    margin-right: 0;
	background-color:#fff;
    width: 100%;
}
		  .media-aset span{margin-bottom:10px; display:block}
		  .popup-right{width:32%; float:right; padding:10px;}
		  .popup-left{width:65%; float:left; height:100%; display:flex; align-items:center; background:#000;}
		  .popup-left img { vertical-align:middle; width:100%;}
		  .popup-left a{width:100%;}
</style>
<div class="wrap">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice center">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <div class="subscribe-main">
   <!-- <h1>Media Detail</h1>-->
    <?php foreach($media as $media): ?>
	
	<?php $findExt = explode(".",$media['media']);
		  $ext = $findExt[count($findExt)-1];	?>
    <div class="media-aset">
      <div>
        <div class="popup-left" style="text-align:center;">
         	<?php if ( $media['media_type_id']==1){?>
					<img src="<?=base_url()?>media/media_type/photo/<?php echo  $media['media']; ?>" alt="Photo">
				<?php }else if($media['media_type_id']==2){  ?>
				
				                
				            
				          <?php if($ext=='flv'){?>
						   <object width="650" height="400" id="undefined" name="undefined" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash"><param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value='config={"clip":{"url":"<?php echo base_url();?>media/media_type/video/<?php  echo $media['media']?>"},"playlist":[{"url":"<?php echo base_url();?>media/media_type/video/<?php  echo $media['media']?>"}]}' /></object>
						  
						  <?php }else{ ?>
						  <video width="100%" height="auto" controls autoplay>
						<source src="<?php echo base_url();?>media/media_type/video/<?php  echo $media['media']?>" type="video/mp4">
						<source src="movie.ogg" type="video/ogg">
						Your browser does not support the video tag.
						</video>
						  <?php  }?>
				
						
					
					<!--<img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/video-icon.png" alt="video">-->
				<?php }else if($media['media_type_id']==3){ ?>
					<!--img src="<?=base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/audio-icon.png" alt=""-->
					<audio controls >
					<source src="horse.ogg" type="audio/ogg">
					<source src="<?php echo base_url();?>media/media_type/audio/<?php  echo $media['media']?>" type="audio/mpeg">
					Your browser does not support the audio element. </audio>
				<?php }else if($media['media_type_id']==4){ ?>
				
				<a  href="<?php echo base_url();?>media/media_type/text/<?php  echo $media['media']?>"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/text-icon-list.png" alt="Text" style="width:auto;"></a>
				<?php }else if($media['media_type_id']==5){ ?>
				
				
				 <?php if($ext=='flv'){ ?>
				 <object width="650" height="400" id="undefined" name="undefined" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash"><param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value='config={"clip":{"url":"<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>"},"playlist":[{"url":"<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>"}]}' /></object>
						  
						  <?php }else{ ?>
						  <video width="100%" height="auto" controls autoplay>
						<source src="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>" type="video/mp4">
						<source src="movie.ogg" type="video/ogg">
						Your browser does not support the video tag.
						</video>
						  <?php  }?>
						  
				<!--<video width="100%" height="auto" controls autoplay>
						<source src="" type="video/mp4">
						<source src="movie.ogg" type="video/ogg">
						<source src="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>" type="video/flv">
						Your browser does not support the video tag.
						</video>-->
				
				<?php }else if($media['media_type_id']==6){ ?>
			<?php /*?><embed src="<?php echo base_url();?>media/media_type/swf/<?php  echo $media['media']?>"><?php */?>
			<object width="650" height="400" data="<?php echo base_url();?>media/media_type/swf/<?php  echo $media['media']?>"></object>
				
			<?php 	} ?>
        </div>
       <div class="popup-right">
          <h2><?php echo $media['title']?></h2>
         
		  <span>Date : <?php echo date('d M Y',strtotime($media['date_created']));?></span>
          <p> <?php echo $media['description']?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<!--body end here-->
