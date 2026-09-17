<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_name' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:10'
        ]);

        $game = new Game([
            'game_name' => $request->get('game_name'),
            'platform' => $request->get('platform'),
            'genre' => $request->get('genre'),
            'rating' => $request->get('rating')
        ]);

        $game->save();

        return redirect('/games')->with('success', 'Game added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::findOrFail($id);
        return view('games.show', ['game' => $game]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $game = Game::findOrFail($id);
        return view('games.edit', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $game = Game::findOrFail($id);

        $request->validate([
            'game_name' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:10'
        ]);

        $game->game_name = $request->get('game_name');
        $game->platform = $request->get('platform');
        $game->genre = $request->get('genre');
        $game->rating = $request->get('rating');
        $game->save();

        return redirect('/games')->with('success', 'Game updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect('/games')->with('success', 'Game deleted!');
    }
}
