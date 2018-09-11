<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="zh-CN" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="zh-CN" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="zh-CN" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="zh-CN" class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Welcome to the wonderful world</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />


	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<!-- Animate.css -->
	<link rel="stylesheet" href="{{ asset('vpn/css/animate.css') }}">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="{{ asset('vpn/css/icomoon.css') }}">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="{{ asset('vpn/css/bootstrap.css') }}">

	<link rel="stylesheet" href="{{ asset('vpn/css/style.css') }}">


	<!-- Modernizr JS -->
	<script src="{{ asset('vpn/js/modernizr-2.6.2.min.js') }}"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="{{ asset('vpn/js/respond.min.js')}}"></script>
	<![endif]-->

	</head>
	<body>

	<div id="fh5co-page">
		<header>
			<div class="container">
				<div class="fh5co-navbar-brand">
					<a class="fh5co-logo" href="https://jiacyer.com">Jiacyer.com</a>
				</div>
			</div>
		</header>
		<div id="fh5co-intro-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8 animate-box">
						<h2 class="intro-heading">You can connect with the world Through this node.</h2>
						<h>Located in San Jose, USA</h>
						<p><span>Created with <i class="icon-heart3"></i> by Jiacy at <a href="https://jiacyer.com">Jiacyer.com</a></span></p>
						<p><span>Manage your account <a href="{{ route('loginUrl') }}">here</a></span></p>
					</div>
				</div>
			</div>
		</div>

		<!-- End: fh5co-services-section -->
		<footer>
			<div id="footer" class="fh5co-border-line">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							@include('vpn.public_view.footer')
						</div>
						<div class="col-md-6 social-text-align">
							<p class="fh5co-social-icons">
							</p>
						</div>
					</div>
				</div>
			</div>
		</footer>

	</div>

	<!-- jQuery -->
	<script src="{{ asset('vpn/js/jquery.min.js') }}"></script>
	<!-- jQuery Easing -->
	<script src="{{ asset('vpn/js/jquery.easing.1.3.js') }}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('vpn/js/bootstrap.min.js') }}"></script>
	<!-- Waypoints -->
	<script src="{{ asset('vpn/js/jquery.waypoints.min.js') }}"></script>
	<!-- Portfolio Filter Mixitup -->
	<script type="text/javascript" src="{{ asset('vpn/js/jquery.mixitup.min.js') }}"></script>

	<!-- Main JS (Do not remove) -->
	<script src="{{ asset('vpn/js/main.js') }}"></script>

	<script type="text/javascript">
	$(function () {

		var filterList = {

			init: function () {

				// MixItUp plugin
				// http://mixitup.io
				$('#portfoliolist').mixItUp({
  				selectors: {
    			  target: '.portfolio',
    			  filter: '.filter'
    		  },
    		  load: {
      		  filter: '.all'
      		}
				});

			}

		};

		// Run the show!
		filterList.init();



	});
	</script>

	</body>
</html>
