@extends('templates.full')

@section('header')
	{{ HTML::style('assets/css/in.settings.css') }}
@stop

@section('body')
	<section class="content-33" style="padding: 60px 0;">
		<div class="container">
			<div class="row demo-tiles">
				<div class="col-xs-12" >
					{{ Form::model($user) }}
						{{ $errors->first('global', '<p class="error">:message</p>') }}
						{{ $errors->first('name', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('name', 'Name') }}
							{{ Form::text('name', null, array(
								'class' => 'form-control'
							)) }}
						</div>
						{{ $errors->first('email', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('email', 'Email') }}
							{{ Form::text('email', null, array(
								'class' => 'form-control'
							)) }}
						</div>
						{{ $errors->first('paypal_email', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('paypal', 'Paypal Email') }}
							{{ Form::text('paypal', null, array(
								'class' => 'form-control'
							)) }}
						</div>
						{{ $errors->first('continent', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('continent', 'Where do you live?') }}
							{{ Form::select('continent', $continents, null, array(
								'class' => 'form-control'
							) ) }}
						</div>
						{{ $errors->first('year', '<p class="error">:message</p>') }}
						<div class="form-group">
							{{ Form::label('year', 'When\'s your birthday?') }}
							{{ Form::select('year', $years, $user->birthyear, array(
								'class' => 'form-control'
							) ) }}
						</div>
						{{ $errors->first('password', '<p class="error">:message</p>') }}
						<div>
							<div class="col-xs-6" style="padding:0; padding-right:20px;">
								<div class="form-group">
									{{ Form::label('password', 'New Password') }}
									{{ Form::password('password', array(
										'class' => 'form-control'
									)) }}
								</div>
							</div>
							<div class="col-xs-6"  style="padding:0; padding-left:20px;">
								<div class="form-group">
									{{ Form::label('password_confirmation', 'Confirm Password') }}
									{{ Form::password('password_confirmation', array(
										'class' => 'form-control'
									)) }}
								</div>
							</div>
						</div>
						{{ $errors->first('newsletter', '<p class="error">:message</p>') }}
						<div>
							{{ Form::label('newsletter', 'Receieve Newsletters') }}
							{{ Form::checkbox('newsletter', 1) }}
						</div>
						{{ $errors->first('admin_emails', '<p class="error">:message</p>') }}
						<div>
							{{ Form::label('admin_emails', 'Receieve Admin Emails') }}
							{{ Form::checkbox('admin_emails', 1) }}
						</div><br>
						<button class="btn btn-huge btn-info">Save Settings</button>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</section>
@stop