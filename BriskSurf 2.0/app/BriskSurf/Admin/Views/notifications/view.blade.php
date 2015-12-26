@extends('admin::templates.full')

@section('header')

	{{ HTML::style('assets/css/admin/email.css') }}

@stop

@section('body')
	<a href="{{ URL::to('admin/campaigns/action', $notification->campaign_id) }}"><button>Return to Campaign</button></a> 
	<button id="save">Save</button>
	

	{{ Form::open(array('id' => 'saveform')) }}
		<div class="title">Name</div><input placeholder="Enter a name" type="text" value="{{ $notification->name }}" name="name">
		<br><br>
		<div class="title">Subject</div><input placeholder="Enter a subject" type="text" value="{{ $notification->subject }}" name="subject">
		<br><br>
		<div class="title">Message</div><input placeholder="Enter a message" type="text" value="{{ $notification->message }}" name="message">
		<br><br>
		<div class="title">Type</div>
		<select name="type">
			<option value="message" {{ $notification->type == 'message' ? 'selected' : '' }}>Message</option>
			<option value="link" {{ $notification->type == 'link' ? 'selected' : '' }}>Link</option>
		</select>
		<div id='link' style="{{ $notification->type != 'link' ? 'display: none' : '' }}">
			<br><br>
			<div class="title"></div>Adding a link: For example, linking to {{ URL::to('login') }}, type in {{ "{" }}{url::login}}
			<br><br>
			<div class="title">Link</div><input placeholder="Enter a link" type="text" value="{{ ($notification->type == 'link') ? $notification->type_data : '' }}" name="type_data_link">
		</div>
	{{ Form::close() }}
	<br><br><br><br>
@stop

@section('footer')

	<script>
		$("#save").click(function() {
			$("#saveform").submit();
		});

		$("select[name=type]").change(function() {
			init_link();
		});

		init_link();

		function init_link()
		{
			if($("select[name=type]").val() == "link") $("#link").show();
			else $("#link").hide();
		}
	</script>

@stop


