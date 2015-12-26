@extends('admin::templates.full')

@section('header')

	<style type="text/css">
	.section{
		width: 48%;
		text-align: center;
		line-height: 150px;
		background: red;
		display: inline-block;
		background: #eee;
		color: #333;
		border-radius: 5px;
		border-bottom: 2px solid #ddd;
	}

	.section:hover{
		background: #ddd;
	}
	</style>

@stop

@section('body')

	<p>Choose a campaign type:</p>
	<a href="{{ URL::to('admin/campaigns/segment') }}" class="section">List Triggered</a>
	<a href="{{ URL::to('admin/campaigns/action') }}" class="section">Action Triggered</a>

@stop