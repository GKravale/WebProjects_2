<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ArtistController extends Controller implements HasMiddleware
{
    //display all Artists
    public function list(): View // read
    {
        $items = Artist::orderBy('name', 'asc')->get();

        return view(
            'artist.list',
            [
                'title' => 'Artists',
                'items' => $items,
            ]
        );
    }

    public function create(): View
    {
        return view(
            'artist.form',
            [
                'title' => 'Add artist',
                'artist' => new Artist()
            ]
        );
    }

    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $artist = new Artist();
        $artist->name = $validatedData['name'];
        $artist->save();

        return redirect('/artists');
    }

    public function update(Artist $artist): View
    {
        return view(
            'artist.form',
            [
                'title' => 'Edit artist',
                'artist' => $artist
            ]
        );
    }
    public function patch(Artist $artist, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $artist->name = $validatedData['name'];
        $artist->save();

        return redirect('/artists');
    }

    public function delete(Artist $artist): RedirectResponse
    {
        $artist->delete();
        return redirect('/artists');
    }

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }



}
