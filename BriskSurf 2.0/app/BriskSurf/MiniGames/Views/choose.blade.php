@extends('templates.header')

@section('inner_header')

	<style type="text/css">
	.header-23-sub{
		position: fixed;
		height: 100%;
	}
	</style>

@stop

@section('inner_body')

	<section class="header-23-sub bg-midnight-blue">
		<div class="background">&nbsp;</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h3>{{ $info[1] }}</h3>
					<p class="lead">{{ $info[2] }}</p>
					<br><br>
					<div class="hero-unit">
						<strong>It's Game Time</strong>
						<a class="btn-play" href="{{ $info[0] }}">Play</a>
						<span>Get ready, set, hit play</span>
					</div>
				</div>
			</div>
		</div>
	</section>

@stop

@section('inner_footer')

	<script type="text/javascript">
		$(".header-23-sub").css("padding-top", (($(window).outerHeight() - $(".header-23-sub .row").outerHeight()) / 2));
	</script>

@stop