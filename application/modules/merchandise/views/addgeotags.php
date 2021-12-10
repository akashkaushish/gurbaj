<style type="text/css">
  .nlables{
    width: 300px;
  }
  .textn{
    width: 600px;
  }
</style>
<div class="container">
<div class="content wide">
  <h1 id="page">
    <p style="float: left"><?php  echo "Packages" ;?></p>
    <p style="float: right;"><a href="<?php  echo site_url('merchandise/admin/geotags')?>"><?php  echo "Geotag Plans" ;?></a></p>
  </h1>

 <!--  <ul class="manage">
  	<li><a href="<?php  echo site_url('admin/member/create')?>"><?php  echo "Add a Package";?></a></li>
  	<li><a href="<?php  echo site_url('admin')?>" class="last"><?php  echo "Cancel";?></a></li>
  </ul> -->
  <br class="clearfloat" />
  <hr />
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <table style="width:100%">
    <form action="<?php  echo site_url($this->uri->uri_string()) ?>" method="post" name="myform" class="myform" >
      <tr>
        <td></td>
        <td width="20%"><input type="text" class="input-text" name="filter" value="<?php  echo $this->input->post('filter') ?>" />
        </td>
        <td><input type="submit" class="input-submit" id="submit" name="submit" value="<?php  echo "Search"; ?>" />
        </td>
        <td align="right"><select name="sorting" onchange="javascript:submitdata();">
            <option value="" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='')){?>selected<?php }?>>Sort Data</option>
            <option value="registered" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='registered')){?>selected<?php }?>>By Register Date</option>
            <option value="name" <?php if(isset($_POST['sorting']) && ($_POST['sorting']=='name')){?>selected<?php }?>>By Name</option>
          </select>
        </td>
      </tr>
    </form>
  </table>
</div>
</div>
<form action="<?php  echo site_url('merchandise/admin/addgeotags')?>" method="post" style="margin: 2% 14%;">
    <table>
      <tr>
        <td><label class="nlables">Product ID</label></td>
        <td><input class="textn" type="text" name="productid" /></td>
      </tr>
      <tr>
        <td><label class="nlables">Plan</label></td>
        <td><input class="textn" type="text" name="name" /></td>
      </tr>
        <td><label class="nlables">Price</label></td>
        <td><input class="textn" type="text" name="price" /></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;"><input class="textn" type="submit" style="width: 150px;" name="prodsub" value="Add Geotag Plan" /></td>
      </tr>
    </table>
  </form>
<script>
		function submitdata(){ 
			$(document).ready(function () {
			     $("#submit").click();
			});
		
		}
	</script>
<!-- [Content] end -->
