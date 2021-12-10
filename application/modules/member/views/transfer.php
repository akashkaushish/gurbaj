
<div class="header bg-transparent pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Transfer Funds To Your Friend</h6>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
  <div class="col-xl-12">
    <div class="card bg-default">
      <div class="card-header bg-transparent border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="text-white mb-0">Wallet Amount:  $
              <?php  echo round($totalwallet, 2);  ?>
            </h3>
          </div>
        </div>
      </div>
      <div class="card-body">
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
        <form class="form-horizontal" method="POST" action="<?php echo site_url('member/transferrequest')?>" >
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label class="form-control-label">Recipient ID*</label>
              <input type="text" name="email" class="form-control input-solid" placeholder="Recipient ID"  id="ref_code" required>
			   <i data-toggle="tooltip" data-placement="top" title="To get parent user information, click here" class="fa fa-info-circle" aria-hidden="true" id="info" onclick="getuserinfo(document.getElementById('ref_code').value)"></i> 
              <div class="valid-feedback"> Looks good! </div>
			  <div id="bg" style="text-align:center; display:none; padding:30px 0px;"> <img width="50px"  src="<?php echo base_url();?>application/views/<?php echo $this->system->theme_dir . $this->system->theme ?>/assets/img/wait.gif" class="navbar-brand-img" alt="..."> </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-control-label">Amount* $</label>
              <select name="amount" class="form-control" >
                <option value="">Choose Amount</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
                <option value="60">60</option>
                <option value="65">65</option>
                <option value="70">70</option>
                <option value="75">75</option>
                <option value="80">80</option>
                <option value="85">85</option>
                <option value="90">90</option>
                <option value="95">95</option>
                <?php for($i=0;$i<count($plans);$i++){ ?>
                <option value="<?php echo $plans[$i]['price']; ?>"><?php echo $plans[$i]['price']; ?></option>
                <?php } ?>
              </select>
              <div class="valid-feedback"> Looks good! </div>
            </div>
            <div class="col-md-12">
              <button class="btn btn-primary" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function getuserinfo(id)
{
    if(id != '')
    {
      $(".info2").remove(); 
      $("#bg").show(); 
    $(document).ready(function(){
    $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>index.php?/member/getparentuserinfo",
	  data: {code:id},
    success: function(result){
      if(result == 0){
        $("#bg").hide(); 
        $("<p class='info2'>No user found related to this Refferal code</p>").insertAfter("#info");
      }else{
        $("#bg").hide(); 
        $("<p class='info2'>"+result+"</p>").insertAfter("#info");
      }
	
    }
    });
  });
  }else{
    alert('Please enter Refferal Code.'); 
    document.getElementById('ref_code').focus();
    return false;
  }
}

</script>
<style>.col-md-4 .fa-info-circle {
    position: absolute;
    z-index: 10;
    top: 42px;
    right: 25px;
    cursor: pointer;
}</style>