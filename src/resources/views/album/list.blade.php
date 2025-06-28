@extends('layout')
 
@section('content')

    <h1>{{ $title }}</h1>

    @if (count($items) > 0)

        <table class="table table-striped table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Artist</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Image</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            @foreach($items as $album)
            <tr>
                <td>{{ $album->id }}</td>
                <td>{{ $album->artist ? $album->artist->name : 'N/A' }}</td>
                <td>{{ $album->title }}</td>
                <td>{{ $album->year }}</td>
                <td>
                    @if ($album->image)
                        <img src="{{ asset('storage/' . $album->image) }}" alt="Album cover" style="height: 50px;">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </td>
                <td>
                    <a href="/albums/update/{{ $album->id }}" class="btn btn-outline-primary btn-sm">Edit</a>
                    /
                    <form action="/albums/delete/{{ $album->id }}" method="post" class="deletion-form d-inline" onsubmit="return confirm('Are you sure you want to delete this album?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>

    @else

        <p>No albums found.</p>

    @endif

    <a href="/albums/create" class="btn btn-primary">Add new album</a>

@endsection
