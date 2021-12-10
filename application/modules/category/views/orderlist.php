<div class="annual-sales brands-list">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
  <p class="notice" style="clear:both;">
    <?php  echo $notice;?>
  </p>
  <?php  endif;?>
  <div class="head">
    <h2 class="d-inline-block"> Order History</h2>
    </div>
  <div class="table-responsive">
    <?php  if($orders) : ?>
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
          <th scope="col"class="center">#</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Order Created By</th>
                <th scope="col">Order Cost</th>
                <th scope="col">Order Date</th>
                <th scope="col">Confirm Date</th>
                <th scope="col" >Shipped Date</th>
                <th scope="col" >Shipped Address</th>
                <th scope="col" >Shipped Method</th>
                <th scope="col" >Shipped Pin</th>
                <th scope="col" >Shipping Fee</th>
                <th scope="col" >Tracking Number</th>
                <th scope="col">Customer Phone</th>
                <th scope="col">Customer Message</th>
                <th scope="col">Status</th>
                <th scope="col">Details</th>
        </tr>
      </thead>
      <tbody>
          <?php  $i = 1; foreach ($orders as $orderslist): ?>
              <?php 	$name=$this->db->get_where('users', array('id'=>$orderslist['customer_id']))->row()->name.' '.$this->db->get_where('users', array('id'=>$orderslist['customer_id']))->row()->lname;?>
              <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
              <tr class="<?php  echo $rowClass?>">
                <td class="center"><?php  echo ($i + $start) ?></td>
                <td><?php  echo $name;?></td>
                <td><?php echo $this->db->get_where('users', array('id'=>$orderslist['created_by_user_id']))->row()->name.' '.$this->db->get_where('users', array('id'=>$orderslist['created_by_user_id']))->row()->lname; ?></td>
                <td><?php  echo $orderslist['total_cost'];?></td>
                <td><?php  echo date('Y-m-d',strtotime($orderslist['date_created']));?></td>
                <td><?php   if($orderslist['sales_confirm_date']=='0000-00-00'){echo "--";}else{echo date('Y-m-d',strtotime($orderslist['sales_confirm_date']));}?></td>
                <td><?php  if($orderslist['shipping_date']=='0000-00-00'){echo "--";}else{echo date('Y-m-d',strtotime($orderslist['shipping_date']));}?></td>
                <td><?php  if(isset($orderslist['shipping_method']) && ($orderslist['shipping_method'] !='')){echo $orderslist['shipping_address'];}else{echo "--";}?></td>
                <td><?php  echo $orderslist['shipping_method'];?></td>
                <td><?php  echo $orderslist['shipping_pin'];?></td>
                <td><?php  echo $orderslist['shipping_fee'];?></td>
                <td><?php  echo $orderslist['tracking_number'];?></td>
                <td><?php  echo $orderslist['shipping_phone'];?></td>
                <td><?php  echo $orderslist['speacial_message'];?></td>
                <td><?php  echo $orderslist['is_active'];?></td>
                <td><a href="<?php  echo site_url($module.'/admin/orderdetail/'.$orderslist['id'])?>">
                  <?php  echo "View"; ?>
                  </a></td>
              </tr>
        <?php  $i++; endforeach;?>
      </tbody>
    </table>
    <?php  else: ?>
    <table class="table table-bordered table-striped"  id="sampleTable">
      <thead>
        <tr>
           <th scope="col"class="center">#</th>

              <th scope="col">Customer Name</th>
              <th scope="col">Order Created By</th>
              <th scope="col">Order Cost</th>
              <th scope="col">Status</th>
              <th scope="col">Order Date</th>
              <th scope="col">Confirm Date</th>
              <th scope="col" >Shipped Date</th>
              <th scope="col">Customer Phone</th>
              <th scope="col">Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">No Order Found</td>
        </tr>
      </tbody>
    </table>
    <?php  endif ; ?>
  </div>
</div>
<?php /*?><main class="app-content">
<div class="app-title">
  <div>
    <h1><i class="fa fa-first-order"></i> Order History</h1>
  </div>
  <div></div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Order History</li>
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
        <?php  if($orders) : ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="sampleTable">
            <thead>
              <tr>
                <th scope="col"class="center">#</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Order Created By</th>
                <th scope="col">Order Cost</th>
                <th scope="col">Order Date</th>
                <th scope="col">Confirm Date</th>
                <th scope="col" >Shipped Date</th>
                <th scope="col" >Shipped Address</th>
                <th scope="col" >Shipped Method</th>
                <th scope="col" >Shipped Pin</th>
                <th scope="col" >Shipping Fee</th>
                <th scope="col" >Tracking Number</th>
                <th scope="col">Customer Phone</th>
                <th scope="col">Customer Message</th>
                <th scope="col">Status</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              <?php  $i = 1; foreach ($orders as $orderslist): ?>
              <?php 	$name=$this->db->get_where('users', array('id'=>$orderslist['customer_id']))->row()->name.' '.$this->db->get_where('users', array('id'=>$orderslist['customer_id']))->row()->lname;?>
              <?php  if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
              <tr class="<?php  echo $rowClass?>">
                <td class="center"><?php  echo ($i + $start) ?></td>
                <td><?php  echo $name;?></td>
                <td><?php echo $this->db->get_where('users', array('id'=>$orderslist['created_by_user_id']))->row()->name.' '.$this->db->get_where('users', array('id'=>$orderslist['created_by_user_id']))->row()->lname; ?></td>
                <td><?php  echo $orderslist['total_cost'];?></td>
                <td><?php  echo date('Y-m-d',strtotime($orderslist['date_created']));?></td>
                <td><?php   if($orderslist['sales_confirm_date']=='0000-00-00'){echo "--";}else{echo date('Y-m-d',strtotime($orderslist['sales_confirm_date']));}?></td>
                <td><?php  if($orderslist['shipping_date']=='0000-00-00'){echo "--";}else{echo date('Y-m-d',strtotime($orderslist['shipping_date']));}?></td>
                <td><?php  if(isset($orderslist['shipping_method']) && ($orderslist['shipping_method'] !='')){echo $orderslist['shipping_address'];}else{echo "--";}?></td>
                <td><?php  echo $orderslist['shipping_method'];?></td>
                <td><?php  echo $orderslist['shipping_pin'];?></td>
                <td><?php  echo $orderslist['shipping_fee'];?></td>
                <td><?php  echo $orderslist['tracking_number'];?></td>
                <td><?php  echo $orderslist['shipping_phone'];?></td>
                <td><?php  echo $orderslist['speacial_message'];?></td>
                <td><?php  echo $orderslist['is_active'];?></td>
                <td><a href="<?php  echo site_url($module.'/admin/orderdetail/'.$orderslist['id'])?>">
                  <?php  echo "View"; ?>
                  </a></td>
              </tr>
              <?php  $i++; endforeach;?>
            </tbody>
          </table>
        </div>
        <?php  else: ?>
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th scope="col"class="center">#</th>

              <th scope="col">Customer Name</th>
              <th scope="col">Order Created By</th>
              <th scope="col">Order Cost</th>
              <th scope="col">Status</th>
              <th scope="col">Order Date</th>
              <th scope="col">Confirm Date</th>
              <th scope="col" >Shipped Date</th>
              <th scope="col">Customer Phone</th>
              <th scope="col">Details</th>
            </tr>
          </thead>
          <tbody>
            <tr class="">
              <td colspan="7">No Order Found</td>
            </tr>
          </tbody>
        </table>
        <?php  endif ; ?>
        <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
          <ul class="pagination">
          
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>
