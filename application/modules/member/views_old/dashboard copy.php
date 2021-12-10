

<div class="main-content">
<div class="dashboard-main">
  <div class="container-fluid">
  <?php  if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
            <p class="notice" style="clear:both;">
              <?php  echo $notice;?>
            </p>
            <?php  endif;?>
    <div class="row">
      <div class="col-md-12 title">
        <h3>Welcome <?php echo $userdetail['fname']." ".$userdetail['lname']; ?></h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div> <?php //echo $user_detail['my_ref_code'];?>
    <div class="row">
      <div class="col-md-12">
        <ol class="breadcrumb invite-link">
        <input type="hidden" id="myInput" value="<?php echo site_url("member/signup/".$user_detail['my_ref_code']);?>"/>
          <li class="active">Invite a Friend: <a href="#"><?php echo site_url("member/signup/".$user_detail['my_ref_code']);?></a> <button onclick="setClipboard('<?php $my_ref_code=$user_detail['my_ref_code']; echo site_url('member/signup/'.$my_ref_code);?>')">Copy Link</button></li>
          
        </ol>
      </div>
    </div>
    <div class="dashboard-top">
      <div class="row">
        <div class="col-md-3">
          <div class="card-box btn-primary">
		    <div class="row">
			<div class="col-md-8">
            <h3>$ <?php echo round($totalinvested, 2);  ?></h3>
            <p>Total Invested</p>
			</div>
			<div class="col-md-4">
			<i class="fa fa-line-chart" style="margin-top: 45px;font-size: 24px;"></i></div>
			</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-box btn-success">
		   <div class="row">
			<div class="col-md-8">
            <h3>$ <?php echo round($totalwallet, 2);  ?></h3>
            <p>Total Wallet</p>
			</div>
			<div class="col-md-4">
			<i class="fa fa-line-chart" style="margin-top: 45px;font-size: 24px;"></i></div>
			</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-box btn-info">
		   <div class="row">
			<div class="col-md-8">
            <h3>$ <?php echo round($totalwithdrawn, 2); ?></h3>
            <p>Total Withdrawn</p>
			</div>
			<div class="col-md-4">
			<i class="fa fa-line-chart" style="margin-top: 45px;font-size: 24px;"></i></div>
			</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-box btn-warning">
		   <div class="row">
			<div class="col-md-8">
            <h3><a href="<?php echo site_url('member/mytransactions') ?>">$ <?php  echo round($payout, 2);  ?> | $ <?php  echo round($commission, 2);  ?></a></h3>
            <p>Total Payout | <span>Total Commission</span></p>
			</div>
			<div class="col-md-4">
			<i class="fa fa-line-chart" style="margin-top: 45px;font-size: 24px;"></i></div>
			</div>
          </div>
        </div>
      </div>
    </div>
  

        <h3>My Plans</h3>

<div class="data-table">
 <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Plan Name</th>
            <th scope="col">Amout</th>
            <th scope="col">Purchased Date</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Status</th>
            <th scope="col">Open/Close</th>
            <!--th scope="col">Action</th-->
          </tr>
        </thead>
        <tbody>
          <?php for($i=0;$i<count($myplans); $i++){ ?>
          <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $myplans[$i]['plan_name']; ?></td>
            <td><?php echo $myplans[$i]['payment_amount']; ?></td>
            <td><?php echo $myplans[$i]['payment_date']; ?></td>
            <td><?php echo $myplans[$i]['plan_activation_date']; ?></td>
            <td><?php echo $myplans[$i]['plan_end_date']; ?></td>
            <td><?php if($myplans[$i]['is_confirmed'] == 1){ echo "Active"; }else if($myplans[$i]['is_confirmed'] == 2){ echo "Completed"; }else{ echo "Waiting for Approval"; } ?></td>
            <td><?php if($myplans[$i]['is_close'] == 1){ echo "Closed"; }else{ echo "Open"; } ?></td>
            <!--td>
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option selected>Choose...</option>
                <option value="1">Red</option>
                <option value="2">White</option>
              </select>
            </td-->
        
            <!--td> 
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option selected>Choose...</option>
                <option value="1">View Details</option>
            </select>
            </td-->
            </tr>			
          <?php } ?>
		  <tr>
		  <td>1</td>
		  <td>Bronze</td>
		  <td>$50</td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  </tr>
		  <tr>
		  <td>2</td>
		  <td>Silver</td>
		  <td>$100</td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  </tr>
		  <tr>
		  <td>3</td>
		  <td>Gold</td>
		  <td>$250</td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  </tr>
		  <tr>
		  <td>4</td>
		  <td>Platinum</td>
		  <td>$500</td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  </tr>
        </tbody>
      </table>
    </div>
 </div>
 </div>
 </div>
 </div>
 
 
</div>