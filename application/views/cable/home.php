<!DOCTYPE html>
<html>
	<head>
		<!--header links-->
		<?php echo @$header_links;?>
		<!--header links-->
	</head>
	<body class="fixed-left">
		<!-- Begin page -->
		<div id="wrapper">
			<!-- Top Bar Start -->
			<?php echo @$topbar;?>
			<!-- Top Bar End -->
			<!-- Left Sidebar Start -->
			<?php echo @$left_menu?>
			<!-- Left Sidebar End -->
			<!-- container -->
			<div class="content-page">
				<!-- Start content -->
				<div class="content">
					<div class="container-fluid">
					  <!-- Breadcrumbs-->
					  <ol class="breadcrumb">
						<li class="breadcrumb-item">
						  <a href="#">Dashboard</a>
						</li>
						<li class="breadcrumb-item active">My Dashboard</li>
					  </ol>
					  <!-- Icon Cards-->
					  <div class="row">
						<div class="col-xl-3 col-sm-6 mb-3">
						  <div class="card text-white bg-primary o-hidden h-100">
							<div class="card-body">
							  <div class="card-body-icon">
								<i class="fa fa-credit-card" aria-hidden="true"></i>
							  </div>
							  <div class="mr-5">&#x20B9;<?php echo number_format(@$daily_collection['daily_total'],2);?> Today's Collection!</div>
							</div>
							<a class="card-footer text-white clearfix small z-1" href="<?php echo base_url('cable/reports/daily_collection');?>">
							  <span class="float-left">View Details</span>
							  <span class="float-right">
								<i class="fa fa-angle-right"></i>
							  </span>
							</a>
						  </div>
						</div>
						<div class="col-xl-3 col-sm-6 mb-3">
						  <div class="card text-white bg-warning o-hidden h-100">
							<div class="card-body">
							  <div class="card-body-icon">
								<i class="fa fa-credit-card" aria-hidden="true"></i>
							  </div>
							  <div class="mr-5">&#x20B9;<?php echo number_format(@$total_collection['total'],2);?> Total Collection!</div>
							</div>
							<a class="card-footer text-white clearfix small z-1" href="<?php echo base_url('cable/reports/daily_collection');?>">
							  <span class="float-left">View Details</span>
							  <span class="float-right">
								<i class="fa fa-angle-right"></i>
							  </span>
							</a>
						  </div>
						</div>
						<div class="col-xl-3 col-sm-6 mb-3">
						  <div class="card text-white bg-success o-hidden h-100">
							<div class="card-body">
							  <div class="card-body-icon">
								<i class="fa fa-users" aria-hidden="true"></i>
							  </div>
							  <div class="mr-5"><?php echo @$due['total_due']; ?> Total Due!</div>
							</div>
							<a class="all_customers card-footer text-white clearfix small z-1" href="javascript:;">
								<span class="float-left">View Details</span>
								<span class="float-right"><i class="fa fa-angle-right"></i></span>
							</a>
							<form method="post" id="all_customers" action="<?php echo base_url('cable/customers');?>">
								<input type="hidden" name="status" value="all">
							</form>
						  </div>
						</div>
						<div class="col-xl-3 col-sm-6 mb-3">
						  <div class="card text-white bg-danger o-hidden h-100">
							<div class="card-body">
							  <div class="card-body-icon">
								<i class="fa fa-users" aria-hidden="true"></i>
							  </div>
							  <div class="mr-5"><?php echo @$customers; ?> Total Customers!</div>
							</div>
							<a class="all_customers card-footer text-white clearfix small z-1" href="javascript:;">
								<span class="float-left">View Details</span>
								<span class="float-right"><i class="fa fa-angle-right"></i></span>
							</a>
							<form method="post" id="all_customers" action="<?php echo base_url('cable/customers');?>">
								<input type="hidden" name="status" value="all">
							</form>
						  </div>
						</div>
						<div class="col-xl-3 col-sm-6 mb-3">
						  <div class="card text-white bg-warning o-hidden h-100">
							<div class="card-body">
							  <div class="card-body-icon">
								<i class="fa fa-fw fa-shopping-cart"></i>
							  </div>
							  <div class="mr-5">123 New Orders!</div>
							</div>
							<a class="card-footer text-white clearfix small z-1" href="#">
							  <span class="float-left">View Details</span>
							  <span class="float-right">
								<i class="fa fa-angle-right"></i>
							  </span>
							</a>
						  </div>
						</div>
						
						<div class="col-xl-3 col-sm-6 mb-3">
						  <div class="card text-white bg-primary o-hidden h-100">
							<div class="card-body">
							  <div class="card-body-icon">
								<i class="fa fa-fw fa-support"></i>
							  </div>
							  <div class="mr-5">13 New Tickets!</div>
							</div>
							<a class="card-footer text-white clearfix small z-1" href="#">
							  <span class="float-left">View Details</span>
							  <span class="float-right">
								<i class="fa fa-angle-right"></i>
							  </span>
							</a>
						  </div>
						</div>
					  </div>
					  <!-- Area Chart Example-->
					  <div class="card mb-3">
						<div class="card-header">
						  <i class="fa fa-area-chart"></i> Daily Collection</div>
						<div class="card-body">
						  <canvas id="myAreaChart" width="100%" height="30"></canvas>
						</div>
						<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
					  </div>
					  <div class="row">
						<div class="col-lg-12">
						  <!-- Example Bar Chart Card-->
						  <div class="card mb-3">
							<div class="card-header">
							  <i class="fa fa-bar-chart"></i> Bar Chart Example</div>
							<div class="card-body">
							  <div class="row">
								<div class="col-sm-8 my-auto">
								  <canvas id="myBarChart" width="100" height="50"></canvas>
								</div>
								<div class="col-sm-4 text-center my-auto">
								  <div class="h4 mb-0 text-primary">$34,693</div>
								  <div class="small text-muted">YTD Revenue</div>
								  <hr>
								  <div class="h4 mb-0 text-warning">$18,474</div>
								  <div class="small text-muted">YTD Expenses</div>
								  <hr>
								  <div class="h4 mb-0 text-success">$16,219</div>
								  <div class="small text-muted">YTD Margin</div>
								</div>
							  </div>
							</div>
							<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
						  </div>
						 
						</div>
						<!--<div class="col-lg-4">
						  <div class="card mb-3">
							<div class="card-header">
							  <i class="fa fa-pie-chart"></i> Pie Chart Example</div>
							<div class="card-body">
							  <canvas id="myPieChart" width="100%" height="100"></canvas>
							</div>
							<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
						  </div>
						  
						</div>-->
					  </div>
					  <!-- Example DataTables Card-->
					  
					</div>
					
				</div>
			</div>
		</div> 
		<?php echo @$footer;?>
		<?php echo @$footer_scripts;?>
		<script src="cable_assets/js/chart_root.js"></script>
		<script>
			/*!
			 * Start Bootstrap - SB Admin v4.0.0-beta.2 (https://startbootstrap.com/template-overviews/sb-admin)
			 * Copyright 2013-2017 Start Bootstrap
			 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-sb-admin/blob/master/LICENSE)
			 */
			Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif', Chart.defaults.global.defaultFontColor = "#292b2c";
			var ctx = document.getElementById("myAreaChart"),
				myLineChart = new Chart(ctx, {
					type: "line",
					data: {
						labels: [
							<?php 
							foreach($daily_collection_graph as $row){
								echo '"'.$row['payment_date'].'",';
							}
							?>
						],
						datasets: [{
							label: "Total",
							lineTension: .3,
							backgroundColor: "rgba(2,117,216,0.2)",
							borderColor: "rgba(2,117,216,1)",
							pointRadius: 5,
							pointBackgroundColor: "rgba(2,117,216,1)",
							pointBorderColor: "rgba(255,255,255,0.8)",
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "rgba(2,117,216,1)",
							pointHitRadius: 20,
							pointBorderWidth: 2,
							data: [
							<?php 
							foreach($daily_collection_graph as $row){
								echo '"'.$row['daily_total'].'",';
							}
							?>
							]
						}]
					},
					options: {
						scales: {
							xAxes: [{
								time: {
									unit: "date"
								},
								gridLines: {
									display: !1
								},
								ticks: {
									maxTicksLimit: 7
								}
							}],
							yAxes: [{
								ticks: {
									min: 0,
									max: 4e4,
									maxTicksLimit: 5
								},
								gridLines: {
									color: "rgba(0, 0, 0, .125)"
								}
							}]
						},
						legend: {
							display: !1
						}
					}
				}),
				
				
				ctx = document.getElementById("myBarChart"),
				myLineChart = new Chart(ctx, {
					type: "bar",
					data: {
						labels: ["January", "February", "March", "April", "May", "June"],
						datasets: [{
							label: "Revenue",
							backgroundColor: "rgba(2,117,216,1)",
							borderColor: "rgba(2,117,216,1)",
							data: [4215, 5312, 6251, 7841, 9821, 14984]
						}]
					},
					options: {
						scales: {
							xAxes: [{
								time: {
									unit: "month"
								},
								gridLines: {
									display: !1
								},
								ticks: {
									maxTicksLimit: 6
								}
							}],
							yAxes: [{
								ticks: {
									min: 0,
									max: 15e3,
									maxTicksLimit: 5
								},
								gridLines: {
									display: !0
								}
							}]
						},
						legend: {
							display: !1
						}
					}
				}),
				ctx = document.getElementById("myPieChart"),
				myPieChart = new Chart(ctx, {
					type: "pie",
					data: {
						labels: ["Blue", "Red", "Yellow", "Green"],
						datasets: [{
							data: [12.21, 15.58, 11.25, 8.32],
							backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745"]
						}]
					}
				});
		</script>
		
	</body>
</html>