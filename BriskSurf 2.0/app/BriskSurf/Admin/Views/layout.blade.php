@extends('admin::templates.full')

@section('header')

	{{ HTML::style('assets/css/admin/layout.css') }}

@stop

@section('body')
	<a href="{{ URL::to('admin/emails/layouts') }}"><button>Return to Layouts</button></a> 
	<button id="save">Save</button>
	@if($layout != 'new') <button class="right" id="delete">Delete</button> @endif
	

	{{ Form::open(array('id' => 'saveform')) }}
		<div class="title">Name</div><input placeholder="Enter a name" type="text" value="{{ $layout == 'new' ? '' : $layout->name }}" name="name">
		<textarea name="data"></textarea>
	<br><br><br>
	<div id="editor" name="data">{{ ($layout == "new") ? '' : htmlentities($layout->data) }}</div>
	{{ Form::close() }}


	{{ Form::open(array('id' => 'deleteform', 'method' => 'delete')) }} {{ Form::close() }}
	<br><br><br><br>
@stop

@section('footer')

	{{ HTML::script('assets/js/admin/ace/src-min-noconflict/ace.js') }}
	<script type="text/javascript">
		var editor = ace.edit("editor");
		editor.setTheme("ace/theme/idle_fingers");
		editor.getSession().setMode("ace/mode/html");

		$("#save").click(function() {
			$("#saveform textarea").val(editor.getValue());
			$("#saveform").submit();
		});

		$("#delete").click(function() {
			var del = prompt("Enter the words 'Delete Me'");
			if (del != null && del == "Delete Me") {
			    	$("#deleteform").submit();
			}
		});
	</script>

@stop

