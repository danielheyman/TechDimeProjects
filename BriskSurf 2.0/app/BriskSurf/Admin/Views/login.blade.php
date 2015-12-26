@extends('admin::templates.full')

@section('header')
	{{ HTML::style('assets/css/admin/login.css') }}
@stop

@section('body')

	{{ Form::open() }}
		<h2>Login</h2>
		<div class="box">
			Password:<br>
			<input type="password" name="password">
		</div>
		<button class="login">Login</button>
	{{ Form::close() }}
@stop