<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {

        $albums = Album::with('technologies', 'albumType')->paginate(8);
        return response()->json([
            'success' => true,
            'results' => $albums
        ]);
    }

    public function show(string $album) //non si usa la dipencie injection perché si usa il with pere passare altri 
    //collegati con la tabella albums e qui si può usare sia lo ($slug che il $album) perché si è usato nel model Album il getRouteKeyName()
    {
        $albums = Album::with('technologies', 'albumType')->findOrFail($album);
        return response()->json([
            'success' => true,
            'results' => $albums
        ]);
    }
}
