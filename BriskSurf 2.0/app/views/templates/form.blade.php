@extends('templates.full')

@section('header')
    {{ HTML::style('assets/css/templates.form.css') }}
@stop

@section('body')
    <!-- header-20 -->
    <section class="content-20 v-center bg-midnight-blue">
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h3><center>@yield('name')</center></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <center>
                            <div class="signup-form">
                                @yield('form')
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop