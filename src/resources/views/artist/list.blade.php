@extends('layout')
 
@section('content')
 
    <h1>{{ $title }}</h1>
 
    @if (count($items) > 0)
 
        <table class="table table-striped table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>ID</td>
                    <th>Name</td>
                    <th>&nbsp;</td>
                </tr>
            </thead>
            <tbody>
 
            @foreach($items as $artist)
            <tr>
                <td>{{ $artist->id }}</td>
                <td>{{ $artist->name }}</td>
                <td>
                    <a href="/artists/update/{{ $artist->id }}" class="btn btn-outline-primary btn-sm">Edit</a> 
                    / 
                    <form action="/artists/delete/{{ $artist->id }}" method="post" class="deletion-form d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
 
            </tbody>
        </table>
 
    @else
 
        <p>No artists found</p>
 
    @endif

    <a href="/artists/create" class="btn btn-primary">Add new artist</a>
 
@endsection