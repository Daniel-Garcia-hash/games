@extends('base')

@section('title', '🎮 Game Details')

@section('content')
    <dl class="row">
        <dt class="col-sm-3">Game name</dt>
        <dd class="col-sm-9">{{ $game->game_name }}</dd>

        <dt class="col-sm-3">Platform</dt>
        <dd class="col-sm-9">{{ $game->platform }}</dd>

        <dt class="col-sm-3">Genre</dt>
        <dd class="col-sm-9">{{ $game->genre }}</dd>

        <dt class="col-sm-3">Rating</dt>
        <dd class="col-sm-9">{{ $game->rating }}/10</dd>
    </dl>

    <a href="/games" class="btn btn-secondary">Back to games</a>
    <a href="/games/edit/{{ $game->id }}" class="btn btn-primary">Edit</a>
@endsection
