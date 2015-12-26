<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{{ Settings::get('main')->website_name }}</title>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />

		{{ HTML::style('assets/css/admin/jquery.datetimepicker.css') }}
		{{ HTML::style('assets/css/admin/templates.full.css') }}

		@yield('header')
	</head>

	<body>
		<div id="menu">
			<div class="inner">
				<a class="brand" href="{{ url('/') }}">{{ Settings::get('main')->website_name }}</a>
				<div class="right">
					@if(\Cookie::get('admin'))
					<a href="{{ url('admin/' )}}">Main</a>
					<a href="{{ url('admin/campaigns') }}">Campaigns</a>
					<a href="{{ url('admin/lists') }}">Lists</a>
					<a href="{{ url('admin/emails') }}">Emails{{ $draft_count ? " ( {$draft_count} )" : "" }}</a>
					<a href="{{ url('admin/broadcast') }}">Broadcast</a>
					<a href="{{ url('admin/users') }}">Users</a>
					<a href="{{ url('admin/packages') }}">Packages</a>
					<a href="{{ url('admin/settings') }}">Settings</a>
					@endif
				</div>
			</div>
		</div>
		
		<div id="container">
			@yield('body')
		</div>
		
		 <div id="dtBox"></div>

		{{ HTML::script('assets/js/admin/jquery-latest.min.js') }}
		{{ HTML::script('assets/js/admin/jquery.autosize.input.js') }}
		{{ HTML::script('https://www.google.com/jsapi') }}
		{{ HTML::script('assets/js/admin/jquery.datetimepicker.js') }}

		{{ HTML::script('assets/js/admin/templates.full.js') }}

		@yield('footer')
	</body>
</html>