@extends('admin::templates.full')

@section('header')
	{{ HTML::style('assets/css/admin/users.css') }}
@stop

@section('body')

	@if( isset($user) )

		<table>
			<tr><td>
				<img src="{{ $user->gravatar(150) }}" style="margin-right: 20px">
			</td><td style="vertical-align:top; padding-right: 20px; border-right: 1px solid #eee; width:200px; font-size: 14px; line-height: 30px;">
				<strong style='font-size: 15px;'>{{ $user->name }} </strong><br>
				Last Login: {{ ($user->last_login) ? $user->last_login->diffForHumans() : "N/A" }}<br>
				Membership: {{ ucfirst($user->membership) }}<br>
				Credits: {{ $user->credits }}<br>
				Cash: ${{ $user->cash }}
			</td><td style="vertical-align:top; padding-left: 20px; padding-right: 20px; border-right: 1px solid #eee; width: 200px">
				Cash: ${{ $user->cash }}<br><br>
				<a href="{{ url('admin/users') }}">New Search</a>
			</td><td style="vertical-align:top; padding-left: 20px;">
				Lists:
				<br><br>
				@foreach($user->lists as $list)
					@if($list->status == "on")
						<a href="{{ URL::to('admin/lists', $list->list_id) }}" class="list">{{ $list->name }}</a>
					@endif
				@endforeach
			</td></tr>
		</table>
		<br><br>
		<center>
		
		{{ Form::open() }}
		<table class="table">
			<thead>
		              	<tr>
		                		<th>Key</th>
		                		<th>Value</th>
		              	</tr>
	            	</thead>
			<tbody>
				@foreach( $settings as $key => $value )
					<tr>
						<td>{{ ucfirst(str_replace("_", " ", $key)) }}</td>
						<td>
							@if($value == "id")
								{{ $user->{$key} }}
							@elseif($value == "string")
								<input placeholder="Enter a string" name="{{ $key }}" type="text" value="{{ $user->{$key} }}">
							@elseif($value == "date")
								<input placeholder="Click to select a date" class="datetime" name="{{ $key }}" type="text" value="{{ isset($user->{$key}) ? $user->{$key}->format('Y/m/d H:i') : \Carbon::now()->format('Y/m/d H:i')  }}">
							@elseif($value == "bool")
								<select name="{{ $key }}">
									<option value="false"{{ !$user->{$key} ? 'selected' : '' }}>False</option>
									<option value="true" {{ $user->{$key} ? 'selected' : '' }}>True</option>
								</select>
							@elseif(gettype($value) == "array")
								<select name="{{ $key }}">
									@foreach($value as $v)
										<option value="{{ $v }}" {{ $user->{$key} == $v ? 'selected' : '' }}>{{ ucfirst($v) }}</option>
									@endforeach
								</select>
							@elseif($value == "number")
								<input name="{{ $key }}" min="0" type="text" value="{{ ($user->{$key}) ?: 0 }}">
							@endif
						</td>
					</tr>
				@endforeach
				<tr>
					<td></td>
					<td><input type="submit" value="Update"></td>
				</tr>
	              	</tbody>
	           	</table>
	           	{{ Form::close() }}

	@elseif( Session::get('users') )

			<center>
			Search Term: <strong>{{ Session::get('search') }}</strong><br><br><br>
			<a href="{{ url('admin/users') }}">New Search</a><br><br><br>
			<table class="table">
				<thead>
			              	<tr>
			                		<th>Gravatar</th>
			                		<th>Name</th>
			                		<th>Username</th>
			                		<th>Membership</th>
			                		<th>Manage</th>
			              	</tr>
		            	</thead>
				<tbody>
					@foreach( Session::get('users') as $user )
						<tr>
							<td><img src="{{ $user->gravatar() }}"></td>
							<td class="height">{{ $user->name }}</td>
							<td class="height">{{ $user->username }}</td>
							<td class="height">{{ $user->membership }}</td>
							<td class="height"><a href="{{ url('admin/users/' . $user->_id) }}">Manage</a></td>
						</tr>
					@endforeach
		              	</tbody>
	           	</table>
		</div>

	@else

		{{ Form::open() }}
			<h2>Login</h2>
			<div class="box">
				{{ $errors->first('global', '<p class="error">:message</p>') }}
				Search by ID, Email, Username, Name, or IP:<br>
				{{ Form::text("search") }}
			</div>
			<button class="login">Search</button>
		{{ Form::close() }}

	@endif

@stop