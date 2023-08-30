@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card p-0 text-white mb-3" style="width: 30rem;">
            <div class="card-header d-flex justify-content-end">

                @if(str_starts_with( $album->image, 'http'))
                <img src="{{ $album->image }}" style="width: 28rem;" alt="{{ $album->title}}">
                @else
                <img src="{{  asset('storage/' . $album->image) }}" alt="{{ $album->title}}" style="width: 28rem;">
                @endif
            </div>

            <div class="card-body px-5 bg-dark ">
                <h5> TITLE : {{ $album->title}} </h5>
                <p> SLUG: {{ $album->slug }} </p>
                <p>Album Category : {{ $album->albumType->name}}</p>

                @if (count($album->technologies) > 0)
                <p>Technologies :
                    @foreach($album->technologies as $technology)
                    {{$technology->name}}
                    @endforeach
                </p>
                @endif
                <p class="card-title"> SINGER NAME'S: {{ $album->singer_name }}</p>
                <p class="card-text my-4">SONDS : {{ $album->songs_number}}</p>
                <p>GENRES : {{ $album->genres }}</p>
                <div class="d-flex justify-content-center ">
                    <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-md btn-success mx-2">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('admin.albums.destroy', $album) }} " method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-md btn-warning ">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection