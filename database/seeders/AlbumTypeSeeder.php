<?php

namespace Database\Seeders;

use App\Models\AlbumType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $album_types = [
            'Acoustic Albums', 'Animation Albums', 'Covers Albums', 'Concept Albums', 'Compilation Albums',
            ' Instrumental Albums', 'Remix Albums', 'Musci Albums', 'Live Albums', 'Mixtape Albums'

        ];

        foreach ($album_types as $album_type) {
            $newAlbumType = new AlbumType();
            $newAlbumType->name =  $album_type;
            $newAlbumType->save();
        }
    }
}
