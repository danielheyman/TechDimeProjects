@extends('templates.header')


@section('inner_header')

	{{ HTML::style('assets/css/in.surf_classic.css') }}

	<style type="text/css">

	#counter {
		background-image: url(http://www.gravatar.com/avatar/{{ $email }}?s=60);
		background-size: contain;
		background-repeat: no-repeat;
	}
	</style>

@stop

@section('inner_body')

	<iframe id="iframe" src="{{ $website }}" sandbox="allow-forms allow-scripts allow-popups"></iframe>

	<div id="surfbar">
		<a href="{{ url('dash') }}" class="btn btn-lg btn-danger" id="home"><span class="fui-home"></span></a>
		<div id="info">Credits Today: {{ $credits_today }}<br>Credits Balance: {{ $credits }}<br>Views Today: {{ $views }}</div>

		<button class="btn btn-lg btn-info" id="counter">{{ $timer }}</button>

		<div id="rating">
			<span class="fui-star-2"></span>
			<span class="fui-star-2"></span>
			<span class="fui-star-2"></span>
		</div>

		
	         	<a id="banner" target="_blank" href="{{ $banner_url }}">
	         		<img src="{{ $banner_image }}"/>
	         		<div class="info">
	         			Brought to you by <img src='http://www.gravatar.com/avatar/{{ $banner_email }}?s=60'/>
	         		</div>
	         	</a>
	</div>
	
	{{ $errors->first('global', '<div class="error btn btn-sm btn-danger">:message</div>') }}

	{{ Form::open(array('id' => 'form')) }}
		<button></button>
		{{ Form::hidden('hash', $hash) }}
		{{ Form::hidden('id', $id) }}
		{{ Form::hidden('banner_id', $banner_id) }}
		{{ ($verify_human) ? SecureForm::create() : '' }}
	{{ Form::close() }}

@stop

@section('inner_footer')

	<script type="text/javascript">
	var type = 'classic';
	</script>
	{{ HTML::script('assets/js/animate-colors.js') }}
	{{ ($verify_human) ? HTML::script('packages/module/secureForm/assets/js/main.js') : '' }}
	{{ HTML::script('//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51f28e7a17cad498') }}
	{{ HTML::script('assets/js/in.surf.js') }}

@stop