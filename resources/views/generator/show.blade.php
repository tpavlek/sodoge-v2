@extends('layout')

@section('title')
loog at doge
@stop

@section('content')
<div class="pure-g">
  <div class="pure-u-2-3">
    <div class="centered"> 
      <h2>{{ $shibe->title }}</h2>
      <div class="constrain constrain-display">
        <img src="{{ $imagePath }}" />
      </div>
    </div>
  </div>
  <div class="pure-u-1-3">
    <h2>many info</h2>
    <div class="pallette info-pallette">
      <p>
        <strong>Uploader:</strong> 
        <a href="{{ URL::route('user.show', $shibe->user->id) }}">{{ $shibe->user->username }}</a>
      </p>
      <p>
        <strong>Views:</strong> {{ $shibe->views }}
     </p>
    </div>
    <br />
    <br />
    <a href="{{ URL::route('generator.index') }}" class="pure-button pure-button-good size-120">
      play wif own doge
    </a>
  </div>
</div>
@stop
