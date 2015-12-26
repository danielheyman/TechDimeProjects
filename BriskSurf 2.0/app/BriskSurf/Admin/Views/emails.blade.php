@extends('admin::templates.full')

@section('header')

	<style type="text/css">
	.section{
		width: 33%;
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

	<a href="{{ URL::to('admin/emails/drafts') }}" class="section">Drafts{{ $draft_count ? " ( {$draft_count} )" : "" }}</a>
	<a href="{{ URL::to('admin/emails/logs') }}" class="section">Logs</a>
	<a href="{{ URL::to('admin/emails/layouts') }}" class="section">Layouts</a>

@stop