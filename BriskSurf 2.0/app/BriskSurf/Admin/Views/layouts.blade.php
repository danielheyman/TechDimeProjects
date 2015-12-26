@extends('admin::templates.full')

@section('body')

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Name</th>
	              	</tr>
            	</thead>
		<tbody>
			@foreach($layouts as $layout)
				<tr><td><a href="{{ url('admin/emails/layouts/' . $layout->id) }}">{{ ($layout->name == "") ? "I'm nameless" : $layout->name }}</a></td></tr>
			@endforeach
			<tr><td><a href="{{ url('admin/emails/layouts/new') }}">Create New</a></td></tr>
		</tbody>
	</table>

@stop