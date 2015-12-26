@extends('templates.full')

@section('header')
	{{ HTML::style('assets/css/in.settings.css') }}
	{{ HTML::style('assets/css/in.website_settings.css') }}
@stop

@section('body')
	<section class="content-33" style="padding: 60px 0;">
		<div class="container">
			<div class="row demo-tiles">
				<div class="col-xs-12" >
					{{ Form::model($website) }}
						{{ $errors->first('global', '<p class="error">:message</p>') }}
						{{ $errors->first('credits', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('credits', 'Credits ( You have ' . $user->credits . ' credits available )') }}
							{{ Form::text('credits', null, array(
								'class' => 'form-control'
							)) }}
						</div>
						{{ $errors->first('auto_assign', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('auto_assign', 'Auto Assign') }}
							{{ Form::text('auto_assign', null, array(
								'class' => 'form-control'
							)) }}
						</div>
						{{ $errors->first('enabled', '<p class="error">:message</p>') }}
						<div>
							<label for="enabled">Status: <a style="color: {{ ($website->enabled) ? '#1abc9c' : '#e74c3c' }}" href="javascript:void(0);" id="enabled">{{ ($website->enabled) ? "Rotating" : "Paused" }}</a></label>
							{{ Form::hidden('enabled', 1) }}
						</div>
						
						<label>Hour of the day:</label>
						{{ $errors->first('hours', '<p class="error">:message</p>') }}
						<br>
						<label class="enabled-description">
							<button class="btn btn-xs btn-primary">&nbsp;</button> Enabled
							<button class="btn btn-xs btn-danger">&nbsp;</button> Disabled
						</label>
						<br>
						<div id="hours">
							{{ Form::hidden('hours', implode(",", $website->hours)) }}
							@for($hour = 0; $hour < 12; $hour++)
								<button class="btn btn-sm btn-primary">{{ ($hour == 0) ? 12 : $hour }} AM</button>
							@endfor

							@for($hour = 0; $hour < 12; $hour++)
								<button class="btn btn-sm btn-primary">{{ ($hour == 0) ? 12 : $hour }} PM</button>
							@endfor
						</div>
						
						<label>Weekday:</label>
						{{ $errors->first('days', '<p class="error">:message</p>') }}
						<br>
						<label class="enabled-description">
							<button class="btn btn-xs btn-primary">&nbsp;</button> Enabled
							<button class="btn btn-xs btn-danger">&nbsp;</button> Disabled
						</label>
						<br>
						<div id="days">
							{{ Form::hidden('days', implode(",", $website->days)) }}
							@foreach(array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday") as $day)
								<button class="btn btn-sm btn-primary">{{ $day }}</button>
							@endforeach
						</div>

						<br>
						<a href="{{ url('websites') }}" class="btn btn-huge btn-info">Go Back</a>
						<button class="btn btn-huge btn-info">Save Settings</button>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</section>
@stop

@section('footer')
	
	<script type="text/javascript">
		var targeting = {{ ($targeting) ? 'true' : 'false' }};
		var url = '{{ url("memberships") }}';
	</script>

	{{ HTML::script('assets/js/in.website_settings.js') }}

@stop