@extends('templates.header')


@section('inner_header')

	{{ HTML::style('assets/css/in.surf.css') }}

	<style type="text/css">
	#counter{
		padding: 14px 23px 14px 23px;
		display: none;
	}
	</style>

@stop

@section('inner_body')

	<div id="surf">
		<iframe id="iframe" src="{{ $website }}" sandbox="allow-forms allow-scripts allow-popups allow-same-origin"></iframe>
		<a href="{{ url('dash') }}" class="btn btn-lg btn-danger" id="home"><span class="fui-home"></span></a>
		<button class="btn btn-lg btn-info" id="views">{{ $views }} Views</button>
		<button class="btn btn-sm btn-info" id="credits">Credits Today: {{ $credits_today }}<br>Credits Balance: {{ $credits }}</button>

		{{ Form::open() }}<button class="btn btn-lg btn-success" id="counter">GO</button>{{ Form::close() }}
	</div>
	
	{{ $errors->first('global', '<div class="error btn btn-sm btn-danger">:message</div>') }}

@stop

@section('inner_footer')

	{{ HTML::script('assets/js/in.minigame.surf.js') }}

@stop