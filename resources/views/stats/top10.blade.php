@extends('layout')

@section('title')
coolest fonzy shibes
@stop

@section('content')
<div class="centered">
  <h1>top 10 shibes</h1>
  <table class="pure-table centered" style="display:inline-block;">
    <thead>
      <tr>
        <th>rank</th>
        <th>thumb</th>
        <th>owner</th>
        <th>views</th>
      </tr>
    </thead>
    @forelse($shibes as $i => $shibe)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>
            <a href="{{ URL::route('generator.show', $shibe->hash) }}"
            <img src="/img/finished/{{ $shibe->hash }}" width=50 />
        </td>
        <td><a href="{{ URL::route('user.show', $shibe->user->id) }}">{{ $shibe->user->username }}</a>
        <td>{{ $shibe->views }}</td>
      </tr>
      @empty
        <tr>
            <td colspan="4">nothing here!</td>
        </tr>
    @endforelse
  </table>
</div>
@stop
