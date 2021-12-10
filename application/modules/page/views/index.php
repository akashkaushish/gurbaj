<div class="animation-slide owl-carousel owl-theme" id="animation-slide">
  <!-- Slide 1-->
  <div class="item slide-one">
    <div class="slide-table">
      <div class="slide-tablecell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="slide-text text-center">
                <h2>Increase Your Money By <br> <span class="outrageous-orange">200% In 25 Months</span></h2>
                <p>Referral Money Upto 7 Levels</p>
                <div class="slide-buttons"> <a href="<?php echo site_url('member/signup');?>" class="slide-btn">Start Now</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Slide 2-->
  <div class="item slide-two">
    <div class="slide-table">
      <div class="slide-tablecell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="slide-text">
                <h2>SMART RETURNS<br> ON YOUR<span class="bright-turquoise">CRYPTO</span></h2>
                <p>Put your investing ideas into action with a full range of<br>
investments. Enjoy real benefits and rewards on<br>
your investing.</p>
                <div class="slide-buttons"> <a href="<?php echo site_url('member/signup');?>" class="slide-btn">Start Now</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Slide 3-->
  <div class="item slide-three">
    <div class="slide-table">
      <div class="slide-tablecell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="slide-text text-right">
                <h2>Great Investment<br>
                  <span class="navy-blue">for your Crypto</span></h2>
                <p>BitFxCo is leading Cryptocurrency trading company<br>
that utilizes innovative technologies to provide<br>
managed cryptocurrency trading services to<br>
gain higher profits.</p>
                <div class="slide-buttons"> <a href="<?php echo site_url('member/signup');?>" class="slide-btn">Start Now</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.End of slider -->
<div class="about_content">
  <div class="container">
    <div class="row about-text justify-content">
      <div class="col-md-6">
        <div class="about-info">
          <h2>What is BitFxCo?</h2>
          <div class="definition">BitFxCo is an international crypto trading company, this company is founded by a group of a highly qualified expert, professional traders, and market analyst.</div>
          <p>We are constantly working on implementing unique trading methods with the most advanced and effective trading technology, competitive services, high-quality performance, genuine practices, excellent customer support service and fund safety that allow us to work successfully on the market in a highly profitable way.</p>
          <p>The company provides Risk- Free Investment products to global investors, which is a landmark for the company performance.</p>
          <a href="<?php echo base_url()?>index.php?/page/contactus" class="btn btn-default mr-20">Contact us</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="text-right">
          <div class="nomics-ticker-widget" data-name="Bitcoin" data-base="BTC" data-quote="USD"></div>
          <script src="https://widget.nomics.com/embed.js"></script>
          <!--img src="<?php echo base_url()?>application/views/<?php echo $this->
          system->theme_dir . $this->system->theme ?>/assets/img/about.jpg" class="img-responsive" alt=""--> </div>
        <!--div class="quote">
                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            <div class="author-address">Tanjil Ahmed - Owner, Bdtask</div>
                        </div-->
      </div>
    </div>
  </div>
