@extends('admin::templates.full')

@section('header')

	<style type="text/css">
	.title{
		width: 150px;
		text-align: right;
		padding-right: 10px;
		display: inline-block;
		color: #888;
	}
	.section{
		border-top: 1px solid #ddd;
		margin-top: 40px;
		padding-top: 30px;
	}
	.group{
		margin-bottom: 20px;
	}

	iframe{
		width:100%;
		height: 200px;
		border: 0;
	}
	</style>

@stop


@section('body')

	@if($type == 'draft')
		<a href="{{ URL::to('admin/emails/drafts') }}"><button>Return to Layouts</button></a> 
		<button id="send">Send</button>
		<button class="right" id="delete">Delete</button>
	@elseif($type == 'log')
		<a href="{{ URL::to('admin/emails/logs') }}"><button>Return to Logs</button></a> 
	@else($type == 'log')
		<a href="{{ URL::to('admin/email/' . $email_id) }}"><button>Return to Email</button></a> 
	@endif

	<div class="section">
		<div class="group">
			<div class="title">{{ $type == "draft" ? 'Created' : 'Sent' }} On</div>{{ $date }}
		</div>
		<div class="group">
			<div class="title">From</div>{{ $from_name}} &lt;{{ $from }}&gt;
		</div>
		<div class="group">
			<div class="title">To</div><a href="{{ URL::to('admin/users/' . $user) }}">{{ $user_name }}</a>
		</div>
		<div class="group">
			<div class="title">Subject</div><a href="{{ URL::to('admin/email/' . $email_id ) }}">{{ $subject }}</a>
		</div>
	</div>
	<div class="section">
		<iframe srcdoc="{{ $data }}"></iframe>
	</div>

	@if($type == 'draft')
		{{ Form::open(array('id' => 'sendform', 'method' => 'post')) }} {{ Form::close() }}
		{{ Form::open(array('id' => 'deleteform', 'method' => 'delete')) }} {{ Form::close() }}
	@endif
	<br><br><br><br>
@stop

@section('footer')

	<script type="text/javascript">
		$("#delete").click(function() {
			var del = prompt("Enter the words 'Delete'");
			if (del != null && del == "Delete") {
			    	$("#deleteform").submit();
			}
		});
		$("#send").click(function() {
			var del = prompt("Enter the words 'Send'");
			if (del != null && del == "Send") {
			    	$("#sendform").submit();
			}
		});
	</script>

@stop

