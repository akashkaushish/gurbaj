<?php 
if(isset($mediaid) && ($mediaid!='')){
	$media_id=$mediaid;
	
	}


?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link id="favicon" rel="shortcut icon" type="image/png"/>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,400,400,400'  rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css" />

<style type="text/css">

body{ color:#71758c; font-family: 'Open Sans', sans-serif; font-smooth: always;}

.ui-widget-header
{
	background:none;
}
.ui-dialog-titlebar
{
	
}
.ui-widget-content 
{
	border:none;
}

.ui-dialog div
{
	overflow:hidden !important;
	border:none;
	background:none;
}
.ui-widget.ui-widget-content
{
	border:none;
	background:none;
}

.ui-widget-content
{
}

.no-selection
{
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-o-user-select: none;
	user-select: none;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>

<script type="text/javascript">	

	var playTimer;			
	var interPoint = {};
	var videoId = "10";			
	var scaleFactor = 1;			
	var linkUrl="";			
	var arrAdd = [];
	var arrRem = [];
	var baseURL = "http://bnotifi.com/super/";
	var _mediaId = "4";
	
	$(function(){
		loadSound();
	 	$("#music").dialog({
			autoOpen: false,
			width: "338px",
			maxWidth: 335,
			resizable: false,
			title:"Music Player",
			close: function( event, ui ) {document.getElementById('audioPlayer').pause();}
			});
	
	 	$("#photo").dialog({
			autoOpen: false,
			title:"Image",
			maxHeight:$( window ).height(),
			maxWidth:$( window ).width(),
			resize: function(){
				$("#imagePlayer").width($("#photo").width());
				}
			});
			
		$("#phonepad").dialog({
			autoOpen: false,
			height:480,
			width:250,
			resizable:false,
			close: function(){
					$('video')[0].play();
					$("#status").html("");
				}
			});		

	});
	
	function loadSound(){
		for(var i = 0; i<10; i++)
		{
			var snd = new Audio(baseURL + "application/views/themes/super/sounds/DTMF-"+i+".mp3");
			snd.play();
			snd.pause();
		}
		var snd1 = new Audio(baseURL + "application/views/themes/super/sounds/DTMF-star.mp3");
		snd1.play();
		snd1.pause();
	}
	
	$(function(){
		var pHeight = isMobileOS()? $(document).height() - 50:$(document).height() - 50;
		
		$("#container").height(pHeight);
		$("#container").width(pHeight*4/3);
		
		var h = $(window).height()-50 + "px";
		var w = $(window).width() -50 + "px";
		$("#video").css("max-height", h);	
		$("#video").css("max-width", w);
		
		scaleFactor = $("#container").width()/800;
		
		$.ajax({
				type: "POST",
				url: baseURL + "rest/get_media_details",
				data: {media_id:'<?php echo $media_id;?>'},
				success: function(result){
						onComplete(result);		
				},
				error: function(a,b,err){
					console.log(err); 
				}
			
		   });//ajax
	});
		
   	function onComplete(data){
	   //var processedData = JSON.parse(data);
	   //alert(data.datasource+data.data[0].media.replace(".flv",".mp4"));
	   
	   	linkUrl = data.datasource;
		interPoint = data;
		document.title = data.data[0].project_name + " :: " + data.data[0].title;	
		$("#favicon").attr("href", data.baseurl + "media/projects/icons/"+data.data[0].project_logo);
			
		if(data.data[0].media.indexOf(".mp4")== -1)
		{	
	   		video.src = data.datasource + "mobile/" + data.data[0].media.replace(".flv",".mp4");
		}
		else
		{
			video.src = data.datasource + data.data[0].media;
		}
   	}
   
	function isAdded(time, x1, y1)
	{			   
	   var isFound = false;
	   $.each(arrAdd, function(i,val){
		   if(val.t == time && val.x == x1 && val.y == y1){
			   //console.log("found it at index: " + i);
			   isFound = true;
			   return;
	   		}
	   });	  	
	   return isFound; //If not found			   
	}
   
   	function videoTimerUpdate()
	{	
	 
		//console.log(video.currentTime);
		buttonDuration();
				
		$.each(interPoint.buttons, function(index, t){	
			//trace(t.start_point+" pp")
			if(parseFloat(t.start_point)<=Math.abs(video.currentTime) && Math.abs(video.currentTime)>0
			&& !isAdded(t.start_point.toString(),t.position_x.toString(), t.position_y.toString()))
			{
				//to check if already added button
				arrAdd.push({t:t.start_point.toString(),x:t.position_x.toString(),y:t.position_y.toString()});	
				
				//button duration how long stay 
				if(t.button_duration > 0)
				{
					arrRem.push({t:(t.start_point + t.button_duration),id:t.id});	
				}
									
				var b = "<button id='"+ t.id+"' style='position: absolute;cursor:pointer; border:1px solid' class='button'>" + String(t.button_label) + "</button>";
				$("#container").append(b);	
								
				$("#"+t.id+"").css({left: parseInt(t.position_x)*scaleFactor, top: parseInt(t.position_y)*scaleFactor});
				
				$("#"+t.id+"").attr( "title","click");
								
				$("#"+t.id+"").width( parseFloat(t.width)*scaleFactor);
				$("#"+t.id+"").height( parseFloat(t.height)*scaleFactor);				
				$("#"+t.id+"").css("opacity", t.transparency);
				
				if(t.button_image!="")
				{
					var buttonImg = linkUrl + "button_image/" + t.button_image
					$("#"+t.id+"").css("background-image", "url('"+buttonImg+"')");
					$("#"+t.id+"").css("background-repeat", "no-repeat");
					$("#"+t.id+"").css("border", "none");
				}
				//color
				
				if(t.button_image=="" || t.button_image == undefined || t.button_image == null)
				{					
					$("#"+t.id+"").css("background-color", "#"+t.button_color);
					$("#"+t.id+"").css("border", "1px solid " + " #"+t.button_color);
				}
				
				$("#"+t.id+"").css("border-radius", t.round_corners + "px");
										
				var url = "";	
				
									
				if(t.button_type=="1")
				{
					url = t.button_media;					
				}
				else if(t.button_type=="2")
				{
					url = linkUrl + "video/" + t.button_media;
				}
				else if(t.button_type=="3" || t.button_type=="")
				{
					url = t.button_media==""?"": linkUrl + "video/" + t.button_media;
				}
				else if(t.button_type=="5")
				{
					url = linkUrl + "music/" + t.button_media;
					
					console.log(t.button_media + "ppppppppp");
				}
				
				else if(t.button_type=="6")
				{
					url = linkUrl + "image_file/" + t.button_media;
				}
				
				else if(t.button_type=="7")
				{
					url = t.button_media + "/" ;
				}
		
				if(t.width=="0" || t.height=="0" || t.button_type=="4"){
					$("#"+t.id+"").css("visibility", "hidden");
					autoLaunch(t, url)
				}
				
				$("#"+t.id+"").attr("url", url);
				
				$("#"+t.id+"").attr("button_type", t.button_type);
				
				//========================================================
				$("#"+t.id+"").click(function(){
					
					var burl = $(this).attr("url");
					
					if($(this).attr("button_type")=="2")
					{
						interPoint = {};
						$("#container").children(".button").remove();
						$('video')[0].pause();								
						$('video')[0].src = burl;
						$('video')[0].play();															
					}
										
					else if($(this).attr("button_type")=="5")//music
					{								
						$('video')[0].pause();		
											
						//$("#container").children(".button").remove();	
						$("#audioPlayer").attr("src",burl).trigger("play");
						$("#music").dialog('open').css("background-image","url('http://ndl.mgccw.com/mu3/app/20140219/15/1392805102159/sss/1_small.png')");	
					}	
					else if($(this).attr("button_type")=="6")//image
					{								
						$("#imagePlayer").attr("src",burl);
						$("#photo").dialog('open');	
						$("#imagePlayer").width($("#photo").width());		
						console.log(burl);								
					}
					else if($(this).attr("button_type")=="7")//survey
					{								
						navigateToURL(new URLRequest(burl));									
					}		
					else
					{
						if(burl.toLowerCase().indexOf("http://")<0 && burl.toLowerCase().indexOf("https://")<0)
							burl = "http://"+burl
						window.open(burl);	
					}
										
					//================================================
					return false;				
				});
												
			}							
		});
	}
	
	function autoLaunch(t, burl){
		
		if(t.button_type=="2")//video
		{
			interPoint = {};
			$("#container").children(".button").remove();
			$('video')[0].pause();								
			$('video')[0].src = burl;
			$('video')[0].play();															
		}			
		else if(t.button_type=="4")//phone
		{	
			_mediaId = t.id;
			var pos = [Math.ceil(parseInt(t.position_x)*scaleFactor), Math.ceil(parseInt(t.position_y)*scaleFactor)];			
			$('video')[0].pause();		
			$( "#phonepad" ).dialog({ autoOpen: true, position: pos});
		}											
		else if(t.button_type=="5")//music
		{								
			$('video')[0].pause();		
			console.log(burl);					
			//$("#container").children(".button").remove();	
			$("#audioPlayer").attr("src",burl).trigger("play");
			$("#music").dialog('open').css("background-image","url('http://ndl.mgccw.com/mu3/app/20140219/15/1392805102159/sss/1_small.png')");		
		}	
		else if(t.button_type=="6")//image
		{								
			$("#imagePlayer").attr("src",burl);
			$("#photo").dialog('open');		
			$("#imagePlayer").width($("#photo").width());
		}	
		else //link
		{
			if(burl.toLowerCase().indexOf("http://")<0 && burl.toLowerCase().indexOf("https://")<0)
				burl = "http://"+burl
			window.open(burl);	
		}
	}
	
	function removeButton()
	{
		$("#container").children(".button").remove();
		arrAdd = [];
		arrRem = [];
		videoTimerUpdate();
	}
	
	function buttonDuration()
	{
		if(arrRem){
			$.each(arrRem, function(i,val){
				if(val.t <= video.currentTime)			
				$("#container").children("#"+val.id+"").remove();
			});
		}
	}
	
	function videoEnd(){
		$("#photo").dialog('close');		
		$("#music").dialog('close');
		
		$("#container").children(".button").remove();
		arrAdd = [];
		arrRem = [];
	}
	function audioPlaying(){
		$("#equalizer").css("visibility","visible");
	}
	
	function audioStop(){
		$("#equalizer").css("visibility","hidden");
	}
	
	function audioEnded(){
		$("#music").dialog('close');
	}
	
	function isMobileOS() {
	  var userAgent = navigator.userAgent || navigator.vendor || window.opera;
	
		  // Windows Phone must come first because its UA also contains "Android"
		var isMobile = false;1
		if (/windows phone/i.test(userAgent)) {
			isMobile = true;
		}
	
		if (/android/i.test(userAgent)) {
			isMobile = true;
		}
	
		// iOS detection from: http://stackoverflow.com/a/9039885/177710
		if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
			isMobile = true;
		}

    	return isMobile;
	}
	
	function printCoupon() 
    {     
		var contents = document.getElementById("photoContainer").innerHTML;
		var frame1 = document.createElement('iframe');
		frame1.name = "frame1";
		frame1.style.position = "absolute";
		frame1.style.top = "-1000000px";
		document.body.appendChild(frame1);
		var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
		frameDoc.document.open();
		frameDoc.document.write('<html><head><title>Coupon</title>');
		frameDoc.document.write('</head><body>');
		frameDoc.document.write(contents);
		frameDoc.document.write('</body></html>');
		frameDoc.document.close();
		setTimeout(function () {
			window.frames["frame1"].focus();
			window.frames["frame1"].print();
			document.body.removeChild(frame1);
		}, 500);
		return false;
    }
		
	//tollio
 </script>
 
 <script type="text/javascript">
 // Create Base64 Object
	var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
		
	function dialKey(digit){
			
		var snd = new Audio(baseURL + "application/views/themes/super/sounds/DTMF-"+digit+".mp3");
		snd.play();
		setTimeout(function(){snd.pause();},200)
		
		if($("#dialpad").html().length<10){
			$("#dialpad").html($("#dialpad").html()+digit);
			$("#status").html("");
		}
	}
	
	function deleteKey(){
		if($("#dialpad").html().length>0){
			$("#dialpad").html($("#dialpad").html().toString().slice(0, -1));
			$("#status").html("");
		}
	}
	
	function makeTwilioCall() {
			
			var snd = new Audio(baseURL + "application/views/themes/super/sounds/DTMF-star.mp3");
			snd.play();
			setTimeout(function(){snd.pause();},200)
		
			var _phoneNumber = $("#dialpad").html();
			if(_phoneNumber.length<10){
				return;
			}
			var acctId = "ACb5baeb4f4c26ef3e8a010efbe51cec39";
			var token = "f3aac1c4b0b38107853beaaf074dbb8b";
			var url = "https://api.twilio.com/2010-04-01/Accounts/"+ acctId +"/Calls";			
			
			var authString = acctId + ":" + token;
			
			var encodedString = Base64.encode(authString);
			
			var authHeader = "Basic " + encodedString;
						
			var param = {};
			param.To = "+1" + _phoneNumber;
			param.From = "+19513836610"; // this is rocky's correct from number
			param.Url = baseURL + "rest/twilio_callback/?mediaid="+_mediaId;
				
			$("#status").html("calling...");	
			$("#status").css("color","green");
			$.ajax({
				url: url,
				headers: {
					'Authorization': authHeader
				},
				method: 'POST',
				dataType: 'xml',
				data: param,
				success: function(data){
				  console.log('succes: ');
				  $("#status").html("");
				},
				error: function(a,b,err){
				  console.log('error: ');
				  $("#status").html("Wrong number");
				  $("#status").css("color","red");
				}
				
			  });
		}


 </script>
<div>
<div class="wrap">
  <div class="section1 aboutus">
    <h1 style="text-align:center;">View Media</h1>
    <div class="small-links-home" style="float:none"><a class="window" href="javascript:openInstaller();"> DESKTOP APPLICATION (WIN) </a> <a class="iphone" href="http://bnotifi.com/super/installer/bNotifiSystem.pkg" style="display: none;"> DESKTOP APPLICATION (MAC) </a> </div>
    <div id="container" style="position: relative; width: 801px; height: 601px;">
      <video id="video" style="width:100%; height:auto;" controls="controls" 
        autoplay="autoplay" ontimeupdate="videoTimerUpdate();"  onseeking="removeButton()"
        onended="videoEnd()"> </video>
    </div>
    <div id="music" style="text-align:center;"> <img id="equalizer" alt="" src="http://www.bnotifi.com/super/application/views/themes/super/images/equalizer.gif" width="300"/>
      <audio id="audioPlayer" controls="controls" onended="audioEnded()" onpause="audioStop()" 
    onplaying="audioPlaying()"></audio>
    </div>
    <div id="photo">
      <div style="text-align:right;font-size:12px;">
        <button onclick="return printCoupon()" title="Print this coupon">PRINT</button>
      </div>
      <div id="photoContainer"> <img id="imagePlayer" alt="" src=""/> </div>
    </div>
    <div id="phonepad" style="position:relative;"> <img id="padbg" alt="" src="http://www.bnotifi.com/super/application/views/themes/super/images/iphone.png" height="420"
    onload=""/>
      <div style="position:absolute; height:420px; width:215px;top:10px;">
        <table border="0" width="100%" style="max-width:215px;">
          <tr>
            <td colspan="5"><div style="width:35px; height:40px;"></div></td>
          </tr>
          <tr>
            <td><div style="height:45px;">&nbsp;</div></td>
            <td id="dialpad" colspan="3" style="font-weight:bold;padding-top:15px;" align="center"></td>
            <td class="no-selection" style="padding-top:15px;height:40px;cursor:pointer; color:red;font-weight:bold;"  onclick="deleteKey()">x</td>
          </tr>
          <tr>
            <td width="12%">&nbsp;</td>
            <td width="25%"><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('1')"></div></td>
            <td width="25%"><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('2')"></div></td>
            <td width="25%"><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('3')"></div></td>
            <td width="12%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('4')"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('5')"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('6')"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('7')"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('8')"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('9')"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div style="width:45px; height:40px;cursor:pointer;"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="dialKey('0')"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" ></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div style="width:45px; height:40px;"></div></td>
            <td><div style="width:45px; height:40px;cursor:pointer;" onclick="makeTwilioCall()"></div></td>
            <td><div style="width:45px; height:40px;"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div style="width:40px; height:40px;"></div></td>
            <td><div style="width:40px; height:40px;"></div></td>
            <td><div style="width:40px; height:40px;"></div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

(function (window) {
    {
        var unknown = '-';  
        var nVer = navigator.appVersion;
        var nAgt = navigator.userAgent;
              
        // system
        var os = unknown;
        var clientStrings = [
            {s:'Windows 10', r:/(Windows 10.0|Windows NT 10.0)/},
            {s:'Windows 8.1', r:/(Windows 8.1|Windows NT 6.3)/},
            {s:'Windows 8', r:/(Windows 8|Windows NT 6.2)/},
            {s:'Windows 7', r:/(Windows 7|Windows NT 6.1)/},
            {s:'Windows Vista', r:/Windows NT 6.0/},
            {s:'Windows Server 2003', r:/Windows NT 5.2/},
            {s:'Windows XP', r:/(Windows NT 5.1|Windows XP)/},
            {s:'Windows 2000', r:/(Windows NT 5.0|Windows 2000)/},
            {s:'Windows ME', r:/(Win 9x 4.90|Windows ME)/},
            {s:'Windows 98', r:/(Windows 98|Win98)/},
            {s:'Windows 95', r:/(Windows 95|Win95|Windows_95)/},
            {s:'Windows NT 4.0', r:/(Windows NT 4.0|WinNT4.0|WinNT|Windows NT)/},
            {s:'Windows CE', r:/Windows CE/},
            {s:'Windows 3.11', r:/Win16/},
            {s:'Android', r:/Android/},
            {s:'Open BSD', r:/OpenBSD/},
            {s:'Sun OS', r:/SunOS/},
            {s:'Linux', r:/(Linux|X11)/},
            {s:'iOS', r:/(iPhone|iPad|iPod)/},
            {s:'Mac OS X', r:/Mac OS X/},
            {s:'Mac OS', r:/(MacPPC|MacIntel|Mac_PowerPC|Macintosh)/},
            {s:'QNX', r:/QNX/},
            {s:'UNIX', r:/UNIX/},
            {s:'BeOS', r:/BeOS/},
            {s:'OS/2', r:/OS\/2/},
            {s:'Search Bot', r:/(nuhk|Googlebot|Yammybot|Openbot|Slurp|MSNBot|Ask Jeeves\/Teoma|ia_archiver)/}
        ];
        for (var id in clientStrings) {
            var cs = clientStrings[id];
            if (cs.r.test(nAgt)) {
                os = cs.s;
                break;
            }
        }

        var osVersion = unknown;

        if (/Windows/.test(os)) {
            osVersion = /Windows (.*)/.exec(os)[1];
            os = 'Windows';
        }

        switch (os) {
            case 'Mac OS X':
                osVersion = /Mac OS X (10[\.\_\d]+)/.exec(nAgt)[1];
                break;

            case 'Android':
                osVersion = /Android ([\.\_\d]+)/.exec(nAgt)[1];
                break;

            case 'iOS':
                osVersion = /OS (\d+)_(\d+)_?(\d+)?/.exec(nVer);
                osVersion = osVersion[1] + '.' + osVersion[2] + '.' + (osVersion[3] | 0);
                break;
        }  
    }

    window.jscd = {       
        os: os
    };
}(this));
if(jscd.os=='Windows'){
	$(".window").show();
	$(".iphone").hide();
}else if(jscd.os=='Mac OS X' || jscd.os=='Mac OS' ){
	$(".iphone").show();
	$(".window").hide();
}


</script>
<script>

function openInstaller(){

	window.open("http://bnotifi.com/super/installer?project_name=wiz&project_logo=57e19e467b614_Wiz_Brain_Tech_PNG.png", "_blank", "toolbar=no,scrollbars=no,resizable=no,width=400,height=300");

}
</script>
