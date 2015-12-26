@extends('admin::templates.full')

@section('body')

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Recipient</th>
	                		<th>Email</th>
	                		<th>Date</th>
	                		<th></th>
	                		<th></th>
	              	</tr>
            	</thead>
		<tbody>
			@foreach($drafts as $draft)
				<tr>
					<td class="auto"><a href="{{ url('admin/users/' . $draft->user_id) }}">{{ $draft->user_name }}</a></td>
					<td><a href="{{ url('admin/emails/draft/' . $draft->id) }}">{{ $draft->subject }}</a></td>
					<td>{{ $draft->created_at->diffForHumans() }}</td>
					<td><a class="delete" value="{{ $draft->id }}" href="javascript:void(0)">Delete</a></td>
					<td><a class="send" value="{{ $draft->id }}" href="javascript:void(0)">Send</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

	@foreach($drafts as $draft)
		{{ Form::open(array('id' => 'sendform-' . $draft->id, 'method' => 'post', 'url' => 'admin/emails/draft/' . $draft->id)) }} {{ Form::close() }}
		{{ Form::open(array('id' => 'deleteform-' . $draft->id, 'method' => 'delete', 'url' => 'admin/emails/draft/' . $draft->id)) }} {{ Form::close() }}
	@endforeach

@stop

@section('footer')

	<script type="text/javascript">
		$(".delete").click(function() {
			var del = prompt("Enter the words 'Delete'");
			if (del != null && del == "Delete") {
			    	$("#deleteform-" + $(this).attr("value")).submit();
			}
		});
		$(".send").click(function() {
			var del = prompt("Enter the words 'Send'");
			if (del != null && del == "Send") {
			    	$("#sendform-" + $(this).attr("value")).submit();
			}
		});
	</script>

@stop