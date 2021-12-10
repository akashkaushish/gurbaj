<!--annual sale-->

<div class="annual-sales brands-list">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice" style="clear:both;">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <div class="head">
    <h2 class="d-inline-block"> Order Detail List</h2>
    <a href="<?php  echo site_url($module.'/admin/orderlist')?>" class="btn btn-success float-right">Back</a></div>
  <div class="table-responsive">
    <?php  if($order) : ?>
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
          <th  class="center">#</th>
                <th scope="col">Image</th>
                <th scope="col">Product</th>
                <th scope="col">Brand</th>
                <th scope="col" >Quantity</th>
                <th scope="col">Bag Size</th>
                <th scope="col">Cost</th>
                <th scope="col">Selling Price</th>
                <th scope="col">Status</th>
                <th scope="col">Note</th>
                <th scope="col">SKU</th>
                <?php foreach($columnname as $namedata){?>
                <th scope="col"><?php echo $namedata['attribute_name'];?></th>
                <?php }?>
        </tr>
      </thead>
      <tbody>
         <?php if(count($products) > 0){ for($i=0;$i<count($products);$i++){ ?>
              <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
              <tr class="<?php  echo $rowClass?>">
                <td class="center"><?php  echo ($i+1) ?></td>
                <td><?php if($products[$i]['picture'] != ""){ ?>
                  <img  style="width:100px;" class="card-img-top" alt="Image placeholder" src="<?php echo base_url()?>media/product/<?php echo $products[$i]['picture']; ?>" >
                  <?php }else{ ?>
                  <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/no_image.png" width="100px">
                  <?php } ?></td>
				   <td><?php echo $products[$i]['name']; ?></td>
              
               
                <td><?php echo $products[$i]['brand_name']; ?></td>
                <td class="quantity"><?php echo $products[$i]['quantity']; ?></td>
                <td><?php echo $products[$i]['bag_size']; ?></td>
                <td><?php echo $products[$i]['default_price']; ?></td>
                <td><?php if($order[0]['is_active'] == 1) { ?>
                  <input type="text" size="4" name="price_per_unit" class="price_per_unit" value="<?php echo $products[$i]['price_per_unit']; ?>"  id="<?php echo $i; ?>"/>
                  <input type="button" name="" value="Add" onclick="updateprice('<?php echo $products[$i]['orderproduct_id']?>','<?php echo $i; ?>');" />
                  <input type="hidden" size="4" name="price_per_unit1" class="price_per_unit1 <?php echo $i; ?>" value="<?php echo $products[$i]['price_per_unit']; ?>" />
                  <?php }else{ ?>
                  <?php echo $products[$i]['price_per_unit']; ?>
                  <?php } ?>
                </td>
                <td><?php if($products[$i]['is_purchaser_verified'] ==1){ echo "Normal"; }else{ echo "New"; } ?></td>
                <td><?php echo $products[$i]['note']; ?></td>
                <td><?php echo $products[$i]['sku']; ?></td>
                <?php foreach($columnname as $namedata){?>
                <?php $name= $namedata['attribute_name'];?>
                <td><?php echo $products[$i][$name]; ?></td>
                <?php }?>
              </tr>
              <?php   } }?>
      </tbody>
    </table>
    <?php  else: ?>
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
          <th  class="center">#</th>
                <th scope="col">Image</th>
                <th scope="col">Product</th>
                <th scope="col">Brand</th>
                <th scope="col" >Quantity</th>
                <th scope="col">Bag Size</th>
                <th scope="col">Cost</th>
                <th scope="col">Selling Price</th>
                <th scope="col">Status</th>
                <th scope="col">Note</th>
                <th scope="col">SKU</th>
                <?php foreach($columnname as $namedata){?>
                <th scope="col"><?php echo $namedata['attribute_name'];?></th>
                <?php }?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">No details Found</td>
        </tr>
      </tbody>
    </table>
    <?php  endif ; ?>
  </div>
</div>
<?php /*?><main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-shopping-cart"></i> Order Detail List</h1>
  </div>
  <div><</div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Order Detail List</li>
  </ul>
</div>
<?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
<p class="notice" style="clear:both;">
  <?php  echo $notice;?>
</p>
<?php  endif;?>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <?php  if($order) { ?>
        <div class="table-responsive">
          <table class="table table-hover " id="sampleTable">
            <thead>
              <tr>
                <th  class="center">#</th>
                <th scope="col">Image</th>
                <th scope="col">Product</th>
                <th scope="col">Brand</th>
                <th scope="col" >Quantity</th>
                <th scope="col">Bag Size</th>
                <th scope="col">Cost</th>
                <th scope="col">Selling Price</th>
                <th scope="col">Status</th>
                <th scope="col">Note</th>
                <th scope="col">SKU</th>
                <?php foreach($columnname as $namedata){?>
                <th scope="col"><?php echo $namedata['attribute_name'];?></th>
                <?php }?>
              </tr>
            </thead>
            <tbody>
              <?php if(count($products) > 0){ for($i=0;$i<count($products);$i++){ ?>
              <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
              <tr class="<?php  echo $rowClass?>">
                <td class="center"><?php  echo ($i+1) ?></td>
                <td><?php if($products[$i]['picture'] != ""){ ?>
                  <img  style="width:100px;" class="card-img-top" alt="Image placeholder" src="<?php echo base_url()?>media/product/<?php echo $products[$i]['picture']; ?>" >
                  <?php }else{ ?>
                  <img alt="Image placeholder" src="<?php echo base_url()?>media/brand/no_image.png" width="100px">
                  <?php } ?></td>
				   <td><?php echo $products[$i]['name']; ?></td>
              
               
                <td><?php echo $products[$i]['brand_name']; ?></td>
                <td class="quantity"><?php echo $products[$i]['quantity']; ?></td>
                <td><?php echo $products[$i]['bag_size']; ?></td>
                <td><?php echo $products[$i]['default_price']; ?></td>
                <td><?php if($order[0]['is_active'] == 1) { ?>
                  <input type="text" size="4" name="price_per_unit" class="price_per_unit" value="<?php echo $products[$i]['price_per_unit']; ?>"  id="<?php echo $i; ?>"/>
                  <input type="button" name="" value="Add" onclick="updateprice('<?php echo $products[$i]['orderproduct_id']?>','<?php echo $i; ?>');" />
                  <input type="hidden" size="4" name="price_per_unit1" class="price_per_unit1 <?php echo $i; ?>" value="<?php echo $products[$i]['price_per_unit']; ?>" />
                  <?php }else{ ?>
                  <?php echo $products[$i]['price_per_unit']; ?>
                  <?php } ?>
                </td>
                <td><?php if($products[$i]['is_purchaser_verified'] ==1){ echo "Normal"; }else{ echo "New"; } ?></td>
                <td><?php echo $products[$i]['note']; ?></td>
                <td><?php echo $products[$i]['sku']; ?></td>
                <?php foreach($columnname as $namedata){?>
                <?php $name= $namedata['attribute_name'];?>
                <td><?php echo $products[$i][$name]; ?></td>
                <?php }?>
              </tr>
              <?php   } }?>
            </tbody>
          </table>
        </div>
        <?php  }else{ ?>
        <?php  echo "No Category found"; ?>
        <?php  } ?>
        <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
          <ul class="pagination">
            <?php  //echo $pager;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>
