 <header class="bg-gradient">
        <div class="container mt-5">
		<h1 class="head">Contact Us</h1>
        </div>        
  </header>
<div class="section light-bg">
     <div class="container">  
    
        <?php  echo validation_errors(); ?>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice center">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form id="contactForm" class="contact-form wow animated fadeInUp" action="<?php  echo site_url('page/contactus')?>" method="post" data-wow-duration="1.5s" method="post">

		<div class="p-t-31 p-b-9"><span class="txt1">Name*</span></div>
		   <div class="wrap-input100">
		   <input id="name" type="text" name="name" class="input100" required> 		  
		   </div>
		   <div class="p-t-31 p-b-9"><span class="txt1">Email* </span></div>
		   <div class="wrap-input100">
		   <input id="email" type="email" name="email"  class="input100" required>		  
		   </div>

		   <div class="p-t-31 p-b-9"><span class="txt1">Subject* </span></div>
		   <div class="wrap-input100">
			<input id="subject" type="text" name="subject" class="input100" required>
		   </div>

		   <div class="p-t-31 p-b-9"><span class="txt1">Message* </span></div>
		   <div class="wrap-input100">
				<textarea id="message" rows="4" class="input100" required></textarea>
		   </div>
		   <div class="container-login100-form-btn m-t-17">
		   <input class="login100-form-btn" type="submit" name="submit" value="submit"></div>        
        </form>
    
   <!-- <div class="row">
      <div class="contact-infos">
        <div class="col-sm-4 text-center">
          <div class="contact-item wow animated fadeInUp" data-wow-duration="1.5s"> <span class="contact-icon"><i class="fa fa-map-marker"></i></span>
            <p class="contact-detail">68 Dohava Strees, Lorem isput Spusts <br/>
              New York, United State</p>
          </div>
        </div>
        <div class="col-sm-4 text-center">
          <div class="contact-item wow animated fadeInUp" data-wow-delay="0.5s" data-wow-duration="1.5s"> <span class="contact-icon"><i class="fa fa-envelope"></i></span>
            <p class="contact-detail">info@balbeey.com<br/>
              support@balbeey.com</p>
          </div>
        </div>
        <div class="col-sm-4 text-center">
          <div class="contact-item wow animated fadeInUp" data-wow-delay="1s" data-wow-duration="1.5s"> <span class="contact-icon"><i class="fa fa-phone"></i></span>
            <p class="contact-detail">+123-456-7890 - Central Office<br/>
              +123-456-7890 - Fax</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> -->
</div>
</div>
