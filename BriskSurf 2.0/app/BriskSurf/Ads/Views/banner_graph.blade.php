@extends('templates.header')

@section('inner_header')

	{{ HTML::style('assets/css/in.website_graph.css') }}

@stop


@section('inner_body')

	<center>
		<p>Views</p>
		<div id="chart" style="width: 100%;"></div>
	</center>

@stop


@section('inner_footer')

	<script type="text/javascript">

	var points = [
		@foreach($views as $day => $value)
			['{{ $day }}', {{ $value }}],
		@endforeach
	];

	</script>

	{{ HTML::script('https://www.google.com/jsapi') }}
	{{ HTML::script('assets/js/in.website_graph.js') }}

@stop