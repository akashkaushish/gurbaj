<div class="dashboard-main">
 <div class="container-fluid">
 <div class="row">
 <div class="col-md-12 title">
 <h3>Subscription Plans</h3>
 </div>
 </div>
 <div class="row">
 <div class="col-md-12">
 <ol class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">Plans</li>
</ol>
</div>
 </div>
 <div class="dashboard-top">
 <div class="row">
 <?php for($i=0;$i<count($plans);$i++){ ?>
  <div class="col-md-3">
   <div class="card-box btn-primary"><h3><?php echo $plans[$i]['plan_name']; ?></h3><p><?php echo "Rs. ".$plans[$i]['price']; ?></p></div>
  </div>
 <?php } ?>
  
 </div>
 </div>
 
 
 </div>
 
 
 
</div>