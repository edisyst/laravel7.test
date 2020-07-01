@extends('templates.layout')

@section('content')
    <h1>ALBUMS</h1>

    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif


    <p>Ogni sessione ha un token diverso: {{csrf_token()}}</p>

    <form>
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Album name</td>
                    <td>Thumb</td>
                    <td>Creator</td>
                    <td>Created date</td>
                    <td>Categories</td>
                    <td>Azioni</td>
                </tr>
            </thead>
            <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>{{$album->id}} {{$album->album_name}} <br>
                        ({{$album->photos_count}} images)
                    </td>
                    <td>
                        @if($album->album_thumb)
                            <div class="form-group">
                                <img width="120" src="{{asset($album->path)}}" alt="{{$album->album_name}}">
                            </div>
                        @endif
                    </td>
                    <td>{{$album->user->fullName}}</td>
                    <td>{{$album->created_at->format('l, d-M-Y H:i:s T')}}</td>
                    <td>
                        @if($album->categories->count())
                            <ul>
                                @foreach($album->categories as $category)
                                    <li>{{$category->category_name}} ({{$category->id}})</li>
                                @endforeach
                            </ul>
                        @else
                            No categories
                        @endif
                    </td>
                    <td>

                        <div class="row">
                            <div class="col-3"><a href="{{route('photos.create')}}?album_id={{$album->id}}" class="btn btn-info" title="add picture">
                                    <span class="fa fa-plus"></span>
                                </a>
                            </div>
                            <div class="col-3">
                                @if($album->photos_count)
                                    <a href="{{route('album.getimages', $album->id)}}" class="btn btn-success">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @else
                                    <i class="btn btn-default fas fa-eye"></i>
                                @endif
                            </div>
                            <div class="col-3">
                                <a href="{{route('album.edit', $album->id)}}" class="btn btn-primary">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                            <div class="col-3">
                                <a href="{{route('album.delete', $album->id)}}" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </form>
@endsection

@section('footer')
    @parent
    <script>

        $(document).ready(function() {
            $('td').on('click', 'a.btn-danger', function(element) {
                element.preventDefault();
                // alert(element.target.parentNode.parentNode.parentNode.parentNode);
                var urlAlbum = $(this).attr('href');
                var tr = element.target.parentNode.parentNode.parentNode.parentNode;
                $.ajax(urlAlbum, {
                    method: 'DELETE',
                    //DEVO TROVARE UN ALTRO MODO PER PASSARGLI IL CSRF, COSI' E' IN CHIARO
                    data: { '_token' : '{{csrf_token()}}' },
                    complete: function (resp) {
                        if(resp.responseText == 1){
                            $(tr).remove();
                        } else {
                            alert('Errore contattando il SERVER');
                        }
                    }
                });
            });
        });

    </script>
@endsection