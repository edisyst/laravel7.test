@extends('templates.layout')

@section('content')
    <h1>IMAGES FOR {{$album->album_name}}</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>CREATED DATE</th>
            <th>TITLE</th>
            <th>ALBUM</th>
            <th>THUMBNAIL</th>
        </tr>

        @forelse($images as $image)
            <tr>
                <td>{{$image->id}}</td>
                <td>{{$image->created_at->diffForHumans()}}</td>
                <td>{{$image->name}}</td>
                <td>
                    <a href="{{route('album.edit', $image->album_id)}}">
                        {{$album->album_name}}
                    </a>
                </td>
                {{--<td>{{asset($image->img_path)}}</td>--}}
                <td><img width="150" src="{{asset($image->img_path)}}"></td>
                <td>
                    <a href="{{route('photos.edit', $image->id)}}" class="btn btn-primary">MODIFICA</a>
                    <a href="{{route('photos.destroy', $image->id)}}" class="btn btn-danger">DELETE</a>
                </td>

            </tr>
        @empty
            <tr><td colspan="5">Niente immagini trovate</td></tr>
        @endforelse

        <tr>
            <td colspan="6" class="align-content-center">
                {{$images->links('vendor.pagination.bootstrap-4')}}
            </td>
        </tr>

    </table>
@endsection


@section('footer')
    @parent
    <script>
        //NON FUNGE (vid.71): SERVIREBBE PER NON FARGLI RICARICARE LA PAGINA

        $('document').ready(function () {
            //$('div.alert').fadeOut(5000);

            $('table').on('click', 'a.btn-danger',function (ele) {
                ele.preventDefault(); //SERVE PER NON ANDARE SU QUELL'URL

                var urlImg = $(this).attr('href');
                var tr = ele.target.parentNode.parentNode;

                $.ajax(
                    urlImg,
                    {
                        method: 'DELETE',
                        data : {
                            '_token' : '{{csrf_token()}}'
                        },
                        complete : function (resp) {
                            console.log(resp);
                            if(resp.responseText == 1){
                                //  alert(resp.responseText)
                                tr.parentNode.removeChild(tr);
                                // $(li).remove();
                            } else {
                                alert('Problem contacting server');
                            }
                        }
                    }
                )
            });
        });


    </script>
@endsection