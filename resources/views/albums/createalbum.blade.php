@extends('templates.layout')

@section('content')
    <h1>CREATE ALBUM</h1>

    @include('partials.inputerror')

    <form method="POST" action="{{route('album.save')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" required name="name" id="name" class="form-control"
                   placeholder="Album name" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="description">Description *</label>
            <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
        </div>

        @include('albums.partials.category_combo')

        @include('albums.partials.fileupload')
        <button type="submit" class="btn btn-primary">Invia</button>
    </form>
@stop