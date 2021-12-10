<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Animations Animations</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('merchandise/admin/animations');?>">Animations List</a></li>
      <li class="breadcrumb-item">Animations List</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Add Animations</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('merchandise/admin/addanimations')?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Animation ID</label>
              <input class="form-control" type="text" name="productid" />
            </div>
            <div class="form-group">
              <label class="control-label">Animation Name</label>
              <input class="form-control" type="text" name="name"  />
            </div>
			<div class="form-group">
              <label class="control-label">Animation type</label>
              <input class="form-control" type="text" name="type" />
            </div>
            <div class="form-group">
              <label class="control-label">Animation Category</label>
              <input class="form-control" type="text" name="cate" />
            </div>
			
			<div class="form-group">
              <label class="control-label">Animation Image</label>
              <input class="form-control" type="text" name="img" />
            </div>
			<div class="form-group">
              <label class="control-label">Animation Price</label>
              <input class="form-control" type="text" name="price" />
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit"  name="prodsub" value="<?php  echo "Save";?>" class="btn btn-primary" type="button">
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
            </button>
            <a class="btn btn-secondary" href="<?php echo site_url('merchandise/admin/animations');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
        </form>
      </div>
    </div>
  </div>
</main>
<?php /*?><style type="text/css">
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
    <p style="float: right;"><a href="<?php  echo site_url('merchandise/admin/animations')?>"><?php  echo "Animations" ;?></a></p>
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
<form action="<?php  echo site_url('merchandise/admin/addanimations')?>" method="post" style="margin: 2% 14%;">
    <table>
      <tr>
        <td><label class="nlables">Animation ID</label></td>
        <td><input class="textn" type="text" name="productid" /></td>
      </tr>
      <tr>
        <td><label class="nlables">Animation Name</label></td>
        <td><input class="textn" type="text" name="name" /></td>
      </tr>
      <tr>
        <td><label class="nlables">Animation Type</label></td>
        <td><input class="textn" type="text" name="type" /></td>
      </tr>
      <tr>
        <td><label class="nlables">Animations Category</label></td>
        <td><input class="textn" type="text" name="cate" /></td>
      </tr>
      <tr>
        <td><label class="nlables">Animation Image</label></td>
        <td><input class="textn" type="text" name="img" /></td>
      </tr>
      <tr>
        <td><label class="nlables">Animation Price</label></td>
        <td><input class="textn" type="text" name="price" /></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;"><input class="textn" type="submit" style="width: 150px;" name="prodsub" value="Add Animation" /></td>
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
<?php */?>