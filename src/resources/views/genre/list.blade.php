@extends('layout')

@section('content')
    <h1>Genres</h1>
    <a href="/genres/create">Add new genre</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        @foreach($genres as $genre)
            <tr>
                <td>{{ $genre->id }}</td>
                <td>{{ $genre->name }}</td>
                <td>
                    <a href="/genres/update/{{ $genre->id }}">Edit</a>
                    <form method="POST" action="/genres/delete/{{ $genre->id }}" style="display:inline">
                        @csrf
                        <button type="submit" onclick="return confirm('Do you really want to delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
