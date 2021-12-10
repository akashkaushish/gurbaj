<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-edit"></i> Edit Packages</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?php echo site_url('merchandise/admin/packages');?>">Packages List</a></li>
      <li class="breadcrumb-item">Edit Packages</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Edit Packages</h3>
        <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
        <p class="notice">
          <?php  echo $notice;?>
        </p>
        <?php  endif;?>
        <form class="settings" onsubmit="return validateForm()" name="myForm" action="<?php  echo site_url('merchandise/admin/editpack/'.$pack['id'])?>" method="post" accept-charset="utf-8">
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Product ID</label>
              <input class="form-control" type="text" name="productid" value="<?php echo $pack['product_id'];?>" />
            </div>
            <div class="form-group">
              <label class="control-label">Product Name</label>
              <input class="form-control" type="text" name="name"  value="<?=$pack['name']?>"/>
            </div>          
			<div class="form-group">
              <label class="control-label">Product Image</label>
              <input class="form-control" type="text" name="img"/>
            </div>
			
			<div class="form-group">
              <label class="control-label">Package Animations</label>
             <select name="anima[]" class="form-control" multiple>
          <?php 
                $arr = explode(',', $pack['pack_animations']);
                $ani = $this->db->get('animations')->result_array();
                foreach($ani as $a){
              ?>
          <option value="<?=$a['id']?>" <?php if(in_array($a['id'], $arr)) echo 'selected'; ?> >
          <?=$a['name']?>
          </option>
          <?php
                }
              ?>
        </select>
            </div>
			
			<div class="form-group">
              <label class="control-label">Product Price</label>
              <input class="form-control" type="text" name="price" value="<?php echo $pack['price'];?>"/>
            </div>
			<div class="form-group">
              <label class="control-label">Product Description</label>
              <input class="form-control" type="text" name="description" value="<?php echo $pack['description'];?>"/>
            </div>
          </div>
          <div class="tile-footer">
            <button type="submit"  name="prodsub" value="<?php  echo "Save";?>" class="btn btn-primary">
            <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
            </button>
            <a class="btn btn-secondary" href="<?php echo site_url('merchandise/admin/packages');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a> </div>
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
      <p style="float: left">
        <?php  echo "Packages" ;?>
      </p>
      <p style="float: right;"><a href="<?php  echo site_url('merchandise/admin/packages')?>">
        <?php  echo "Packages" ;?>
        </a></p>
    </h1>
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
<form action="<?php  echo site_url('merchandise/admin/editpack/'.$pack['id'])?>" method="post" style="margin: 2% 14%;">
  <table>
    <tr>
      <td><label class="nlables">Product ID</label></td>
      <td><input class="textn" type="text" name="productid" value="<?=$pack['product_id']?>" /></td>
    </tr>
    <tr>
      <td><label class="nlables">Product Name</label></td>
      <td><input class="textn" type="text" name="name" value="<?=$pack['name']?>"/></td>
    </tr>
    <tr>
      <td><label class="nlables">Product Image</label></td>
      <td><input class="textn" type="file" name="img" /></td>
    </tr>
    <tr>
      <td><label class="nlables">Package Animations</label></td>
      <td><select name="anima[]" multiple>
          <?php 
                $arr = explode(',', $pack['pack_animations']);
                $ani = $this->db->get('animations')->result_array();
                foreach($ani as $a){
              ?>
          <option value="<?=$a['id']?>" <?php if(in_array($a['id'], $arr)) echo 'selected'; ?> >
          <?=$a['name']?>
          </option>
          <?php
                }
              ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label class="nlables">Product Price</label></td>
      <td><input class="textn" type="text" name="price" value="<?=$pack['price']?>"/></td>
    </tr>
    <tr>
      <td><label class="nlables">Product Description</label></td>
      <td><input class="textn" type="text" name="description" value="<?=$pack['description']?>"/></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center;"><input class="textn" type="submit" style="width: 150px;" name="prodsub" value="Edit Package" /></td>
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