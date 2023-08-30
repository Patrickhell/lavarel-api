@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-6">
                @error('album_type_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="album_type_id" class="form-label">
                        Choose a Category
                    </label>
                    <select class="form-select" name="album_type_id" id="album_type_id">
                        @foreach($album_types as $album_type)
                        <option value="{{$album_type->id}}" {{old('album_type_id') == $album_type->id ? 'selected' : '' }}>
                            {{$album_type->name}}
                        </option>
                        @endforeach

                    </select>
                </div>
                @error('singer_name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="singer_name" class="form-label">
                        Singer name's
                    </label>
                    <input type="text" class="form-control" id="singer_name" name="singer_name" value="{{old('singer_name', '' ) }}">
                </div>
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="title" class="form-label">
                        Title
                    </label>
                    <input type="text" class="form-control" id="title" name="title" value="{{old('title', '' ) }}">
                </div>
                @error('technology_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="technologies" class="form-label">
                        Select One o More Technologies
                    </label>
                    @foreach($technologies as $technology)
                    <div class="d-block">
                        <input type="checkbox" class="form-check-label " name="technologies[]" value="{{$technology->id}}" @if(in_array($technology->id, old('technologies', [] ))) checked @endif >
                        <label for="technology_id" class="form-check-label ">
                            {{$technology->name}}
                        </label>
                    </div>

                    @endforeach
                </div>
            </div>
            <div class=" col-6">
                @error('genres')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="genres" class="form-label">
                        Genres
                    </label>
                    <input type="text" class="form-control" id="genres" name="genres" value="{{old('genres', '' ) }}">
                </div>

                <div class="mb-3">
                    <label for="songs_number" class="form-label">
                        Songs
                    </label>
                    <input type="number" class="form-control" id="songs_number" name="songs_number" value="{{old('songs_number', '' ) }}">
                </div>
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="image" class="form-label">
                        Cover Album
                    </label>
                    <input type="file" class="form-control" id="image" name="image" value="{{ old('image', '') }}">
                </div>

            </div>

            <div class=" d-flex justify-content-center text-white">
                <button type="submit" class="mx-2" style="background: greenyellow">
                    Create your Album

                </button>
                <button type="reset" style="background: yellow">
                    Reset
                </button>
            </div>
        </div>
    </form>
</div>
@endsection