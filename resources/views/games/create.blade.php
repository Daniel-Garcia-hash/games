@extends('base')

@section('title', '🎮 Add Game')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="/games/store">
        @csrf
        <div class="form-group">
            <label for="game_name">Game Name *</label>
            <input id="game_name" type="text" class="form-control" name="game_name" value="{{ old('game_name') }}" maxlength="255" required />
        </div>
        <div class="form-group">
            <label for="platform">Platform *</label>
            <input id="platform" type="text" class="form-control" name="platform" value="{{ old('platform') }}" maxlength="255" placeholder="PS5, Xbox, PC, Switch..." required />
        </div>
        <div class="form-group">
            <label for="genre">Genre *</label>
            <input id="genre" type="text" class="form-control" name="genre" value="{{ old('genre') }}" maxlength="255" placeholder="Action, RPG, Sports..." required />
        </div>
        <div class="form-group">
            <label for="rating">Rating (0-10) *</label>
            <input id="rating" type="number" step="0.1" min="0" max="10" class="form-control" name="rating" value="{{ old('rating') }}" required />
        </div>
        <button type="submit" class="btn btn-success">Add Game</button>
        <a href="/games" class="btn btn-secondary">Back to games</a>
    </form>
@endsection
