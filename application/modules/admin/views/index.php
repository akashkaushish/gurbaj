<?php 
		
		  /*$date=array();
		  $total=array();
		  $str='';
		  foreach($user as $userdata){
		
		   $date_data=$userdata['data'];
		
		 
		   $total=$userdata['totaldata'];
		   if($str==''){
		   $str.="[$total]" ;
		   }else{
		   $str.=",[$total]" ;
		   }
		} 
	 $date= $this->user->get_leastyear();
	 $datedata=explode('-',$date);	
	*/

		?>

<div class="dashboard-main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 title">
        <h3>Dashboard</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="dashboard-top">
      <div class="row">
        <div class="col-md-3">
          <div class="card-box btn-primary">
            <h3><?php echo $this->user->totalusers(); ?></h3>
            <p>Users</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-box btn-success">
           <a href="<?php echo site_url('member/admin/reports'); ?>"><h3>$<?php echo $totalinvested; ?></h3>
            <p>Total Invested</p></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-box btn-info">
            <h3>$<?php echo $totalwithdrawn; ?></h3>
            <p>Total Withdrawn</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-box btn-warning">
            <h3><?php echo $totalplan; ?></h3>
            <p>Total Plans</p>
          </div>
        </div>
		
		
      </div>
    </div>
    <!--div class="map">
      <div class="row" style="clear: both; margin-top: 10px;">
        <div class="col-md-6">
          <div class="widget-container fluid-height">
            <div class="heading"> <i class="fa fa-bar-chart-o"></i>User Sign Up </div>
            <div class="widget-content padded text-center">
              <div class="graph-container">
                <div class="caption"></div>
                <div class="graph" id="hero-bar2"></div>
              </div>
            </div>
          </div>
        </div>
		
		
		<div class="col-md-6">
          <div class="widget-container fluid-height">
            <div class="heading"> <i class="fa fa-bar-chart-o"></i>User Packages Purchase </div>
            <div class="widget-content padded text-center">
              <div class="graph-container">
                <div class="caption"></div>
                <div class="graph" id="packages"></div>
              </div>
            </div>
          </div>
        </div>
		
		
      </div-->
  </div>
</div>
</div>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script>
// Build the chart
Highcharts.chart('packages', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'User Packages Purchase '
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Plans',
        colorByPoint: true,
        data: [{
            name: 'Normal',
            y: <?php echo $this->user->userplandata(1);?>,
            sliced: true,
            selected: true
        }, {
            name: 'Super',
            y: <?php echo $this->user->userplandata(2);?>
        }, {
            name: 'Deluxe',
            y: <?php echo $this->user->userplandata(3);?>
        }]
    }]
});

//
Highcharts.chart('hero-bar2', {

    title: {
        text: 'User Sign Up'
    },

   
    yAxis: {
        title: {
            text: 'Number of User'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: <?php echo $datedata[0];?>
        }
    },

    series: [{
        name: 'User Count',
        data: [<?php echo $str;?>]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});

</script>
<style>
.highcharts-credits { display:none;}
</style>
