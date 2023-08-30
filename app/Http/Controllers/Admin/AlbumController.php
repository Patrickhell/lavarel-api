<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumType;
use App\Models\Album;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::paginate(10);
        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $album_types = AlbumType::all();
        $technologies = Technology::all();
        return view('admin.albums.create', compact('album_types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data = $request->validate([
            'singer_name' => ['required', 'min:10', 'max:255'],
            'title' => ['required', 'unique:albums', 'max:255'],
            'image' => ['image',],
            'genres' => ['required', 'max:255'],
            'songs_number' => ['required', 'max:20'],
            'technology_id' => ['exists:technologies,id'],
            'album_type_id' => ['required', 'exists:album_types,id'], // qui la validation serve ad assicurarsi che il valore scelto exista
            //nella tabella album_type con la colonna :id cioè: album_type_id

        ]);
        //dd($data);

        if ($request->hasFile('image')) {
            $img_path = Storage::put('uploads/admin/albums', $request['image']);
            $data['image'] = $img_path;
        }

        $data['slug'] = Str::of($data['title'])->slug('-');
        $newAlbum = Album::create($data);

        $newAlbum->slug = Str::of("$newAlbum->id " . $data['title'])->slug('-');
        $newAlbum->save();

        if ($request->has('technologies')) {
            // si crea una relazione tra album e tutte le technologie selezionati nella create($request)
            // il metodo sync() consente  di poter aggiungere e eliminare contemporaneamente i  record nella tabella ponte 
            $newAlbum->technologies()->sync($request->technologies);
        }

        return redirect()->route('admin.albums.show', $newAlbum);
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return view('admin.albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        $technologies = Technology::all();
        $album_types = AlbumType::all();
        return view('admin.albums.edit', compact('album', 'technologies', 'album_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album) //usiamo dipendencies injection sostituendo string $id 
    {
        $data = $request->validate([
            'singer_name' => ['required', 'min:10', 'max:255'],
            //per risolvere il problema dell'alert che dice che il titolo è già stato utilizzato infatti perché esendo unico non pùo essere usato più di una volta
            // si usa : il methodo ignore() usando la libreria: use Illuminate\Validation\Rule;  
            'title' => ['required', Rule::unique('albums')->ignore($album->id), 'max:255'],
            'image' => ['image'],
            'genres' => ['required', 'max:25'],
            'songs_number' => ['required', 'max:20'],
            'technology_id' => ['exists:technologies,id'],
            'album_type_id' => ['required', 'exists:album_types,id'],

        ]);

        if ($request->hasFile('image')) {
            Storage::delete($album->image);
            $img_path = Storage::put('uploads/admin/albums', $request['image']);
            $data['image'] = $img_path;
        }



        // non potendo usare un methodo statico essendo che si pùo modificare il singolo campo del form, non si può scrivere: $album::update
        //invece di compilare tutto a mano, e salvare, usiamo le fillable

        $data['slug'] = Str::of("$album->id " . $data['title'])->slug('-');
        $album->update($data);

        if ($request->has('technologies')) {
            // si crea una relazione tra album e tutte le technologie selezionati nella create($request)
            // il metodo sync() consente  di poter aggiungere e eliminare contemporaneamente i  record nella tabella ponte 
            $album->technologies()->sync($request->technologies);
            //
        }
        return redirect()->route('admin.albums.show', compact('album'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)

    {
        $album->delete();
        return redirect()->route('admin.albums.index');
    }

    public function trashedAlbum()
    {  //Album è il modello.
        $albums = Album::onlyTrashed()->paginate((8));
        return view('admin.albums.trashedAlbum', compact('albums'));
    }

    public function restore(Int $id)
    {
        //non funziona con la dipendencie injection perché per forza a questo punto si deve usare il methodo findOrFail per consertire di cercare
        //nell'elemento cancellato nel cestino(perciò si usa il methodo: onlyTrashed() ) se no continua a cercare l'album nell'index tra le cose ancora presenti mentre l'album 
        //è già stato cancellato.
        //NB nella route del web.php, si usa infatti {id o $album} perché la findOrFail infatti cerca l'album nel cestino :
        //Route::delete(che diventa con obliterated POST) ('/albums/deleted/{post}', [AlbumController::class, 'restore'])->name('albums.restore');
        // attuando il metodo obliterate la 'delete' diventa 'POST' perché non viene cancellato l'album definitivamente in quanto a 
        //questo livello lo si pùo ancora restaurare
        $album = Album::onlyTrashed()->findOrFail($id);
        $album->restore();
        return redirect()->route('admin.albums.index');
    }

    public function obliterate(Int $id)
    {

        $album = Album::onlyTrashed()->findOrFail($id);
        storage::delete($album->image);
        $album->technologies()->detach();
        $album->forceDelete();

        return redirect()->route('admin.albums.index');
    }
}
