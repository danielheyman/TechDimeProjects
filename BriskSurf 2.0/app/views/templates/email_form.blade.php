@extends('templates.form')

@section('form')

    {{ Form::open() }}
        {{ $errors->first('global', '<p class="error">:message</p>') }}

        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <div class="form-group">
            {{ Form::label('email', 'What is your email?') }}
            {{ Form::text('email', '', array(
                'class' => 'form-control'
            )) }}
        </div>
        <button class="btn btn-huge btn-info">Login</button>
    {{ Form::close() }}

@stop