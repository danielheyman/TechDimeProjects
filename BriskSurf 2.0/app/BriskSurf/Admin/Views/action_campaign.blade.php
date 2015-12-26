@extends('admin::templates.full')

@section('header')

	{{ HTML::style('assets/css/admin/action_campaign.css') }}

@stop


@section('body')

	@if($campaign != 'new') <button class="right" id="delete">Delete</button> @endif
	<button class="right" id="save">Save</button>
	{{ Form::open(array('id' => 'saveform')) }}
		Name: <input class="name" placeholder="Enter a name" type="text" value="{{ ($campaign == 'new') ? '' : $campaign->name }}" name="name">
		<input type="hidden" name="action" value="">
		<input type="hidden" name="filters" value="">
		<input type="hidden" name="results" value="">
	{{ Form::close() }}

	{{ Form::open(array('id' => 'deleteform', 'method' => 'delete')) }} {{ Form::close() }}

	<h3>1. Select a trigger action:</h3>
	<select id="action">
		@foreach($actions as $action)
			<option {{ $campaign != 'new' && $campaign->action == $action ? 'selected' : '' }}>{{ $action }}</option>
		@endforeach
	</select>

	<h3>2. Filter Users:</h3>
	<p>(optional) only send to users who belong to the following lists</p>

	<div class="filters">
		@if($campaign != 'new') 
			@foreach($campaign->filters as $filter_and)
				<div class="filter"><div class="filter_inner">
					@foreach($filter_and as $filter_or)
						<div class="list" value="{{ $filter_or }}"><div class="inner"><div class="filter_name">{{ $lists[$filter_or]->name }}</div><div class="delete">X</div></div></div>
					@endforeach
				</div></div>
			@endforeach
		@endif
	</div>

	<button id="and">+ AND Filter</button>

	<div id="actions">
		@foreach($lists as $list)
			<div value="{{ $list->id }}">{{ $list->name }}</div>
		@endforeach
	</div>

	<h3>3. Emails:</h3>

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Name</th>
	                		<th>Status</th>
	                		<th>Opens</th>
	                		<th>Clicks</th>
	                		<th>Delete</th>
	              	</tr>
            	</thead>
		<tbody>
			@if($campaign != 'new') 
				@foreach($campaign->results as $result)
					@if($result[0] == "email")
						<tr class="email" value="{{ $result[1]->id }}">
							<td class="auto"><a href="{{ URL::to('admin/email/' . $result[1]->id) }}">{{ $result[1]->name }}</a></td>
							<td><select>
								<option value="draft" {{ $result[2] == "draft" ? 'selected' : '' }}>Draft</option>
								<option value="auto" {{ $result[2] == "auto" ? 'selected' : '' }}>Automatic</option>
								<option value="off" {{ $result[2] == "off" ? 'selected' : '' }}>Off</option>
							</select></td>
							<td>{{ $result[1]->opens }}</td>
							<td>{{ $result[1]->clicks }}</td>
							<td><a href="javascript:void(0);" class="delete_email">Delete</a></td>
						</tr>
					@endif
				@endforeach
			@endif
			<tr><td class="auto"><a href="javascript:void(0);" id="add_email">Create New</a></td><td></td><td></td><td></td><td></td></tr>
		</tbody>
	</table>

	<h3>4. Notifications:</h3>

	<table class="table">
		<thead>
	              	<tr>
	                		<th>Name</th>
	                		<th>Status</th>
	                		<th>Views</th>
	                		<th>Delete</th>
	              	</tr>
            	</thead>
		<tbody>
			@if($campaign != 'new') 
				@foreach($campaign->results as $result)
					@if($result[0] == "notification")
						<tr class="notification" value="{{ $result[1]->id }}">
							<td class="auto"><a href="{{ URL::to('admin/notification/' . $result[1]->id) }}">{{ $result[1]->name }}</a></td>
							<td><select>
								<option value="auto" {{ $result[2] == "auto" ? 'selected' : '' }}>Automatic</option>
								<option value="off" {{ $result[2] == "off" ? 'selected' : '' }}>Off</option>
							</select></td>
							<td>{{ $result[1]->views }}</td>
							<td><a href="javascript:void(0);" class="delete_notification">Delete</a></td>
						</tr>
					@endif
				@endforeach
			@endif
			<tr><td class="auto"><a href="javascript:void(0);" id="add_notification">Create New</a></td><td></td><td></td><td></td></tr>
		</tbody>
	</table>

	<br><br><br><br>
@stop


@section('footer')

	{{ HTML::script('assets/js/admin/action_campaign.js') }}

@stop



