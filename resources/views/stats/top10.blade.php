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
            @forelse($shibes as $count => $shibe)
                <tr>
                    <td>{{ $count + 1 }}</td>
                    <td>
                        <a href="{{ URL::route('shibe.show', $shibe->hash) }}">
                            <img src="{{ $shibe->finished_url }}" width=50 />
                        </a>
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
