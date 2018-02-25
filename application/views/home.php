<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo base_url();?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">
		<link rel="shortcut icon" href="assets/images/favicon_1.png">
		<title>Admin Login</title>
		<link rel="shortcut icon" href="assets/images/favicon_1.png">
		<link rel="apple-touch-icon" sizes="57x57" href="image1/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="image1/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="image1/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="image1/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="image1/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="image1/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="image1/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="image1/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="image1/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="image1/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="image1/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="image1/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="image1/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="assets/css/core.css" rel="stylesheet" type="text/css">
		<link href="assets/css/icons.css" rel="stylesheet" type="text/css">
		<link href="assets/css/components.css" rel="stylesheet" type="text/css">
		<link href="assets/css/pages.css" rel="stylesheet" type="text/css">
		<link href="assets/css/menu.css" rel="stylesheet" type="text/css">
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
		<style>
			.alert-error{
				
			}
		</style>
		<script src="assets/js/modernizr.min.js"></script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','../../www.google-analytics.com/analytics.js','ga');
			
			ga('create', 'UA-65046120-1', 'auto');
			ga('send', 'pageview');
			
		</script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="wrapper-page">
			<div class="panel panel-color panel-primary panel-pages">
				<div class="panel-heading bg-img">
					<div class="bg-overlay"></div>
					<h3 class="text-center m-t-10 text-white"><img src="image1/logo.png" /></h3>
				</div>
				<div class="panel-body">
					<?php echo $this->utilitylib->showMsg();?>
					<form class="form-horizontal m-t-20" action="" method="post">
						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control input-lg" name="email" type="text" required placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control input-lg" name="password" type="password" required placeholder="Password">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12">
								<label class="radio-inline" for="cable">
									<input id="cable" name="visit_type" type="radio" required value="1">Cable
								</label>
								<label class="radio-inline" for="internet">
									<input id="internet" name="visit_type" type="radio" required value="2">Internet
								</label>
								
							</div>
						</div>
						
						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			var resizefunc = [];
		</script>
		<!-- Main  -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/detect.js"></script>
		<script src="assets/js/fastclick.js"></script>
		<script src="assets/js/jquery.slimscroll.js"></script>
		<script src="assets/js/jquery.blockUI.js"></script>
		<script src="assets/js/waves.js"></script>
		<script src="assets/js/wow.min.js"></script>
		<script src="assets/js/jquery.nicescroll.js"></script>
		<script src="assets/js/jquery.scrollTo.min.js"></script>
		<script src="assets/js/jquery.app.js"></script>
	</body>
	
</html>