<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class AlbumController extends Controller implements HasMiddleware
{
    // call auth middleware
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function list(): View
    {
        $items = Album::orderBy('title', 'asc')->get();
        return view(
            'album.list',
            [
                'title' => 'Albums',
                'items' => $items
            ]
        );
    }

    public function create(): View
    {
        $artists = Artist::orderBy('name', 'asc')->get();
        return view(
            'album.form',
            [
                'title' => 'Add album',
                'album' => new Album(),
                'artists' => $artists,
            ]
        );
    }

    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'year' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048', // max 2MB
        ]);

        $album = new Album();
        $album->artist_id = $validatedData['artist_id'];
        $album->title = $validatedData['title'];
        $album->year = $validatedData['year'];

        if ($request->hasFile('image')) {
            if ($album->image && \Storage::disk('uploads')->exists($album->image)) {
                \Storage::disk('uploads')->delete($album->image);
            }

            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $album->image = $uploadedFile->storePubliclyAs(
                '/',
                $name . '.' . $extension,
                'uploads'
            );
        }

        $album->save();

        return redirect('/albums');
    }

    public function update(int $id): View
    {
        $album = Album::findOrFail($id);
        $artists = Artist::orderBy('name', 'asc')->get();

        return view(
            'album.form',
            [
                'title' => 'Edit album',
                'album' => $album,
                'artists' => $artists,
            ]
        );
    }


    public function patch(Album $album, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'year' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $album->artist_id = $validatedData['artist_id'];
        $album->title = $validatedData['title'];
        $album->year = $validatedData['year'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('albums', 'public');
            $album->image = $path;
        }

        $album->save();

        return redirect('/albums');
    }

    public function delete(Album $album): RedirectResponse
    {
        if ($album->image) {
            unlink(getcwd() . '/images/' . $album->image);
        }

        $album->delete();
        return redirect('/albums');
    }
}
