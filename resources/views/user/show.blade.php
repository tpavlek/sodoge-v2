@extends('layout')

@section('title')
my dogehouse
@stop

@section('content')

<h1>wow such shibe, many registered</h1>

Username is: {{ $user->username }}
<br />
<br />

<h2>User Shibes</h2>
@forelse($shibes as $shibe)
  <a href="{{ URL::route('generator.show', $shibe->hash) }}">
    {{ $shibe->title }}<br />
  </a>
  @empty
  <h3>No shibes here!</h3>
@endforelse
<br />
many more features very soon
@stop
