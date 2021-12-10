<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
<link id="favicon" rel="shortcut icon" type="image/png"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://vjs.zencdn.net/c/video.js"></script>

    
    
<style>

.video-js {
    margin: 0 auto;

    width: 100%;

}
.small-links { display:none;}
.section1{ height:auto;}
.section1 h1 { margin-bottom: 20px; text-align:center; 
}
.audiodata { padding-top:350px;}


</style>
<div class="container">
  <div class="wrap">
    <div class="section1 aboutus">
      <h1>View Media</h1>
	  <div class="small-links-home" style="float:none"><a class="window" href="javascript:openInstaller();"> DESKTOP APPLICATION (WIN) </a>
		</div>
      <div style="width:100%; margin:0 auto; text-align:center; min-height:350x;">
        <?php $findExt = explode(".",$media['media']);

		          $ext = $findExt[count($findExt)-1];	
				  
				  $namemp4=$findExt[0].'.mp4';
				  
		   ?>
        <?php if ( $media['media_type_id']==1){?>
          <img src="<?=base_url()?>media/media_type/photo/<?php echo  $media['media']; ?>" alt="Photo">
          <?php }else if($media['media_type_id']==2){  ?>
          <?php if($ext=='flv'){ ?>
          <video id="<?php echo base_url();?>media/media_type/video/<?php  echo $media['media']?>" class="video-js vjs-default-skin" width="640" height="480"

        data-setup='{"controls" : true, "autoplay" : true, "preload" : "auto"}'>
            <source src="<?php echo base_url();?>media/media_type/video/<?php  echo $media['media']?>" type="video/x-flv">
          </video>
          <?php }else{ ?>
          <video width="100%" height="auto" controls autoplay>
            <source src="<?php echo base_url();?>media/media_type/video/<?php  echo $media['media']?>" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
            Your browser does not support the video tag. </video>
          <?php  }?>
          <!--<img src="<?=base_url()?>application/views/<?php echo $this->
          system->theme_dir . $this->system->theme ?>/images/video-icon.png" alt="video">-->
          <?php }else if($media['media_type_id']==3){ ?>
          <div style="margin:0 auto;">
            <audio controls >
              <source src="horse.ogg" type="audio/ogg">
              <source src="<?php echo base_url();?>media/media_type/audio/<?php  echo $media['media']?>" type="audio/mpeg">
              Your browser does not support the audio element. </audio>
          </div>
          <?php }else if($media['media_type_id']==4){ ?>
          <a href="javascript:void(0)"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/images/text-icon-list.png" alt="Text" style="width:auto;"></a>
          <?php }else if($media['media_type_id']==5){ ?>
          <?php if($ext=='flv'){ ?>
          <video id="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>" class="video-js vjs-default-skin" width="640" height="480"

        data-setup='{"controls" : true, "autoplay" : true, "preload" : "auto"}'>
            <source src="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>" type="video/x-flv">
          </video>
          <?php }else{ ?>
          <video width="100%" height="auto" controls autoplay>
            <source src="<?php echo base_url();?>media/media_type/walkout/<?php  echo $media['media']?>" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
            Your browser does not support the video tag. </video>
          <?php  }?>
          <?php }else if($media['media_type_id']==7){ ?>
          <?php if($ext=='flv'){ ?>
          <video id="<?php echo base_url();?>media/media_type/swf/<?php  echo $media['media']?>" class="video-js vjs-default-skin" width="640" height="480"

        data-setup='{"controls" : true, "autoplay" : true, "preload" : "auto"}'>
            <source src="<?php echo base_url();?>media/media_type/swf/<?php  echo $media['media']?>" type="video/x-flv">
          </video>
          <?php }else{ ?>
          <video width="100%" height="auto" controls autoplay>
            <source src="<?php echo base_url();?>media/media_type/swf/<?php  echo $media['media']?>" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
            Your browser does not support the video tag. </video>
          <?php  }?>
          <?php }else if($media['media_type_id']==6){ ?>
          <?php if($ext=='flv'){ ?>
          <object width="600" height="450" id="undefined" name="undefined" data="<?php echo base_url();?>player/preview.swf?videoPath=<?php  echo $media['media']?>&videoid=<?php  echo $media['media_id']?>" type="application/x-shockwave-flash">
            <param name="movie" value="<?php echo base_url();?>player/preview.swf?videoPath=<?php  echo $media['media']?>&videoid=<?php  echo $media['media_id']?>" />
            <param name="allowfullscreen" value="true" />
            <param name="wmode" value="transparent" />
            <param name="allowscriptaccess" value="always" />
            <param name="flashvars" value='config={"clip":{"url":"<?php  echo $media['media']?>"},"playlist":[{"url":"<?php  echo $media['media']?>"}]}' />
            <!-- <?php echo base_url();?>media/media_type/walkout/ -->
          </object>
          <?php }else if($ext=='swf'){ ?>
          <object width="600" height="450" id="undefined" name="undefined" data="<?php echo base_url();?>player/preview.swf?videoPath=<?php  echo $media['media']?>&videoid=<?php  echo $media['media_id']?>" type="application/x-shockwave-flash">
            <param name="movie" value="<?php echo base_url();?>player/preview.swf?videoPath=<?php  echo $media['media']?>&videoid=<?php  echo $media['media_id']?>" />
            <param name="allowfullscreen" value="true" />
            <param name="allowscriptaccess" value="always" />
            <param name="wmode" value="transparent" />
            <param name="flashvars" value='config={"clip":{"url":"<?php  echo $media['media']?>"},"playlist":[{"url":"<?php  echo $media['media']?>"}]}' />
            <!-- <?php echo base_url();?>media/media_type/walkout/ -->
          </object>
          <?php }else{ ?>
          <object width="600" height="450" id="undefined" name="undefined" data="<?php echo base_url();?>player/preview.swf?videoPath=<?php  echo $media['media']?>&videoid=<?php  echo $media['media_id']?>" type="application/x-shockwave-flash">
            <param name="movie" value="<?php echo base_url();?>player/preview.swf?videoPath=<?php  echo $media['media']?>&videoid=<?php  echo $media['media_id']?>" />
            <param name="allowfullscreen" value="true" />
            <param name="allowscriptaccess" value="always" />
            <param name="wmode" value="transparent" />
            <param name="flashvars" value='config={"clip":{"url":"<?php  echo $media['media']?>"},"playlist":[{"url":"<?php  echo $media['media']?>"}]}' />
            <!-- <?php echo base_url();?>media/media_type/walkout/ -->
          </object>
          <?php  }?>
          <?php 	} ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

function openInstaller(){

	window.open("http://bnotifi.com/super/installer?project_name=wiz&project_logo=57e19e467b614_Wiz_Brain_Tech_PNG.png", "_blank", "toolbar=no,scrollbars=no,resizable=no,width=400,height=300");

}


$(function(){
		$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>get_media_details",
				data: {media_id:"<?php echo $media['media_id'];?>"},
				success: function(result){
						onComplete(result);		
				},
				error: function(a,b,err){
					console.log(err); 
				}
			
		   });//ajax
	});
	
	function onComplete(data){
		
	   	document.title = data.data[0].project_name + " :: " + data.data[0].title;	
		
		$(".logo img").attr("src", data.baseurl + "media/projects/icons/"+data.data[0].project_logo);		
   	}

	</script> 
