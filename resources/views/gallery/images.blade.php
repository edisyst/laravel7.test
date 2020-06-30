@extends('templates.layout')

@section('content')

    <br>
    <div class="row">
        @foreach($images as $item)
            <div class="col-md-4 col-lg-2 col-sm-6">
                <a href="{{asset($item->img_path)}}" data-lightbox="{{$album->album_name}}">
                    <img class="img-fluid img-thumbnail" src="{{asset($item->img_path)}}" alt="{{$item->name}}">
                </a>
{{--
                <div class="card-body">
                    <a href="{{route('gallery.album.images', $item->id)}}">
                        <h5 class="card-title">{{$item->name}}</h5>
                    </a>
                    <p class="card-text">{{$item->description}}</p>
                    <p class="card-text"><small class="text-muted">{{$item->created_at->diffForHumans()}}</small></p>
                </div>
--}}
            </div>
        @endforeach
    </div>


@endsection