</div>
<!-- /.End of about content -->
<div class="calculate">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>Daily Market <span>Analysis</span></h3>
        </div>
      </div>
    </div>
    <div class="row justify-content">
      <!-- TradingView Widget BEGIN -->
      <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright"><a href="https://in.tradingview.com/markets/cryptocurrencies/prices-all/" rel="noopener" target="_blank"><span class="blue-text">Cryptocurrency Markets</span></a> by TradingView</div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                        {
                        "width": "100%",
                        "height": "490",
                        "defaultColumn": "overview",
                        "screener_type": "crypto_mkt",
                        "displayCurrency": "USD",
                        "colorTheme": "light",
                        "locale": "in",
                        "isTransparent": false
                        }
                        </script>
      </div>
      <!-- TradingView Widget END -->
      <!--div class="col-sm-4">
                        <div class="bitcoin-sack">
                            <img src="<?php echo base_url()?>application/views/<?php echo $this->
      system->theme_dir . $this->system->theme ?>/assets/img/calculate-img.png" class="img-responsive center-block" alt=""> </div>
  </div>
  <div class="col-sm-8">
    <div class="exchange-content">
      <form class="form-inline exchange-form" action="https://cryptomarkethtml.bdtask.com/action_page.php">
        <div class="input-group">
          <div class="input-group-btn">
            <select class="selectpicker" data-width="80px">
              <option>BTC</option>
              <option>USD</option>
              <option>EUR</option>
              <option>LTC</option>
              <option>RUB</option>
            </select>
          </div>
          <input type="text" class="form-control">
        </div>
        <div class="exchange-btn"> <span class="lnr lnr-arrow-right"></span> </div>
        <div class="input-group">
          <div class="input-group-btn">
            <select class="selectpicker" data-width="80px">
              <option>USD</option>
              <option>BTC</option>
              <option>EUR</option>
              <option>LTC</option>
              <option>RUB</option>
            </select>
          </div>
          <input type="text" class="form-control">
        </div>
      </form>
      <div class="exchange-info">
        <h4>How it works?</h4>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking
          at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, 
          as opposed to using 'Content here, content here', making it look like readable English.</p>
      </div>
      </div-->
    </div>
  </div>
</div>
</div>
<!-- /.End of calculate -->
<div class="features__content">
  <div id="content__bg"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>Service we <span>Provide</span></h3>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="feature__box"> <i class="flaticon-analytics"></i>
        <div class="feature__content">
          <h3>Secure & Reliable</h3>
          <p>We care profoundly about security of our clients at BitFxCo we use cold wallet high end blockchain technology to protect our clients money, Moreover, constantly we improving security feature to avoid any unauthorized access.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="feature__box"> <i class="flaticon-secure-shield"></i>
        <div class="feature__content">
          <h3>Instant & Secure Withdrawal</h3>
          <p>You can make instant withdraws from your BitFxCo to any valid Bitcoin wallet. You can also withdraw your referral bonus, direct bonus and level referral bonus.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="feature__box"> <i class="flaticon-credit-card"></i>
        <div class="feature__content">
          <h3>SSL ENCRYPTION</h3>
          <p>SSL is one of the most important component for online transaction. BitFxCo platform is protected by military grade SSL Encryption, So you can be certain that your transaction and assets are protected with us</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="feature__box"> <i class="flaticon-people"></i>
        <div class="feature__content">
          <h3>24 X 7 Support Services</h3>
          <p>It's our first priority to serve our customer best. Our 24X7 support is active to resolve your doubts in very short span of time.</p>
        </div>
      </div>
    </div>
 


  </div>
</div>
<!-- End of features content -->
<div class="crypto-strat">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>How to Get <span>Start</span></h3>
        </div>
      </div>
    </div>
    <!--<div class="crypto-strat-title"><span>How to Get Start</span></div>-->
    <div class="start-steps">
      <div class="start-step">
        <!--<span class="start-step-number">1</span>-->
        <i class="step-icon flaticon-wallet"></i>
        <div class="start-step-info">
          <div class="step-name"> <span>Choose your Plan</span> </div>
          <div class="step-text"> <span>Its quiet easy to choose a plan as per your investment limit.</span> </div>
        </div>
      </div>
      <div class="start-step">
        <!--<span class="start-step-number">2</span>-->
        <i class="step-icon flaticon-credit-card"></i>
        <div class="start-step-info">
          <div class="step-name"> <span>Make Payment</span> </div>
          <div class="step-text"> <span>So many ways to do payment, by secure crypto is the preffered option.</span> </div>
        </div>
      </div>
      <div class="start-step">
        <!--<span class="start-step-number">3</span>-->
        <i class="step-icon flaticon-money-1"></i>
        <div class="start-step-info">
          <div class="step-name"> <span>Start Earning</span> </div>
          <div class="step-text"> <span>Many ways to get return, investment return, referral commission, Fixed Reward, Reyalty & many more.</span> </div>
        </div>
      </div>
    </div>
    <a href="<?php echo site_url('member/signup');?>" class="btn btn-default">Get Start</a> </div>
