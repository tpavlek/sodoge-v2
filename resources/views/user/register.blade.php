@extends('layout')

@section('title')
    i am shibe
@stop

@section('content')
    <div class="pure-g">
        <div class="pure-u-1-2">
            <h2>doge documentation</h2>
            @if($errors->count() > 0)
                <div class='error'>
                    wow such error pls fix:
                    <ul>
                        @foreach($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open([ 'class' => 'pure-form pure-form-aligned' ]) !!}
                <div class="pure-control-group">
                    {!! Form::label('username') !!}
                    {!! Form::text('username') !!}
                </div>
                <div class="pure-control-group">
                    {!! Form::label('email') !!}
                    {!! Form::text('email') !!}
                </div>

                <div class="pure-control-group">
                    {!! Form::label('password') !!}
                    {!! Form::password('password') !!}
                </div>
                <div class="pure-control-group">
                    {!! Form::label('confirm') !!}
                    {!! Form::password('password_confirmation') !!}
                </div>
                <div class="pure-controls">
                    <input type="submit" class="pure-button pure-button-good" value="many bury bone" />
                </div>
            {!! Form::close() !!}
            <br />
            <br />
            <a href="{{ URL::route('user.login') }}" class="pure-button pure-button-orange">
                already passport? stamp loyalty card wow
            </a>
        </div>

        <div class="pure-u-1-2">
            @include('_partials/dogeGuarantee')
        </div>
    </div>
@stop
