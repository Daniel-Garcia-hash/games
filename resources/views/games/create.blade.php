<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Add Game</title>
</head>
<body>
    <div class="container" style="margin:40px;">
        <h1 class="display-4">🎮 Add Game</h1>
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
    </div>
</body>
</html>