</div>
<!-- /.End of How to Get  Start -->
<div class="testimonial-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>What you should know about <span>cryptocurrencies</span></h3>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="owl-testimonial owl-carousel owl-theme">
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>Tanjil Ahmed</span></div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>"My family and me want to thank you for helping us find a great opportunity to make money online."</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>Tuhin Sorker</span></div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>"Within 25 months I have 200% pure profit. I invest $500 and received $1000."</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>Krishnan Alom</span></div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>"200% return in 25 months. Excellent customer service!"</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>H.M Isahaq</span></div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>"This is a fantastic program, punctual paying, thanks a lot. I recommend this Crypto Trade Investment website."</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <!-- /.End of client logo -->
      </div>
    </div>
  </div>
</div>
<!-- /.End of testimonial content -->
<div class="blog_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>We Are<span>Trading In</span></h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="owl-blog owl-carousel owl-theme">
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-1.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading">Stock Market</h3>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-2.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading">Commodity Market</h3>
            </div>
          </div>
        </div>
	  <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-3.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading">Forex Market</h3>
            </div>
          </div>
        </div>
		<div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-4.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading">Crypto Market</h3>
            </div>
          </div>
        </div>
		
      </div>
    </div>
  </div>
</div>
<!-- /.End of blog content -->
<!--<footer class="footer">
<div class="footer-breadcrumbs">
  <div class="container">
    <div class="breadcrumbs-row">
      <ul class="f_breadcrumbs">
        <li><a href="#"><span>Home</span></a></li>
        <li><a href="#"><span>About</span></a></li>
      </ul>
      <div class="scroll-top" id="back-to-top">
        <div class="scroll-top-text"><span>Scroll to Top</span></div>
        <div class="scroll-top-icon"><i class="fa fa-angle-up"></i></div>
      </div>
    </div>
  </div>
</div>-->
<!-- /.End of breadcrumbs -->
<?php /*?><div class="action_btn_inner"> <a href="<?php echo site_url('member/signup');?>" class="action_btn"> <span class="action_title">Register</span> <span class="lnr lnr-chevron-right action_icon"></span> <span class="action_sub_title">Join the new era of cryptocurrency investments</span> </a> <a href="<?php echo site_url('member/login');?>" class="action_btn"> <span class="action_title">Sign in</span> <span class="lnr lnr-chevron-right action_icon"></span> <span class="action_sub_title">Access the cryptocurrency investments experience you deserve</span> </a> </div><?php */?>
<!-- /.End of action button -->
<?php /*?><div class="main_footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-5 col-md-4 col-md-offset-1">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="footer-box">
              <h3 class="footer-title">Our Company</h3>
              <ul class="footer-list">
                <li><a href="#">Referral Program</a></li>
                <li><a href="#">About Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="footer-box">
              <h3 class="footer-title">Service</h3>
              <ul class="footer-list">
                <li><a href="about.html">About Us</a></li>
                <li><a href="service.html">Service</a></li>
                <li><a href="contact.html">Contact us</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>

<?php /*?><div class="animation-slide owl-carousel owl-theme" id="animation-slide">
  <!-- Slide 1-->
  <div class="item slide-one">
    <div class="slide-table">
      <div class="slide-tablecell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="slide-text text-center">
                <h2>The Feature of <span class="outrageous-orange">Referral</span> <br>
                  is Here </h2>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when.<br>
                  looking at its layout The point of using Lorem Ipsum is that</p>
                <div class="slide-buttons"> <a href="<?php echo site_url('member/signup');?>" class="slide-btn">Start Now</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Slide 2-->
  <div class="item slide-two">
    <div class="slide-table">
      <div class="slide-tablecell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="slide-text">
                <h2>Investment <span class="bright-turquoise">Plans</span> <br>
                  You Can Trust</h2>
                <p>Miker Ipsum is simply dummy text of the printing and typesetting industry.<br>
                  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                <div class="slide-buttons"> <a href="<?php echo site_url('member/signup');?>" class="slide-btn">Start Now</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Slide 3-->
  <div class="item slide-three">
    <div class="slide-table">
      <div class="slide-tablecell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="slide-text text-right">
                <h2>Invest in the world's  best <br>
                  <span class="navy-blue">Cryptocurrency</span> Plans.</h2>
                <p>Miker Ipsum is simply dummy text of the printing and typesetting industry. <br>
                  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                <div class="slide-buttons"> <a href="<?php echo site_url('member/signup');?>" class="slide-btn">Start Now</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--  <div class="item slide-four"> </div>-->
</div>
<!-- /.End of slider -->
<div class="about_content">
  <div class="container">
    <div class="row about-text justify-content">
      <div class="col-md-6">
        <div class="about-info">
          <h2>What is BitFxCo?</h2>
          <div class="definition">BitFxCo Crypto is a platform for the future of funding that powering dat for the new equity blockchain</div>
          <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some 
            form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use
            a passage of Lorem Ipsum, you need to be sure there isn't anything. </p>
          <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator.</p>
          <a href="#" class="btn btn-default mr-20">Contact us</a>
          <!--<a href="#" class="btn btn-default-o mb-10">Our Service</a>-->
          <div class="play-button"> <a href="https://www.youtube.com/watch?v=41JCpzvnn_0" class="btn-play popup-youtube">
            <div class="play-icon"><i class="fa fa-play"></i></div>
            <div class="play-text">
              <div class="btn-title-inner">
                <div class="btn-title"><span>Watch Video</span></div>
                <div class="btn-subtitle"><span>About Bitcoin</span></div>
              </div>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="text-right">
          <div class="nomics-ticker-widget" data-name="Bitcoin" data-base="BTC" data-quote="USD"></div>
          <script src="https://widget.nomics.com/embed.js"></script>
          <!--img src="<?php echo base_url()?>application/views/<?php echo $this->
          system->theme_dir . $this->system->theme ?>/assets/img/about.jpg" class="img-responsive" alt=""--> </div>
        <!--div class="quote">
                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            <div class="author-address">Tanjil Ahmed - Owner, Bdtask</div>
                        </div-->
      </div>
    </div>
  </div>
</div>
<!-- /.End of about content -->
<div class="calculate">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>Quick Bitcoin <span>Converter</span></h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
        </div>
      </div>
    </div>
    <div class="row justify-content">
      <!-- TradingView Widget BEGIN -->
      <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright"><a href="https://in.tradingview.com/markets/cryptocurrencies/prices-all/" rel="noopener" target="_blank"><span class="blue-text">Cryptocurrency Markets</span></a> by TradingView</div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                        {
                        "width": "100%",
                        "height": "490",
                        "defaultColumn": "overview",
                        "screener_type": "crypto_mkt",
                        "displayCurrency": "USD",
                        "colorTheme": "light",
                        "locale": "in",
                        "isTransparent": false
                        }
                        </script>
      </div>
      <!-- TradingView Widget END -->
      <!--div class="col-sm-4">
                        <div class="bitcoin-sack">
                            <img src="<?php echo base_url()?>application/views/<?php echo $this->
      system->theme_dir . $this->system->theme ?>/assets/img/calculate-img.png" class="img-responsive center-block" alt=""> </div>
  </div>
  <div class="col-sm-8">
    <div class="exchange-content">
      <form class="form-inline exchange-form" action="https://cryptomarkethtml.bdtask.com/action_page.php">
        <div class="input-group">
          <div class="input-group-btn">
            <select class="selectpicker" data-width="80px">
              <option>BTC</option>
              <option>USD</option>
              <option>EUR</option>
              <option>LTC</option>
              <option>RUB</option>
            </select>
          </div>
          <input type="text" class="form-control">
        </div>
        <div class="exchange-btn"> <span class="lnr lnr-arrow-right"></span> </div>
        <div class="input-group">
          <div class="input-group-btn">
            <select class="selectpicker" data-width="80px">
              <option>USD</option>
              <option>BTC</option>
              <option>EUR</option>
              <option>LTC</option>
              <option>RUB</option>
            </select>
          </div>
          <input type="text" class="form-control">
        </div>
      </form>
      <div class="exchange-info">
        <h4>How it works?</h4>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking
          at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, 
          as opposed to using 'Content here, content here', making it look like readable English.</p>
      </div>
      </div-->
    </div>
  </div>
</div>
</div>
<!-- /.End of calculate -->
<div class="features__content">
  <div id="content__bg"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>Service we <span>Provide</span></h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-analytics"></i>
        <div class="feature__content">
          <h3>Data Protection</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-secure-shield"></i>
        <div class="feature__content">
          <h3>Security Protected</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-people"></i>
        <div class="feature__content">
          <h3>Support 24/7</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-credit-card"></i>
        <div class="feature__content">
          <h3>Payment Methods</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-money-2"></i>
        <div class="feature__content">
          <h3>Registered Company</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-money-1"></i>
        <div class="feature__content">
          <h3>Secured Company</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-bitcoin"></i>
        <div class="feature__content">
          <h3>Live Exchange Rates</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="feature__box"> <i class="flaticon-bitcoin-1"></i>
        <div class="feature__content">
          <h3>Cryptocurrency Investments</h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at
            its layout.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of features content -->
<div class="crypto-strat">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>How to Get <span>Start</span></h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
        </div>
      </div>
    </div>
    <!--<div class="crypto-strat-title"><span>How to Get Start</span></div>-->
    <div class="start-steps">
      <div class="start-step">
        <!--<span class="start-step-number">1</span>-->
        <i class="step-icon flaticon-wallet"></i>
        <div class="start-step-info">
          <div class="step-name"> <span>Choose your Plan</span> </div>
          <div class="step-text"> <span>All the Lorem Ipsum generators on the Internet tend to rdefined chunks as making this the</span> </div>
        </div>
      </div>
      <div class="start-step">
        <!--<span class="start-step-number">2</span>-->
        <i class="step-icon flaticon-credit-card"></i>
        <div class="start-step-info">
          <div class="step-name"> <span>Make Payment</span> </div>
          <div class="step-text"> <span>All the Lorem Ipsum generators on the Internet tend to rdefined chunks as making this the</span> </div>
        </div>
      </div>
      <div class="start-step">
        <!--<span class="start-step-number">3</span>-->
        <i class="step-icon flaticon-money-1"></i>
        <div class="start-step-info">
          <div class="step-name"> <span>Start Earning</span> </div>
          <div class="step-text"> <span>All the Lorem Ipsum generators on the Internet tend to rdefined chunks as making this the</span> </div>
        </div>
      </div>
    </div>
    <a href="<?php echo site_url('member/signup');?>" class="btn btn-default">Get Start</a> </div>
</div>
<!-- /.End of How to Get  Start -->
<div class="testimonial-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>What you should know about <span>cryptocurrencies</span></h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="owl-testimonial owl-carousel owl-theme">
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>Tanjil Ahmed</span></div>
                <div class="quotePosition"> <span>Co-founder of Bdtask, American business magnate</span> </div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>“ It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ”</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>Tuhin Sorker</span></div>
                <div class="quotePosition"> <span>Co-founder of Bdtask, American business magnate</span> </div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>“ There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.  ”</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>Jahangir Alom</span></div>
                <div class="quotePosition"> <span>Co-founder of Bdtask, American business magnate</span> </div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>“ If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. ”</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
          <div class="testimonial-panel">
            <div class="tes-quoteInfo"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/avatar-1.jpg" class="quoteAvatar" alt="">
              <div>
                <div class="quoteAuthor"><span>H.M Isahaq</span></div>
                <div class="quotePosition"> <span>Co-founder of Bdtask, American business magnate</span> </div>
                <div class="testimonial--rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              </div>
            </div>
            <!-- /.testimonial-rating end -->
            <div class="testimonial--body">
              <p>“ Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making. ”</p>
            </div>
            <!-- /.testimonial-body end -->
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <!-- /.End of client logo -->
      </div>
    </div>
  </div>
</div>
<!-- /.End of testimonial content -->
<div class="blog_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="section_title">
          <h3>Cryptocurrency <span>News</span></h3>
          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="owl-blog owl-carousel owl-theme">
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-1.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading"><a href="#"><strong>IFusce</strong> <span class="dash">—</span> ac tortor et lacus volutpat euismod.</a></h3>
              <time datetime="2018-01-21T19:00" class="time"> 13/02/17</time>
              <p>It is a long established fact that a reader will be distracted by the readable content of a page</p>
              <!--                                        at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as 
                                                                            opposed to using 'Content here, content here', making it look like readable English.-->
            </div>
          </div>
        </div>
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-2.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading"><a href="#"><strong>IFusce</strong> <span class="dash">—</span> ac tortor et lacus volutpat euismod.</a></h3>
              <time datetime="2018-01-21T19:00" class="time"> 13/02/17</time>
              <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-3.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading"><a href="#"><strong>IFusce</strong> <span class="dash">—</span> ac tortor et lacus volutpat euismod.</a></h3>
              <time datetime="2018-01-21T19:00" class="time"> 13/02/17</time>
              <p>Many desktop publishing packages and web page editors now use Lorem Ipsum </p>
              <!--                                        , and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved 
                                                                            over the years, sometimes by accident, sometimes on purpose (injected humour and the like).-->
            </div>
          </div>
        </div>
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-4.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading"><a href="#"><strong>IFusce</strong> <span class="dash">—</span> ac tortor et lacus volutpat euismod.</a></h3>
              <time datetime="2018-01-21T19:00" class="time"> 13/02/17</time>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <!--                                    the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
                                                                        a type specimen book.-->
            </div>
          </div>
        </div>
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-5.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading"><a href="#"><strong>IFusce</strong> <span class="dash">—</span> ac tortor et lacus volutpat euismod.</a></h3>
              <time datetime="2018-01-21T19:00" class="time"> 13/02/17</time>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <!--                                    the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
                                                                        a type specimen book.-->
            </div>
          </div>
        </div>
        <div class="item">
          <div class="post_grid">
            <div class="grid_img"> <img src="<?php echo base_url()?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/blog/360x250-6.jpg" class="img-responsive" alt=""> </div>
            <div class="grid_body">
              <h3 class="post_heading"><a href="#"><strong>IFusce</strong> <span class="dash">—</span> ac tortor et lacus volutpat euismod.</a></h3>
              <time datetime="2018-01-21T19:00" class="time"> 13/02/17</time>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <!--                                    the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
                                                                        a type specimen book.-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>
<!-- /.End of blog content -->
<!--<footer class="footer">
<div class="footer-breadcrumbs">
  <div class="container">
    <div class="breadcrumbs-row">
      <ul class="f_breadcrumbs">
        <li><a href="#"><span>Home</span></a></li>
        <li><a href="#"><span>About</span></a></li>
      </ul>
      <div class="scroll-top" id="back-to-top">
        <div class="scroll-top-text"><span>Scroll to Top</span></div>
        <div class="scroll-top-icon"><i class="fa fa-angle-up"></i></div>
      </div>
    </div>
  </div>
</div>-->
<!-- /.End of breadcrumbs -->
<?php /*?><div class="action_btn_inner"> <a href="<?php echo site_url('member/signup');?>" class="action_btn"> <span class="action_title">Register</span> <span class="lnr lnr-chevron-right action_icon"></span> <span class="action_sub_title">Join the new era of cryptocurrency investments</span> </a> <a href="<?php echo site_url('member/login');?>" class="action_btn"> <span class="action_title">Sign in</span> <span class="lnr lnr-chevron-right action_icon"></span> <span class="action_sub_title">Access the cryptocurrency investments experience you deserve</span> </a> </div><?php */?>
<!-- /.End of action button -->
<?php /*?><div class="main_footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-5 col-md-4 col-md-offset-1">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="footer-box">
              <h3 class="footer-title">Our Company</h3>
              <ul class="footer-list">
                <li><a href="#">Referral Program</a></li>
                <li><a href="#">About Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="footer-box">
              <h3 class="footer-title">Service</h3>
              <ul class="footer-list">
                <li><a href="about.html">About Us</a></li>
                <li><a href="service.html">Service</a></li>
                <li><a href="contact.html">Contact us</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>   
