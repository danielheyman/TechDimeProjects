@extends('templates.header')

@section('inner_header')

	{{ HTML::style('assets/css/in.website_graph.css') }}

@stop


@section('inner_body')

	<center>
		<p>Views</p>
		<div id="chart" style="width: 100%;"></div>
		<p>Rating ( out of 3 stars )</p>
		<p>Your average rating: <span class="fui-star-2 {{ ($average_rating > 0) ? 'yellow' : '' }}"></span> <span class="fui-star-2 {{ ($average_rating > 1.5) ? 'yellow' : '' }}"></span> <span class="fui-star-2 {{ ($average_rating > 2.5) ? 'yellow' : '' }}"></span> {{ number_format($average_rating, 2) }}</p>
		<div id="chart2" style="width: 100%;"></div>
	</center>

@stop


@section('inner_footer')

	<script type="text/javascript">

	var points = [
		@foreach($views as $day => $value)
			['{{ $day }}', {{ $value }}],
		@endforeach
	];

	var points2 = [
		@foreach($ratings as $day => $value)
			['{{ $day }}', {{ $value }}],
		@endforeach
	];

	</script>

	{{ HTML::script('https://www.google.com/jsapi') }}
	{{ HTML::script('assets/js/in.website_graph.js') }}

@stop