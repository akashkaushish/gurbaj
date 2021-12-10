<div class="page_header" data-parallax-bg-image="<?php echo base_url();?>"><img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/1920x650-6.jpg" data-parallax-direction="">
  <div class="header-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="haeder-text">
            <h1>Contact Us</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  /.End of page header -->
<div class="contact_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-5 p_r_40">
            <h1 class="contact_title">Contact</h1>
            <div class="contacts_info">
              <!--<div class="address">
                <p>1355 Market Street, Suite 900 San Francisco, CA 94103</p>
              </div>-->
              <div class="phone_fax">
                <div>
                  <p>Email</p>
                  <!--p>Second Contact Email</p-->
                </div>
                <div> <a href="mailto:bitfxcohelp@example.com"> bitfxcohelp@gmail.com </a> <!--a href="#">bitfxcoinfo@gmail.com</a--> </div>
              </div>
            </div>
          </div>
          <div class="col-sm-7 p_l_40">
            <div class="map_widget">
              <!-- The element that will contain our Google Map. This is used in both the Javascript and CSS above. -->
              <div id="map"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/about_qq.jpg"  /></div>
            </div>
          </div>
        </div>
        <form id="contactForm" class="contact_form wow animated fadeInUp" action="<?php  echo site_url('page/contactus')?>" method="post" data-wow-duration="1.5s" >
          <h1 class="contact_title">Fill The Form</h1>
          <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
          <p class="notice" style="clear:both;">
            <?php  echo $notice;?>
          </p>
          <?php  endif;?>
          <?php  if (isset($success) || $success = $this->session->flashdata('success')):?>
          <div class="alert alert-success">
            <?php  echo $success;?>
          </div>
          <?php  endif;?>
          <?php  if (isset($error) || $error = $this->session->flashdata('error')):?>
          <div class="alert alert-danger">
            <?php  echo $error;?>
          </div>
          <?php  endif;?>
          <p><?php echo validation_errors(); ?></p>
          <div class="form-group">
            <label>Name</label>
            <div class="row">
              <div class="col-sm-6">
                <input type="text" name="first_name" class="form-control" id="f_name" required>
                <p class="help-block">First Name</p>
              </div>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="l_name" name="last_name" >
                <p class="help-block">Last Name</p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Company</label>
            <input type="text" class="form-control" name="company" id="company" required>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <label>Email*</label>
                <input type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="col-sm-6">
                <label>Phone</label>
                <input type="text" class="form-control"name="phone"  id="phone" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Message*</label>
            <textarea class="form-control" name="msg" rows="7" id="comment"></textarea>
          </div>
          <button type="submit" class="btn btn-default">Get In Touch</button>
        </form>
      </div>
    </div>
  </div>
</div>
