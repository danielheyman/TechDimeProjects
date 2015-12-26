@extends('admin::templates.full')


@section('header')
	{{ HTML::style('assets/css/admin/packages.css') }}
@stop

@section('body')

	{{ $errors->first('global', '<p class="error">:message</p><br>') }}
	@if(isset($packages))
		<table class="table">
			<thead>
		              	<tr>
		                		<th>Name</th>
		                		<th>Cost</th>
		              	</tr>
	            	</thead>
			<tbody>
				@foreach($packages as $p)
					<tr><td><a href="{{ url('admin/packages/' . $p->_id) }}">{{ $p->name }}</a></td><td>${{ $p->cost }}</td></tr>
				@endforeach
				<tr><td><a href="{{ url('admin/packages/new') }}">Create New</a></td><td></td></tr>
			</tbody>
		</table>
	@else
		{{ Form::open() }}
		<table class="table">
			<thead>
		              	<tr>
		                		<th>Key</th>
		                		<th>Value</th>
		              	</tr>
	            	</thead>
			<tbody>
				<tr><td>ID</td><td>{{ $package->_id }}</td></tr>
				<tr><td>Item Name</td><td><input placeholder="Enter a name" type="text" name="name" value="{{ $package->name }}"></td></tr>
				<tr><td>Item Cost</td><td><input type="text" name="cost" value="{{ $package->cost }}"></td></tr>
				<tr><td>Renew Interval</td><td>
					<input class="half" name="renew1" value="{{ ($package->renew == 'none') ? 1 : explode(" ", $package->renew)[0] }}">
					<select class="half" name="renew2">
						<option value="day" {{ ($package->renew != 'none' && explode(" ", $package->renew)[1] == "day") ? 'selected' : '' }}>Day</option>
						<option value="month" {{ ($package->renew != 'none' && explode(" ", $package->renew)[1] == "month") ? 'selected' : '' }}>Month</option>
						<option value="year" {{ ($package->renew != 'none' && explode(" ", $package->renew)[1] == "year") ? 'selected' : '' }}>Year</option>
						<option value="none" {{ $package->renew == "none" ? 'selected' : '' }}>None</option>
					</select>
				</td></tr>
				<tr><td>Package Type</td><td>
					<select name="type">
						<option value="credit" {{ $package->type=="credit" ? 'selected' : '' }}>Credit</option>
						<option value="membership" {{ $package->type=="membership" ? 'selected' : '' }}>Membership</option>
					</select>
				</td></tr>
				<tr class="membership"><td>Membership Type</td><td>
					<select name="value_membership">
						<option value="premium" {{ (explode(" ", $package->value)[0] == "premium") ? 'selected' : '' }}>Premium</option>
						<option value="platinum" {{ (explode(" ", $package->value)[0] == "platinum") ? 'selected' : '' }}>Platinum</option>
					</select>
				</td></tr>
				<tr class="membership"><td>Active</td><td>
					<select name="active_membership">
						<option value="false" {{ $package->active=="false" ? 'selected' : '' }}>False</option>
						<option value="premium month" {{ $package->active=="premium month" ? 'selected' : '' }}>Premium Month</option>
						<option value="platinum month" {{ $package->active=="platinum month" ? 'selected' : '' }}>Platinum Month</option>
						<option value="premium annual" {{ $package->active=="premium annual" ? 'selected' : '' }}>Premium Annual</option>
						<option value="platinum annual" {{ $package->active=="platinum annual" ? 'selected' : '' }}>Platinum Annual</option>
						<option value="premium month deal" {{ $package->active=="premium month deal" ? 'selected' : '' }}>Premium Month Deal</option>
						<option value="platinum month deal" {{ $package->active=="platinum month deal" ? 'selected' : '' }}>Platinum Month Deal</option>
						<option value="premium annual deal" {{ $package->active=="premium annual deal" ? 'selected' : '' }}>Premium Annual Deal</option>
						<option value="platinum annual deal" {{ $package->active=="platinum annual deal" ? 'selected' : '' }}>Platinum Annual Deal</option>
					</select>
				</td></tr>
				<tr class="credit"><td>Credit Amount</td><td><input type="text" name="value_credit" value="{{ ($package->type == 'credit' ) ? $package->value : 100 }}"></td></tr>
				<tr class="credit"><td>Active</td><td>
					<select name="active_credit">
						<option value="true" {{ $package->active=="true" ? 'selected' : '' }}>True</option>
						<option value="false" {{ $package->active=="false" ? 'selected' : '' }}>False</option>
					</select>
				</td></tr>
				<tr><td>Trial</td><td>
					<input class="half" name="trial1" value="{{ ($package->trial == 'none') ? 1 : explode(" ", $package->trial)[0] }}" >
					<select  class="half" name="trial2">
						<option value="day" {{ ($package->trial != 'none' && explode(" ", $package->trial)[1] == "day") ? 'selected' : '' }}>Day</option>
						<option value="month" {{ ($package->trial != 'none' && explode(" ", $package->trial)[1] == "month") ? 'selected' : '' }}>Month</option>
						<option value="year" {{ ($package->trial != 'none' && explode(" ", $package->trial)[1] == "year") ? 'selected' : '' }}>Year</option>
						<option value="none" {{ $package->trial == "none" ? 'selected' : '' }}>None</option>
					</select>
				</td></tr>
				<tr><td></td><td><input type="submit" value="Save"></td></tr>
				@if($package->_id != "New Package")
					<tr><td><br><br><br>Delete Package</td><td><br><br><br><input name="delete" type="text" placeholder="Enter the words 'Delete Me' and hit save"></td></tr>
				@endif
				
			</tbody>
		</table>
		{{ Form::close() }}
	@endif

@stop


@section('footer')
	{{ HTML::script('assets/js/admin/packages.js') }}
@stop