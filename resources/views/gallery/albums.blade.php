@extends('templates.layout')

@section('content')

<br>
<div class="card-columns">
    @foreach($albums as $album)
        <div class="card">
            <a href="{{route('gallery.album.images', $album->id)}}">
                <img  class="card-img-top" src="{{asset($album->album_thumb)}}" alt="{{$album->album_name}}">
            </a>
            <div class="card-body">
                <a href="{{route('gallery.album.images', $album->id)}}">
                    <h5 class="card-title">{{$album->album_name}}</h5>
                </a>

                {{-- $album->categories EQUIVALE A $album->categories()->get() --}}
                <p class="card-text">
                    Categories:
                    @foreach($album->categories as $category)
                        <a href="{{route('gallery.album.category', $category->id)}}">{{$category->category_name}}</a>
                    @endforeach

                </p>
                <p class="card-text"><small class="text-muted">{{$album->created_at->diffForHumans()}}</small></p>
            </div>
        </div>
    @endforeach
</div>


@endsection


