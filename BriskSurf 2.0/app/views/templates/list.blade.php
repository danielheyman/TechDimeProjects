@extends('templates.full')

@section('header')

	<style>
		.content-33 ul{
			margin-top: 15px;
		}

		.text{
			font-size:14px;
			margin-bottom:15px;
		}

		.content-33{
			padding-top:50px;
		}
	</style>

@stop

@section('body')

    <section class="content-33">
        	<div class="container">
        		@foreach($list as $key => $value)
	            	<p class="lead">{{ $key }}</p>
	            	<div class="text">{{ $value }}</div>
            	@endforeach
        	</div>
    </section>
@stop