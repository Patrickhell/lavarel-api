@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class=" col-12">
            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">SINGER NAME'S</th>
                        <th scope="col">TITLE</th>
                        <th scope="col">SLUG</th>
                        <th scope="col">GENRES</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach( $albums as $album)
                    <tr>
                        <th>
                            {{$album->id}}
                        </th>
                        <td>
                            {{$album->singer_name}}
                        </td>

                        <td>
                            {{$album->title}}
                        </td>
                        <td>
                            {{ $album->slug }}
                        </td>
                        <td>
                            {{$album->genres}}
                        </td>
                        <td>
                            <a href="{{ route('admin.albums.show', $album) }}" class="btn btn-sm btn-primary  mx-2">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-sm btn-success mx-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form class="d-inline-block" action="{{ route('admin.albums.destroy', $album) }} " method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-md btn-warning ">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$albums->links()}}
        </div>
    </div>
</div>
@endsection