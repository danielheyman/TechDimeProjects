@extends('templates.form')

@section('name')
    Login
@stop

@section('form')

    {{ Form::open() }}
        {{ $errors->first('global', '<p class="error">:message</p>') }}

        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <div class="form-group">
            {{ Form::label('username', 'What is your username?') }}
            {{ Form::text('username', '', array(
                'class' => 'form-control'
            )) }}
        </div>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <div class="form-group">
            {{ Form::label('password', 'What is your password?') }}
            {{ Form::Password('password', array(
                'class' => 'form-control'
            )) }}
        </div>
        <button class="btn btn-huge btn-info">Login</button>
    {{ Form::close() }}
    <br><br><a href="{{ url('remind') }}">Remind</a> password
    <br><a href="{{ url('resend') }}">Resend</a> activation

@stop