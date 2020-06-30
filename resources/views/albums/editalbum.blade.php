@extends('templates.layout') {{--SI USA IL PUNTO, NON IL /--}}

@section('content')
    <h1>EDIT ALBUM</h1>             {{-- X INVIARE FILE: enctype="multipart/form-data" --}}

    @include('partials.inputerror')

    <form method="POST" action="{{route('album.store', $album->id)}}" enctype="multipart/form-data">
        @csrf
        {{--PER SIMULARE UN FORM METHOD="PATCH"--}}
        <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control"
             value="{{$album->album_name}}" placeholder="Album name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{$album->description}}</textarea>
        </div>

        @include('albums.partials.category_combo')

        @include('albums.partials.fileupload') {{--SI USA IL PUNTO, NON IL /--}}


        <button type="submit" class="btn btn-primary">Invia</button>
        <a href="{{route('albums')}}" class="btn btn-default">Torna all'elenco</a>
        <a href="{{route('album.getimages', $album->id)}}" class="btn btn-default">Immagini</a>
    </form>
@stop