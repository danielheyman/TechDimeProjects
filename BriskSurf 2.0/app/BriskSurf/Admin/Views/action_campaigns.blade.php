@extends('admin::templates.full')

@section('body')

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Name</th>
	              	</tr>
            	</thead>
		<tbody>
			@foreach($campaigns as $campaign)
				<tr><td><a href="{{ url('admin/campaigns/action/' . $campaign->id) }}">{{ ($campaign->name == "") ? "I'm nameless" : $campaign->name }}</a></td></tr>
			@endforeach
			<tr><td><a href="{{ url('admin/campaigns/action/new') }}">Create New</a></td></tr>
		</tbody>
	</table>

@stop