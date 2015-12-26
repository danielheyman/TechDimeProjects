@extends('admin::templates.full')

@section('body')

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Name</th>
	                		<th>Count</th>
	                		<th>Status</th>
	              	</tr>
            	</thead>
		<tbody>
			@foreach($lists as $list)
				<tr><td>@if($list->status == "processed")
					<a href="{{ url('admin/lists/' . $list->id) }}">{{ ($list->name == "") ? "I'm nameless" : $list->name }}</a>@else
					{{ ($list->name == "") ? "I'm nameless" : $list->name }} (processing)
					@endif
					</td><td>{{ $list->user_count }} users</td><td>{{ $list->status }}</td></tr>
			@endforeach
			<tr><td><a href="{{ url('admin/lists/new') }}">Create New</a></td><td></td><td></td></tr>
		</tbody>
	</table>

@stop


@section('footer')


@stop