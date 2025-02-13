<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public function index()
    {
        return Inertia::render('Album/Index', ['albums' => Album::all()]);
    }

    public function create()
    {
        return Inertia::render('Album/Create');
    }

    public function store(Request $request)
    {
        Album::create($request->validate([
            'title' => ['required', 'string','max:255']
        ]));

        return to_route('albums.index');
    }

    public function show(Album $album)
    {
        return Inertia::render('Album/Show', [
            'album' => $album,
            'photos' => $album->getMedia('photos')
        ]);
    }

    public function storePhoto(Request $request, Album $album)
    {
        $request->validate([
            'photo' => ['required', 'image']
        ]);

        $album->addMedia($request->file('photo'))->toMediaCollection('photos');

        return to_route('albums.show', $album);
    }

    public function edit(Album $album)
    {
        return Inertia::render('Album/Edit', [
            'album' => $album
        ]);
    }

    public function update(Request $request, Album $album)
    {
        $album->update($request->validate([
            'title' => ['required', 'string','max:255']
        ]));

        return to_route('albums.index');
    }

    public function destroy(Album $album)
    {
        $album->delete();
    }
}
