@extends('templates.layout')

@section('content')
    <h1>
        @if($photo->id)
            Update Image
            @else
            NEW Image
        @endif
    </h1>

    @include('partials.inputerror')

    @if($photo->id)
        <form method="POST" action="{{route('photos.update', $photo->id)}}" enctype="multipart/form-data">
            {{--<input type="hidden" name="_method" value="PATCH">--}}
            {{--{{method_field('patch')}}--}}
            @method('patch')
    @else
        <form method="POST" action="{{route('photos.store')}}" enctype="multipart/form-data">
    @endif

            <div class="form-group">
                <select id="album_id" name="album_id">
                    <option value="">Seleziona...</option>
                    @foreach($albums as $item)
                        <option value="{{$item->id}}"> {{--  {{$item->id==$album->id?"selected":""}} --}}
                            {{$item->album_name}}
                        </option>
                    @endforeach
                </select>
                {{-- $item->album E' PROPRIETA' MA IN AUTOMATICO CHIAMA IL METODO album() GRAZIE AI MAGIC-METH --}}

            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$photo->name}}"
                       required placeholder="Image name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"
                          required>{{$photo->description}}</textarea>
            </div>
            {{--<input type="hidden" name="album_id" value="{{$photo->album_id ? $photo->album_id : $album->id}}">--}}

            @csrf
            @include('images.partials.fileupload')
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
@stop


