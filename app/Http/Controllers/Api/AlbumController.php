<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {

        $albums = Album::with('Technologies', 'albumType')->paginate(6);
        return response()->json([
            'success' => true,
            'results' => $albums
        ]);
    }
}
