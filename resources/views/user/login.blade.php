@extends('layout')

@section('title')
    let shibe in
@stop

@section('content')
    <div class="pure-g">
        <div class="pure-u-1-2">
            <h1>shibe customs very skeptical of you wow</h1>

            {!! Form::open([ 'route' => 'user.auth', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}
            <div class="pure-control-group">
                {!! Form::label('username') !!}
                {!! Form::text('username') !!}
            </div>
            <div class="pure-control-group">
                {!! Form::label('password') !!}
                {!! Form::password('password') !!}
            </div>
            <div class="pure-controls">
                <input type="submit" value="let me in" class="pure-button pure-button-good">
            </div>
            {!! Form::close() !!}
            <br />
            <br />
            <br />
            <div class="centered">
                <a href="{{ URL::route('user.register') }}" class="pure-button colour-lightblue size-140">
                    shibe no have doge passport yet pls
                </a>
            </div>
        </div>
        <div class="pure-u-1-2">
            @include('_partials/dogeGuarantee')
        </div>
    </div>
@stop
