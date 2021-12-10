
<div class="dashboard-main">
<div class="container-fluid">
<div class="login-sec">
<div class="thm-container">
  <div class="login-header">
    <h2>Edit Profile</h2>
    <!--<p>Sign Up With Credentials:</p>-->
  </div>
  <?php if ($notice = $this->session->flashdata('notification')):?>
  <p class="notice"><?php echo $notice;?></p>
  <?php endif;?>
  <p><?php echo validation_errors(); ?></p>
  <form name="loginform" method="POST" action="<?php echo site_url('member/editprofile')?>">
    <div class="form-group">
      <label for="exampleInputEmail1">First Name*</label>
      <input type="text" class="form-control" name="first_name" id="exampleInputEmail1" value="<?php echo $userdetail['fname'];?>" placeholder="First name" required>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Last Name*</label>
      <input type="text" class="form-control" name="last_name" id="exampleInputEmail1" value="<?php echo $userdetail['lname'];?>" placeholder="Last name" required>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Mobile*</label>
      <div class="row">
      <div class="col-md-4">
    <select name="countryCode" class="form-control">
<option data-countryCode="DZ" value="213" <?php if($userdetail['countrycode'] == 213){?>Selected<?php } ?>>Algeria (+213)</option>
		<option data-countryCode="AD" value="376" <?php if($userdetail['countrycode'] == 376){?>Selected<?php } ?>>Andorra (+376)</option>
		<option data-countryCode="AO" value="244" <?php if($userdetail['countrycode'] == 244){?>Selected<?php } ?>>Angola (+244)</option>
		<option data-countryCode="AI" value="1264" <?php if($userdetail['countrycode'] == 1264){?>Selected<?php } ?>>Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268" <?php if($userdetail['countrycode'] == 1268){?>Selected<?php } ?>>Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54" <?php if($userdetail['countrycode'] == 54){?>Selected<?php } ?>>Argentina (+54)</option>
		<option data-countryCode="AM" value="374" <?php if($userdetail['countrycode'] == 374){?>Selected<?php } ?>>Armenia (+374)</option>
		<option data-countryCode="AW" value="297" <?php if($userdetail['countrycode'] == 297){?>Selected<?php } ?>>Aruba (+297)</option>
		<option data-countryCode="AU" value="61" <?php if($userdetail['countrycode'] == 61){?>Selected<?php } ?>>Australia (+61)</option>
		<option data-countryCode="AT" value="43" <?php if($userdetail['countrycode'] == 43){?>Selected<?php } ?>>Austria (+43)</option>
		<option data-countryCode="AZ" value="994" <?php if($userdetail['countrycode'] == 994){?>Selected<?php } ?>>Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242" <?php if($userdetail['countrycode'] == 1242){?>Selected<?php } ?>>Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973" <?php if($userdetail['countrycode'] == 973){?>Selected<?php } ?>>Bahrain (+973)</option>
		<option data-countryCode="BD" value="880" <?php if($userdetail['countrycode'] == 880){?>Selected<?php } ?>>Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246" <?php if($userdetail['countrycode'] == 1246){?>Selected<?php } ?>>Barbados (+1246)</option>
		<option data-countryCode="BY" value="375" <?php if($userdetail['countrycode'] == 375){?>Selected<?php } ?>>Belarus (+375)</option>
		<option data-countryCode="BE" value="32" <?php if($userdetail['countrycode'] == 32){?>Selected<?php } ?>>Belgium (+32)</option>
		<option data-countryCode="BZ" value="501" <?php if($userdetail['countrycode'] == 501){?>Selected<?php } ?>>Belize (+501)</option>
		<option data-countryCode="BJ" value="229" <?php if($userdetail['countrycode'] == 229){?>Selected<?php } ?>>Benin (+229)</option>
		<option data-countryCode="BM" value="1441" <?php if($userdetail['countrycode'] == 1441){?>Selected<?php } ?>>Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975" <?php if($userdetail['countrycode'] == 975){?>Selected<?php } ?>>Bhutan (+975)</option>
		<option data-countryCode="BO" value="591" <?php if($userdetail['countrycode'] == 591){?>Selected<?php } ?>>Bolivia (+591)</option>
		<option data-countryCode="BA" value="387" <?php if($userdetail['countrycode'] == 387){?>Selected<?php } ?>>Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267" <?php if($userdetail['countrycode'] == 267){?>Selected<?php } ?>>Botswana (+267)</option>
		<option data-countryCode="BR" value="55" <?php if($userdetail['countrycode'] == 55){?>Selected<?php } ?>>Brazil (+55)</option>
		<option data-countryCode="BN" value="673" <?php if($userdetail['countrycode'] == 673){?>Selected<?php } ?>>Brunei (+673)</option>
		<option data-countryCode="BG" value="359" <?php if($userdetail['countrycode'] == 359){?>Selected<?php } ?>>Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226" <?php if($userdetail['countrycode'] == 226){?>Selected<?php } ?>>Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257" <?php if($userdetail['countrycode'] == 257){?>Selected<?php } ?>>Burundi (+257)</option>
		<option data-countryCode="KH" value="855" <?php if($userdetail['countrycode'] == 855){?>Selected<?php } ?>>Cambodia (+855)</option>
		<option data-countryCode="CM" value="237" <?php if($userdetail['countrycode'] == 237){?>Selected<?php } ?>>Cameroon (+237)</option>
		<option data-countryCode="CA" value="1" <?php if($userdetail['countrycode'] == 1){?>Selected<?php } ?>>Canada (+1)</option>
		<option data-countryCode="CV" value="238" <?php if($userdetail['countrycode'] == 238){?>Selected<?php } ?>>Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345" <?php if($userdetail['countrycode'] == 1345){?>Selected<?php } ?>>Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236" <?php if($userdetail['countrycode'] == 236){?>Selected<?php } ?>>Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56" <?php if($userdetail['countrycode'] == 56){?>Selected<?php } ?>>Chile (+56)</option>
		<option data-countryCode="CN" value="86" <?php if($userdetail['countrycode'] == 86){?>Selected<?php } ?>>China (+86)</option>
		<option data-countryCode="CO" value="57" <?php if($userdetail['countrycode'] == 57){?>Selected<?php } ?>>Colombia (+57)</option>
		<option data-countryCode="KM" value="269" <?php if($userdetail['countrycode'] == 269){?>Selected<?php } ?>>Comoros (+269)</option>
		<option data-countryCode="CG" value="242" <?php if($userdetail['countrycode'] == 242){?>Selected<?php } ?>>Congo (+242)</option>
		<option data-countryCode="CK" value="682" <?php if($userdetail['countrycode'] == 682){?>Selected<?php } ?>>Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506" <?php if($userdetail['countrycode'] == 506){?>Selected<?php } ?>>Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385" <?php if($userdetail['countrycode'] == 385){?>Selected<?php } ?>>Croatia (+385)</option>
		<option data-countryCode="CU" value="53" <?php if($userdetail['countrycode'] == 53){?>Selected<?php } ?>>Cuba (+53)</option>
		<option data-countryCode="CY" value="90392" <?php if($userdetail['countrycode'] == 90392){?>Selected<?php } ?>>Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357" <?php if($userdetail['countrycode'] == 357){?>Selected<?php } ?>>Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42" <?php if($userdetail['countrycode'] == 42){?>Selected<?php } ?>>Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45" <?php if($userdetail['countrycode'] == 45){?>Selected<?php } ?>>Denmark (+45)</option>
		<option data-countryCode="DJ" value="253" <?php if($userdetail['countrycode'] == 253){?>Selected<?php } ?>>Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809" <?php if($userdetail['countrycode'] == 1809){?>Selected<?php } ?>>Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809" <?php if($userdetail['countrycode'] == 1809){?>Selected<?php } ?>>Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593" <?php if($userdetail['countrycode'] == 593){?>Selected<?php } ?>>Ecuador (+593)</option>
		<option data-countryCode="EG" value="20" <?php if($userdetail['countrycode'] == 20){?>Selected<?php } ?>>Egypt (+20)</option>
		<option data-countryCode="SV" value="503" <?php if($userdetail['countrycode'] == 503){?>Selected<?php } ?>>El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240" <?php if($userdetail['countrycode'] == 240){?>Selected<?php } ?>>Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291" <?php if($userdetail['countrycode'] == 291){?>Selected<?php } ?>>Eritrea (+291)</option>
		<option data-countryCode="EE" value="372" <?php if($userdetail['countrycode'] == 372){?>Selected<?php } ?>>Estonia (+372)</option>
		<option data-countryCode="ET" value="251" <?php if($userdetail['countrycode'] == 251){?>Selected<?php } ?>>Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500" <?php if($userdetail['countrycode'] == 500){?>Selected<?php } ?>>Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298" <?php if($userdetail['countrycode'] == 298){?>Selected<?php } ?>>Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679" <?php if($userdetail['countrycode'] == 679){?>Selected<?php } ?>>Fiji (+679)</option>
		<option data-countryCode="FI" value="358" <?php if($userdetail['countrycode'] == 358){?>Selected<?php } ?>>Finland (+358)</option>
		<option data-countryCode="FR" value="33" <?php if($userdetail['countrycode'] == 33){?>Selected<?php } ?>>France (+33)</option>
		<option data-countryCode="GF" value="594" <?php if($userdetail['countrycode'] == 594){?>Selected<?php } ?>>French Guiana (+594)</option>
		<option data-countryCode="PF" value="689" <?php if($userdetail['countrycode'] == 689){?>Selected<?php } ?>>French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241" <?php if($userdetail['countrycode'] == 241){?>Selected<?php } ?>>Gabon (+241)</option>
		<option data-countryCode="GM" value="220" <?php if($userdetail['countrycode'] == 220){?>Selected<?php } ?>>Gambia (+220)</option>
		<option data-countryCode="GE" value="7880" <?php if($userdetail['countrycode'] == 7880){?>Selected<?php } ?>>Georgia (+7880)</option>
		<option data-countryCode="DE" value="49" <?php if($userdetail['countrycode'] == 49){?>Selected<?php } ?>>Germany (+49)</option>
		<option data-countryCode="GH" value="233" <?php if($userdetail['countrycode'] == 233){?>Selected<?php } ?>>Ghana (+233)</option>
		<option data-countryCode="GI" value="350" <?php if($userdetail['countrycode'] == 350){?>Selected<?php } ?>>Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30" <?php if($userdetail['countrycode'] == 30){?>Selected<?php } ?>>Greece (+30)</option>
		<option data-countryCode="GL" value="299" <?php if($userdetail['countrycode'] == 299){?>Selected<?php } ?>>Greenland (+299)</option>
		<option data-countryCode="GD" value="1473" <?php if($userdetail['countrycode'] == 1473){?>Selected<?php } ?>>Grenada (+1473)</option>
		<option data-countryCode="GP" value="590" <?php if($userdetail['countrycode'] == 590){?>Selected<?php } ?>>Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671" <?php if($userdetail['countrycode'] == 671){?>Selected<?php } ?>>Guam (+671)</option>
		<option data-countryCode="GT" value="502" <?php if($userdetail['countrycode'] == 502){?>Selected<?php } ?>>Guatemala (+502)</option>
		<option data-countryCode="GN" value="224" <?php if($userdetail['countrycode'] == 224){?>Selected<?php } ?>>Guinea (+224)</option>
		<option data-countryCode="GW" value="245" <?php if($userdetail['countrycode'] == 245){?>Selected<?php } ?>>Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592" <?php if($userdetail['countrycode'] == 592){?>Selected<?php } ?>>Guyana (+592)</option>
		<option data-countryCode="HT" value="509" <?php if($userdetail['countrycode'] == 509){?>Selected<?php } ?>>Haiti (+509)</option>
		<option data-countryCode="HN" value="504" <?php if($userdetail['countrycode'] == 504){?>Selected<?php } ?>>Honduras (+504)</option>
		<option data-countryCode="HK" value="852" <?php if($userdetail['countrycode'] == 852){?>Selected<?php } ?>>Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36" <?php if($userdetail['countrycode'] == 36){?>Selected<?php } ?>>Hungary (+36)</option>
		<option data-countryCode="IS" value="354" <?php if($userdetail['countrycode'] == 354){?>Selected<?php } ?>>Iceland (+354)</option>
		<option data-countryCode="IN" value="91" <?php if($userdetail['countrycode'] == 91){?>Selected<?php } ?>>India (+91)</option>
		<option data-countryCode="ID" value="62" <?php if($userdetail['countrycode'] == 62){?>Selected<?php } ?>>Indonesia (+62)</option>
		<option data-countryCode="IR" value="98" <?php if($userdetail['countrycode'] == 98){?>Selected<?php } ?>>Iran (+98)</option>
		<option data-countryCode="IQ" value="964" <?php if($userdetail['countrycode'] == 964){?>Selected<?php } ?>>Iraq (+964)</option>
		<option data-countryCode="IE" value="353" <?php if($userdetail['countrycode'] == 353){?>Selected<?php } ?>>Ireland (+353)</option>
		<option data-countryCode="IL" value="972" <?php if($userdetail['countrycode'] == 972){?>Selected<?php } ?>>Israel (+972)</option>
		<option data-countryCode="IT" value="39" <?php if($userdetail['countrycode'] == 39){?>Selected<?php } ?>>Italy (+39)</option>
		<option data-countryCode="JM" value="1876" <?php if($userdetail['countrycode'] == 1876){?>Selected<?php } ?>>Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81" <?php if($userdetail['countrycode'] == 81){?>Selected<?php } ?>>Japan (+81)</option>
		<option data-countryCode="JO" value="962" <?php if($userdetail['countrycode'] == 962){?>Selected<?php } ?>>Jordan (+962)</option>
		<option data-countryCode="KZ" value="7" <?php if($userdetail['countrycode'] == 7){?>Selected<?php } ?>>Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254" <?php if($userdetail['countrycode'] == 254){?>Selected<?php } ?>>Kenya (+254)</option>
		<option data-countryCode="KI" value="686" <?php if($userdetail['countrycode'] == 686){?>Selected<?php } ?>>Kiribati (+686)</option>
		<option data-countryCode="KP" value="850" <?php if($userdetail['countrycode'] == 850){?>Selected<?php } ?>>Korea North (+850)</option>
		<option data-countryCode="KR" value="82" <?php if($userdetail['countrycode'] == 82){?>Selected<?php } ?>>Korea South (+82)</option>
		<option data-countryCode="KW" value="965" <?php if($userdetail['countrycode'] == 965){?>Selected<?php } ?>>Kuwait (+965)</option>
		<option data-countryCode="KG" value="996" <?php if($userdetail['countrycode'] == 996){?>Selected<?php } ?>>Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856" <?php if($userdetail['countrycode'] == 856){?>Selected<?php } ?>>Laos (+856)</option>
		<option data-countryCode="LV" value="371" <?php if($userdetail['countrycode'] == 371){?>Selected<?php } ?>>Latvia (+371)</option>
		<option data-countryCode="LB" value="961" <?php if($userdetail['countrycode'] == 961){?>Selected<?php } ?>>Lebanon (+961)</option>
		<option data-countryCode="LS" value="266" <?php if($userdetail['countrycode'] == 266){?>Selected<?php } ?>>Lesotho (+266)</option>
		<option data-countryCode="LR" value="231" <?php if($userdetail['countrycode'] == 231){?>Selected<?php } ?>>Liberia (+231)</option>
		<option data-countryCode="LY" value="218" <?php if($userdetail['countrycode'] == 218){?>Selected<?php } ?>>Libya (+218)</option>
		<option data-countryCode="LI" value="417" <?php if($userdetail['countrycode'] == 417){?>Selected<?php } ?>>Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370" <?php if($userdetail['countrycode'] == 370){?>Selected<?php } ?>>Lithuania (+370)</option>
		<option data-countryCode="LU" value="352" <?php if($userdetail['countrycode'] == 352){?>Selected<?php } ?>>Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853" <?php if($userdetail['countrycode'] == 853){?>Selected<?php } ?>>Macao (+853)</option>
		<option data-countryCode="MK" value="389" <?php if($userdetail['countrycode'] == 389){?>Selected<?php } ?>>Macedonia (+389)</option>
		<option data-countryCode="MG" value="261" <?php if($userdetail['countrycode'] == 261){?>Selected<?php } ?>>Madagascar (+261)</option>
		<option data-countryCode="MW" value="265" <?php if($userdetail['countrycode'] == 265){?>Selected<?php } ?>>Malawi (+265)</option>
		<option data-countryCode="MY" value="60" <?php if($userdetail['countrycode'] == 60){?>Selected<?php } ?>>Malaysia (+60)</option>
		<option data-countryCode="MV" value="960" <?php if($userdetail['countrycode'] == 960){?>Selected<?php } ?>>Maldives (+960)</option>
		<option data-countryCode="ML" value="223" <?php if($userdetail['countrycode'] == 223){?>Selected<?php } ?>>Mali (+223)</option>
		<option data-countryCode="MT" value="356" <?php if($userdetail['countrycode'] == 356){?>Selected<?php } ?>>Malta (+356)</option>
		<option data-countryCode="MH" value="692" <?php if($userdetail['countrycode'] == 692){?>Selected<?php } ?>>Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596" <?php if($userdetail['countrycode'] == 596){?>Selected<?php } ?>>Martinique (+596)</option>
		<option data-countryCode="MR" value="222" <?php if($userdetail['countrycode'] == 222){?>Selected<?php } ?>>Mauritania (+222)</option>
		<option data-countryCode="YT" value="269" <?php if($userdetail['countrycode'] == 269){?>Selected<?php } ?>>Mayotte (+269)</option>
		<option data-countryCode="MX" value="52" <?php if($userdetail['countrycode'] == 52){?>Selected<?php } ?>>Mexico (+52)</option>
		<option data-countryCode="FM" value="691" <?php if($userdetail['countrycode'] == 691){?>Selected<?php } ?>>Micronesia (+691)</option>
		<option data-countryCode="MD" value="373" <?php if($userdetail['countrycode'] == 373){?>Selected<?php } ?>>Moldova (+373)</option>
		<option data-countryCode="MC" value="377" <?php if($userdetail['countrycode'] == 377){?>Selected<?php } ?>>Monaco (+377)</option>
		<option data-countryCode="MN" value="976" <?php if($userdetail['countrycode'] == 976){?>Selected<?php } ?>>Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664" <?php if($userdetail['countrycode'] == 1664){?>Selected<?php } ?>>Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212" <?php if($userdetail['countrycode'] == 212){?>Selected<?php } ?>>Morocco (+212)</option>
		<option data-countryCode="MZ" value="258" <?php if($userdetail['countrycode'] == 258){?>Selected<?php } ?>>Mozambique (+258)</option>
		<option data-countryCode="MN" value="95" <?php if($userdetail['countrycode'] == 95){?>Selected<?php } ?>>Myanmar (+95)</option>
		<option data-countryCode="NA" value="264" <?php if($userdetail['countrycode'] == 264){?>Selected<?php } ?>>Namibia (+264)</option>
		<option data-countryCode="NR" value="674" <?php if($userdetail['countrycode'] == 674){?>Selected<?php } ?>>Nauru (+674)</option>
		<option data-countryCode="NP" value="977" <?php if($userdetail['countrycode'] == 977){?>Selected<?php } ?>>Nepal (+977)</option>
		<option data-countryCode="NL" value="31" <?php if($userdetail['countrycode'] == 31){?>Selected<?php } ?>>Netherlands (+31)</option>
		<option data-countryCode="NC" value="687" <?php if($userdetail['countrycode'] == 687){?>Selected<?php } ?>>New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64" <?php if($userdetail['countrycode'] == 64){?>Selected<?php } ?>>New Zealand (+64)</option>
		<option data-countryCode="NI" value="505" <?php if($userdetail['countrycode'] == 505){?>Selected<?php } ?>>Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227" <?php if($userdetail['countrycode'] == 227){?>Selected<?php } ?>>Niger (+227)</option>
		<option data-countryCode="NG" value="234" <?php if($userdetail['countrycode'] == 234){?>Selected<?php } ?>>Nigeria (+234)</option>
		<option data-countryCode="NU" value="683" <?php if($userdetail['countrycode'] == 683){?>Selected<?php } ?>>Niue (+683)</option>
		<option data-countryCode="NF" value="672" <?php if($userdetail['countrycode'] == 672){?>Selected<?php } ?>>Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670" <?php if($userdetail['countrycode'] == 670){?>Selected<?php } ?>>Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47" <?php if($userdetail['countrycode'] == 47){?>Selected<?php } ?>>Norway (+47)</option>
		<option data-countryCode="OM" value="968" <?php if($userdetail['countrycode'] == 968){?>Selected<?php } ?>>Oman (+968)</option>
		<option data-countryCode="PW" value="680" <?php if($userdetail['countrycode'] == 680){?>Selected<?php } ?>>Palau (+680)</option>
		<option data-countryCode="PA" value="507" <?php if($userdetail['countrycode'] == 507){?>Selected<?php } ?>>Panama (+507)</option>
		<option data-countryCode="PG" value="675" <?php if($userdetail['countrycode'] == 675){?>Selected<?php } ?>>Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595" <?php if($userdetail['countrycode'] == 595){?>Selected<?php } ?>>Paraguay (+595)</option>
		<option data-countryCode="PE" value="51" <?php if($userdetail['countrycode'] == 51){?>Selected<?php } ?>>Peru (+51)</option>
		<option data-countryCode="PH" value="63" <?php if($userdetail['countrycode'] == 63){?>Selected<?php } ?>>Philippines (+63)</option>
		<option data-countryCode="PL" value="48" <?php if($userdetail['countrycode'] == 48){?>Selected<?php } ?>>Poland (+48)</option>
		<option data-countryCode="PT" value="351" <?php if($userdetail['countrycode'] == 351){?>Selected<?php } ?>>Portugal (+351)</option>
		<option data-countryCode="PR" value="1787" <?php if($userdetail['countrycode'] == 1787){?>Selected<?php } ?>>Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974" <?php if($userdetail['countrycode'] == 974){?>Selected<?php } ?>>Qatar (+974)</option>
		<option data-countryCode="RE" value="262" <?php if($userdetail['countrycode'] == 262){?>Selected<?php } ?>>Reunion (+262)</option>
		<option data-countryCode="RO" value="40" <?php if($userdetail['countrycode'] == 40){?>Selected<?php } ?>>Romania (+40)</option>
		<option data-countryCode="RU" value="7" <?php if($userdetail['countrycode'] == 7){?>Selected<?php } ?>>Russia (+7)</option>
		<option data-countryCode="RW" value="250" <?php if($userdetail['countrycode'] == 250){?>Selected<?php } ?>>Rwanda (+250)</option>
		<option data-countryCode="SM" value="378" <?php if($userdetail['countrycode'] == 378){?>Selected<?php } ?>>San Marino (+378)</option>
		<option data-countryCode="ST" value="239" <?php if($userdetail['countrycode'] == 239){?>Selected<?php } ?>>Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966" <?php if($userdetail['countrycode'] == 966){?>Selected<?php } ?>>Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221" <?php if($userdetail['countrycode'] == 221){?>Selected<?php } ?>>Senegal (+221)</option>
		<option data-countryCode="CS" value="381" <?php if($userdetail['countrycode'] == 381){?>Selected<?php } ?>>Serbia (+381)</option>
		<option data-countryCode="SC" value="248" <?php if($userdetail['countrycode'] == 248){?>Selected<?php } ?>>Seychelles (+248)</option>
		<option data-countryCode="SL" value="232" <?php if($userdetail['countrycode'] == 232){?>Selected<?php } ?>>Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65" <?php if($userdetail['countrycode'] == 65){?>Selected<?php } ?>>Singapore (+65)</option>
		<option data-countryCode="SK" value="421" <?php if($userdetail['countrycode'] == 421){?>Selected<?php } ?>>Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386" <?php if($userdetail['countrycode'] == 386){?>Selected<?php } ?>>Slovenia (+386)</option>
		<option data-countryCode="SB" value="677" <?php if($userdetail['countrycode'] == 677){?>Selected<?php } ?>>Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252" <?php if($userdetail['countrycode'] == 252){?>Selected<?php } ?>>Somalia (+252)</option>
		<option data-countryCode="ZA" value="27" <?php if($userdetail['countrycode'] == 27){?>Selected<?php } ?>>South Africa (+27)</option>
		<option data-countryCode="ES" value="34" <?php if($userdetail['countrycode'] == 34){?>Selected<?php } ?>>Spain (+34)</option>
		<option data-countryCode="LK" value="94" <?php if($userdetail['countrycode'] == 94){?>Selected<?php } ?>>Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290" <?php if($userdetail['countrycode'] == 290){?>Selected<?php } ?>>St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869" <?php if($userdetail['countrycode'] == 1869){?>Selected<?php } ?>>St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758" <?php if($userdetail['countrycode'] == 1758){?>Selected<?php } ?>>St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249" <?php if($userdetail['countrycode'] == 249){?>Selected<?php } ?>>Sudan (+249)</option>
		<option data-countryCode="SR" value="597" <?php if($userdetail['countrycode'] == 597){?>Selected<?php } ?>>Suriname (+597)</option>
		<option data-countryCode="SZ" value="268" <?php if($userdetail['countrycode'] == 268){?>Selected<?php } ?>>Swaziland (+268)</option>
		<option data-countryCode="SE" value="46" <?php if($userdetail['countrycode'] == 46){?>Selected<?php } ?>>Sweden (+46)</option>
		<option data-countryCode="CH" value="41" <?php if($userdetail['countrycode'] == 41){?>Selected<?php } ?>>Switzerland (+41)</option>
		<option data-countryCode="SI" value="963" <?php if($userdetail['countrycode'] == 963){?>Selected<?php } ?>>Syria (+963)</option>
		<option data-countryCode="TW" value="886" <?php if($userdetail['countrycode'] == 886){?>Selected<?php } ?>>Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7" <?php if($userdetail['countrycode'] == 7){?>Selected<?php } ?>>Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66" <?php if($userdetail['countrycode'] == 66){?>Selected<?php } ?>>Thailand (+66)</option>
		<option data-countryCode="TG" value="228" <?php if($userdetail['countrycode'] == 228){?>Selected<?php } ?>>Togo (+228)</option>
		<option data-countryCode="TO" value="676" <?php if($userdetail['countrycode'] == 676){?>Selected<?php } ?>>Tonga (+676)</option>
		<option data-countryCode="TT" value="1868" <?php if($userdetail['countrycode'] == 1868){?>Selected<?php } ?>>Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216" <?php if($userdetail['countrycode'] == 216){?>Selected<?php } ?>>Tunisia (+216)</option>
		<option data-countryCode="TR" value="90" <?php if($userdetail['countrycode'] == 90){?>Selected<?php } ?>>Turkey (+90)</option>
		<option data-countryCode="TM" value="7" <?php if($userdetail['countrycode'] == 7){?>Selected<?php } ?>>Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993" <?php if($userdetail['countrycode'] == 993){?>Selected<?php } ?>>Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649" <?php if($userdetail['countrycode'] == 1649){?>Selected<?php } ?>>Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688" <?php if($userdetail['countrycode'] == 688){?>Selected<?php } ?>>Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256" <?php if($userdetail['countrycode'] == 256){?>Selected<?php } ?>>Uganda (+256)</option>
		<option data-countryCode="GB" value="44" <?php if($userdetail['countrycode'] == 44){?>Selected<?php } ?>>UK (+44)</option> 
		<option data-countryCode="UA" value="380" <?php if($userdetail['countrycode'] == 380){?>Selected<?php } ?>>Ukraine (+380)</option>
		<option data-countryCode="AE" value="971" <?php if($userdetail['countrycode'] == 971){?>Selected<?php } ?>>United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598" <?php if($userdetail['countrycode'] == 598){?>Selected<?php } ?>>Uruguay (+598)</option>
	  <option data-countryCode="US" value="1" <?php if($userdetail['countrycode'] == 1){?>Selected<?php } ?>>USA (+1)</option> 
		<option data-countryCode="UZ" value="7" <?php if($userdetail['countrycode'] == 7){?>Selected<?php } ?>>Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678" <?php if($userdetail['countrycode'] == 678){?>Selected<?php } ?>>Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379" <?php if($userdetail['countrycode'] == 379){?>Selected<?php } ?>>Vatican City (+379)</option>
		<option data-countryCode="VE" value="58" <?php if($userdetail['countrycode'] == 58){?>Selected<?php } ?>>Venezuela (+58)</option>
		<option data-countryCode="VN" value="84" <?php if($userdetail['countrycode'] == 84){?>Selected<?php } ?>>Vietnam (+84)</option>
		<option data-countryCode="VG" value="84" <?php if($userdetail['countrycode'] == 84){?>Selected<?php } ?>>Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84" <?php if($userdetail['countrycode'] == 84){?>Selected<?php } ?>>Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681" <?php if($userdetail['countrycode'] == 681){?>Selected<?php } ?>>Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969" <?php if($userdetail['countrycode'] == 969){?>Selected<?php } ?>>Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967" <?php if($userdetail['countrycode'] == 967){?>Selected<?php } ?>>Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260" <?php if($userdetail['countrycode'] == 260){?>Selected<?php } ?>>Zambia (+260)</option>
		<option data-countryCode="ZW" value="263" <?php if($userdetail['countrycode'] == 263){?>Selected<?php } ?>>Zimbabwe (+263)</option>
	
</select></div>
<div class="col-md-8"><input type="text" class="form-control" name="phone" id="exampleInputEmail1" value="<?php echo $userdetail['phone'];?>" placeholder="Mobile" required></div>
  </div>
  </div> 
    <button type="submit" value="Submit" class="btn btn-default secondary-btn btn-block">Submit</button>
    
  </form>
</div>
</div>
</div>
</div>
