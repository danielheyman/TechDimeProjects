@extends('admin::templates.full')

@section('header')
	{{ HTML::style('assets/css/admin/dash.css') }}
@stop

@section('body')

	<div class="selectionWrap"><select id="selection">
		<option value="daily">Daily</option>
	</select></div>
	<br>
	
	@foreach($graphs as $name => $values)
		<div class="checkboxes">
			<div class="checkbox">
				<input type="checkbox" value="None" id="checkbox{{ $name }}" name="{{ $name }}" checked />
				<label for="checkbox{{ $name }}"></label>
			</div>
			<div class="label">{{ $name }}</div>
		</div>
		<script type="text/javascript">
			var daily_{{ $name }} = [
				@foreach($values as $day => $value)
					['{{ $day }}', {{ $value }}],
				@endforeach
			];
		</script>
	@endforeach
		
	<div class="chartWrapper"><div id="chart"></div></div>

@stop

@section('footer')
	{{ HTML::script('assets/js/admin/dash.js') }}
@stop