<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumType;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $genres = [
            'Pop', 'Rap & HipHop', 'Rock', 'Classica', 'Elettronica', 'Jazz', 'Blues', 'Gospel',
            'Soul', 'Country', 'Disco', 'Salsa', 'Raggae', 'Techno', 'Flamenco', 'Raggaeton', 'Funk', 'Indie',
            'Metal'
        ];

        $singer_name = [
            'Rick Novak', 'Susan Connor', 'Margaret Adelman', 'Ronald Barr',
            'Marie Broadlet', 'Roger Lum', 'Marlene Donalhue', 'Jeff Johnson', 'Melvin Forbis'
        ];

        $album_types = AlbumType::all();
        $technologyIds = Technology::all()->pluck('id')->toArray();


        for ($i = 0; $i < 30; $i++) {
            $newAlbum = new Album();
            $newAlbum->album_type_id = $faker->randomElement($album_types)->id;
            $newAlbum->singer_name = $faker->randomElement($singer_name);
            $newAlbum->title = $faker->unique()->Words(2, true);
            $newAlbum->genres = $faker->randomElement($genres);
            $newAlbum->image = $faker->imageUrl(250, 200, 'Album', true, 'albums', true, 'png');
            $newAlbum->songs_number = $faker->numberBetween(8, 15);
            $newAlbum->slug = Str::of($newAlbum->title)->slug('-');
            $newAlbum->save();
            $newAlbum->slug = Str::of("$$newAlbum->id " . $newAlbum->title)->slug('-');
            $newAlbum->save();

            $newAlbum->technologies()->sync([$faker->randomElement($technologyIds), $faker->randomElement($technologyIds), $faker->randomElement($technologyIds)]);
        }
    }
}
