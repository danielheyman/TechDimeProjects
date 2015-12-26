@extends('templates.form')

@section('name')
	Before you continue on your marvelous journey,<br>
	We need you to complete your account setup
@stop

@section('form')

	{{ Form::open() }}
		{{ $errors->first('global', '<p class="error">:message</p>') }}
		{{ $errors->first('gender', '<p class="error">:message</p>') }}
		<div class="form-group">
			{{ Form::label('gender', 'What is your gender?') }}
			{{ Form::select('gender', $genders, null, array(
				'class' => 'form-control',
				'style' => 'min-width:300px'
			) ) }}
		</div>
		{{ $errors->first('continent', '<p class="error">:message</p>') }}
		<div class="form-group">
			{{ Form::label('continent', 'Where are you from?') }}
			{{ Form::select('continent', $continents, null, array(
				'class' => 'form-control',
				'style' => 'min-width:300px'
			) ) }}
		</div>

		{{ $errors->first('year', '<p class="error">:message</p>') }}
	            <div class="form-group">
			{{ Form::label('gender', "When's your birthday?") }}
			{{ Form::select('year', $years, null, array(
				'class' => 'form-control',
				'style' => 'min-width:300px'
			) ) }}
		</div>

		<button class="btn btn-huge btn-info">Complete</button>
	{{ Form::close() }}

@stop