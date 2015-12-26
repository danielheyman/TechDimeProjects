@extends('admin::templates.full')

@section('header')

	{{ HTML::style('assets/css/admin/email.css') }}

@stop

@section('body')
	<a href="{{ URL::to('admin/campaigns/action', $campaign) }}"><button>Return to Campaign</button></a> 
	<a target="_blank" href="{{ URL::to('admin/email/preview/' . $email->id)  }}"><button id="preview">Preview</button> </a>
	<button id="save">Save</button>
	

	{{ Form::open(array('id' => 'saveform')) }}
		<div class="title">Name</div><input placeholder="Enter a name" type="text" value="{{ $email->name }}" name="name">
		<br><br>
		<div class="title">Type</div>
		<select name="type">
			@if($email->type == "transactional")
				<option value="transactional">Transactional</option>
			@else
				<option value="newsletter">Newsletter</option>
				<option value="admin_email">Admin Email</option>
			@endif
		</select>
		<br><br>
		<div class="title">Notification</div>
		<select name="notification">
			<option value="true" {{ $email->notification ? 'selected' : '' }}>True</option>
			<option value="false" {{ !$email->notification ? 'selected' : '' }}>False</option>
		</select>
		<br><br>
		<div class="title">Layout</div>
		<select name="layout">
			@foreach($layouts as $layout)
				<option value="{{ $layout->id }}" {{ $layout->id == $email->layout ? 'selected' : '' }}>{{ ucfirst($layout->name) }}</option>
			@endforeach
		</select>
		<br><br>
		<div class="title">From</div>
		<select name="from">
			<option value="support" {{ "support" == $email->from ? 'selected' : '' }}>Tech Dime Support &lt;support@techdime.com&gt;</option>
			<option value="news" {{ "news" == $email->from ? 'selected' : '' }}>Tech Dime News &lt;news@techdime.com&gt;</option>
			<option value="daniel" {{ "daniel" == $email->from ? 'selected' : '' }}>Daniel Heyman &lt;daniel@techdime.com&gt;</option>
			<option value="matt" {{ "matt" == $email->from ? 'selected' : '' }}>Matt Baker &lt;matt@techdime.com&gt;</option>
		</select>
		<br><br>
		<div class="title">Subject</div><input placeholder="Enter a subject" type="text" value="{{ $email->subject }}" name="subject">
		<br><br>
		Attributes: @foreach($attributes as $attribute) <div class="attribute">user.{{ $attribute }}</div> @endforeach
		@if($action_attributes) 
			<br><br>Action Attributes: @foreach($action_attributes as $attribute) <div class="attribute">action.{{ $attribute }}</div> @endforeach 
		@endif
		<br><br>Adding an attribute: Hello {{ "{" }}{user.first_name}},
		<br><br>Adding a link: For example, linking to {{ URL::to('login') }}, type in {{ "{" }}{url::login}},
		<br><br><br>
		<textarea style="display:none;" name="data">{{ $email->data }}</textarea>
	{{ Form::close() }}
	<br><br><br><br>
@stop

@section('footer')

	{{ HTML::script('//tinymce.cachefly.net/4.1/tinymce.min.js') }}
	<script>
		$("#save").click(function() {
			$("#saveform").submit();
		});

		tinymce.init({
			selector:'textarea', 
			menubar: false,
			plugins: [
		  	    	"advlist lists link image spellchecker wordcount code fullscreen textcolor colorpicker"
		  	],
		  	toolbar1: "undo redo | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink image | forecolor backcolor | spellchecker | fullscreen code",
		        	forced_root_block : ''
		});
		$("textarea").show();
	</script>

@stop


