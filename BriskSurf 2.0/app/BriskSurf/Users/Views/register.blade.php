@extends('templates.form')

@section('name')
    Register your account today
@stop

@section('form')

    {{ Form::open() }}
        {{ $errors->first('global', '<p class="error">:message</p>') }}
        {{ $errors->first('name', '<p class="error">:message</p>') }}
        <div class="form-group">
            {{ Form::label('name', 'What is your full name?') }}
            {{ Form::text('name', '', array(
                'class' => 'form-control'
            )) }}
        </div>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <div class="form-group">
            {{ Form::label('email', 'What is your email?') }}
            {{ Form::text('email', '', array(
                'class' => 'form-control'
            )) }}
        </div>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <div class="form-group">
            {{ Form::label('name', 'Username') }}
            {{ Form::text('username', '', array(
                'class' => 'form-control'
            )) }}
        </div>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <div class="clearfix">
            <div class="form-group pull-left">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', array(
                    'class' => 'form-control'
                )) }}
            </div>
            <div class="form-group pull-right">
                {{ Form::label('password_confirmation', 'Confirm Password') }}
                {{ Form::password('password_confirmation', array(
                    'class' => 'form-control'
                )) }}
            </div>
        </div>
        <button class="btn btn-huge btn-info">Sign Up</button>
        {{ SecureForm::create() }}
    {{ Form::close() }}

@stop