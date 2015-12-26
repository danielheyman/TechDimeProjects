@extends('templates.header')


@section('inner_header')

	{{ HTML::style('assets/css/in.surf_classic.css') }}

	<style type="text/css">
	#counter {
		padding: 14px 23px 14px 23px;
		display: none;
	}
	</style>

@stop

@section('inner_body')

	<iframe id="iframe" src="{{ $website }}" sandbox="allow-forms allow-scripts allow-popups allow-same-origin"></iframe>

	<div id="surfbar">
		<a href="{{ url('dash') }}" class="btn btn-lg btn-danger" id="home"><span class="fui-home"></span></a>
		<div id="info">Credits Today: {{ $credits_today }}<br>Credits Balance: {{ $credits }}<br>Views Today: {{ $views }}</div>

		{{ Form::open() }}<button class="btn btn-lg btn-success" id="counter">GO</button>{{ Form::close() }}
	</div>

@stop

@section('inner_footer')

	{{ HTML::script('assets/js/in.minigame.surf.js') }}

@stop