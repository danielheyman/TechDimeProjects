@extends('admin::templates.full')

@section('body')

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Recipient</th>
	                		<th>Email</th>
	                		<th>Date</th>
	                		<th>Opened</th>
	                		<th>Clicked</th>
	              	</tr>
            	</thead>
		<tbody>
			@foreach($logs as $log)
				<tr>
					<td class="auto"><a href="{{ url('admin/users/' . $log->user_id) }}">{{ $log->user_name }}</a></td>
					<td><a href="{{ url('admin/emails/log/' . $log->id) }}">{{ $log->subject }}</a></td>
					<td>{{ $log->created_at->diffForHumans() }}</td>
					<td>{{ $log->opened ? 'True' : 'False' }}</td>
					<td>{{ $log->clicked ? 'True' : 'False' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@stop