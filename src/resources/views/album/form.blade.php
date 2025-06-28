@extends('layout')

@section('content')

<h1>{{ $title }}</h1>

@if ($errors->any())
  <div class="alert alert-danger">Please correct the mistakes!</div>
@endif

<form
  method="post"
  action="{{ $album->exists ? '/albums/patch/' . $album->id : '/albums/put' }}"
  enctype="multipart/form-data"
>
  @csrf

  <div class="mb-3">
    <label for="album-title" class="form-label">Title</label>
    <input
      type="text"
      id="album-title"
      name="title"
      value="{{ old('title', $album->title) }}"
      class="form-control @error('title') is-invalid @enderror"
    >
    @error('title')
      <p class="invalid-feedback">{{ $errors->first('title') }}</p>
    @enderror
  </div>

  <div class="mb-3">
    <label for="album-artist" class="form-label">Artist</label>
    <select
      id="album-artist"
      name="artist_id"
      class="form-select @error('artist_id') is-invalid @enderror"
    >
      <option value="">Specify the artist!</option>
      @foreach($artists as $artist)
        <option
          value="{{ $artist->id }}"
          @if ($artist->id == old('artist_id', $album->artist_id)) selected @endif
        >{{ $artist->name }}</option>
      @endforeach
    </select>
    @error('artist_id')
      <p class="invalid-feedback">{{ $errors->first('artist_id') }}</p>
    @enderror
  </div>

  <div class="mb-3">
    <label for="album-year" class="form-label">Year</label>
    <input
      type="number"
      max="{{ date('Y') + 1 }}"
      step="1"
      id="album-year"
      name="year"
      value="{{ old('year', $album->year) }}"
      class="form-control @error('year') is-invalid @enderror"
    >
    @error('year')
      <p class="invalid-feedback">{{ $errors->first('year') }}</p>
    @enderror
  </div>

  <div class="mb-3">
    <label for="album-image" class="form-label">Album cover</label>
    <input
      type="file"
      id="album-image"
      name="image"
      class="form-control @error('image') is-invalid @enderror"
    >
    @error('image')
      <p class="invalid-feedback">{{ $errors->first('image') }}</p>
    @enderror

    @if ($album->image)
      <div class="mt-2">
        <img src="{{ asset('images/' . $album->image) }}" alt="Album cover" style="height: 100px;">
      </div>
    @endif
  </div>

  <button type="submit" class="btn btn-primary">
    {{ $album->exists ? 'Edit' : 'Add' }}
  </button>

</form>

@endsection
