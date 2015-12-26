<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{{ Settings::get('main')->website_name }}</title>

		{{ HTML::style('assets/css/common.css') }}
		{{ HTML::style('assets/flat-ui-full/css/flat-ui.css') }}

		{{ HTML::style('assets/css/templates.full.css') }}
		{{ HTML::style('assets/common-files/css/icon-font.css') }}

		@yield('inner_header')
	</head>

	<body>
		@yield('inner_body')

		{{ HTML::script('assets/common-files/js/jquery-1.10.2.min.js') }}
		{{ HTML::script('assets/flat-ui-full/js/bootstrap.min.js') }}
		{{ HTML::script('assets/flat-ui-full/js/flatui-checkbox.js') }}
		{{ HTML::script('assets/common-files/js/jquery.scrollTo-1.4.3.1-min.js') }}
		{{ HTML::script('assets/common-files/js/modernizr.custom.js') }}
		{{ HTML::script('assets/common-files/js/page-transitions.js') }}
		{{ HTML::script('assets/common-files/js/easing.min.js') }}
		{{ HTML::script('assets/common-files/js/jquery.svg.js') }}
		{{ HTML::script('assets/common-files/js/jquery.svganim.js') }}
		{{ HTML::script('assets/common-files/js/jquery.parallax.min.js') }}
		{{ HTML::script('assets/common-files/js/startup-kit.js') }}

		<!--TOOLTIP-->
	    	<script>
    		    	$("[data-toggle=tooltip]").tooltip();
    		    	$(".nav-tabs a").on('click', function (e) {
			      	e.preventDefault();
			      	$(this).tab("show");
		    	});
	    	</script>
	    	<!--END-->

		{{ HTML::script('assets/js/secureForm/main.js') }}

		@yield('inner_footer')
	</body>
</html>