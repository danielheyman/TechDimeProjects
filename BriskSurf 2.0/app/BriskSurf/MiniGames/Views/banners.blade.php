@extends('templates.header')

@section('inner_header')

	{{ HTML::style('assets/css/in.minigame.banners.css') }}

@stop

@section('inner_body')

	<section class="header-8-sub bg-midnight-blue">
		<div class="background">&nbsp;</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<h3>Banner Fight Mini Game</h3>
					<div class="lead">Choose your {{ floor(count($banners) / 2) }} favorite banners <button class='btn btn-danger' id="counter">{{ floor(count($banners) / 2) }} left</button> {{ Form::open() }}<input name='banner_ids' type='hidden'/><button class='btn btn-danger' id="continue">continue</button>{{ Form::close() }}</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="row banners">
		@foreach($banners as $banner)
			<div class="col-sm-6">
				<div id="{{ $banner['_id'] }}" class="banner" link='http://www.gravatar.com/avatar/{{ md5($banner['user']['email']) }}?s=60'>
					<img src='{{ $banner['banner'] }}'/>
				</div>
			</div>
		@endforeach
	</div>

	<div id="overlay">
		<div class="col-sm-2">
			<img src="" class="image">
		</div>
		<div class="col-sm-4">
			<a href="javascript:void(0);" class="select">Pick Me</a>
		</div>
		<div class="col-sm-6">
			<a target="_blank" href="{{ $banner['url'] }}" class="visit">Visit Website</a>
		</div>
	</div>

@stop

@section('inner_footer')

	<script type="text/javascript">
		var counter = {{ floor(count($banners) / 2) }};
	</script>
	
	{{ HTML::script('assets/js/in.minigame.banners.js') }}

@stop