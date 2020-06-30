@extends('templates.layout') {{--SI USA IL PUNTO, NON IL /--}}

@section('content')

    @include('partials.inputerror')

    <div class="row">
        <div class="col-8">
            <table class="table table-striped" id="categoryList">
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Created date</th>
                    <th>Number of albums</th>
                    <th>Azioni</th>
                </tr>

                @forelse($categories as $categoryIndex)
                    <tr id="tr-{{$categoryIndex->id}}">
                        <td>{{$categoryIndex->id}}</td>
                        <td id="td-{{$categoryIndex->id}}">{{$categoryIndex->category_name}}</td>
                        <td>{{$categoryIndex->created_at}}</td>
                        <td>{{$categoryIndex->albums_count}}</td>
                        <td>
                            <form method="post" action="{{route('categories.destroy', $categoryIndex->id)}}">
                                @method('DELETE')
                                @csrf
                                <button id="btnDelete-{{$categoryIndex->id}}" class="btn btn-danger" title="DELETE">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <a href="{{route('categories.edit', $categoryIndex->id)}}" class="btn btn-info"
                                   id="update-{{$categoryIndex->id}}" title="EDIT">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tfoot>
                        <tr>
                            <td colspan="5">No categories</td>
                        </tr>
                    </tfoot>
                @endforelse
            </table>

            <div class="row">
                <div class="col-md-8 push-2">
                    {{$categories->links('vendor.pagination.bootstrap-4')}} {{--PAGINAZIONE--}}
                </div>
            </div>

        </div>  {{--END DIV SINISTRO--}}

        <div class="col-4">
            <h2><a href="{{route('categories.create')}}">Add Category</a></h2>
            @include('categories.categoryform')
        </div>
    </div>
@endsection


@section('footer')
    @parent
    <script>
        $(document).ready(function() {

            //ELIMINA CATEGORY
            $('form .btn-danger').on('click', function(event) {
                event.preventDefault(); //SENNO' IL PULSANTE INVIA IL FORM E MI RICARICA TUTTO

                var f = this.parentNode;
                var idCategory = this.id.replace('btnDelete-','')*1;//RESTA SOLO L'ID
                var trID = 'tr-' + idCategory; //id="tr-12"
                var urlCategory = f.action;
                // console.log(f.action);
                // return false;

                $.ajax(
                    urlCategory,
                    {
                        method: 'DELETE',
                        data: { '_token' : Laravel.csrfToken },
                        complete: function (risposta) {
                            // console.log(risposta.responseText);
                            var risposta = JSON.parse(risposta.responseText);
                            // console.log(risposta.responseText);

                            // if(risposta.success){ //VEDI SU CategoryController@destroy
                            //
                            // } else {
                            //     alert('Errore contattando il SERVER');
                            // }

                            alert(risposta.message);
                            $('#' + trID).remove(); //.fadeOut( "slow");
                        }
                    });
                return false;
            });

            //AGGIUNGI CATEGORY
            $('#manageCategoryForm .btn-primary').on('click', function(event) {
                event.preventDefault(); //SENNO' IL PULSANTE INVIA IL FORM E MI RICARICA TUTTO

                var f = $('#manageCategoryForm');
                var data = f.serialize();   //MI DA' TUTTI I DATI DEL FORM
                // console.log(data);
                // console.log(f.attr('action'));
                var urlCategory = f.attr('action');
                // return false;

                $.ajax(
                    urlCategory,
                    {
                        method: 'POST',
                        // data: { '_token' : Laravel.csrfToken },
                        data : data, //TUTTI I DATI DEL FORM, _token COMPRESO
                        complete: function (risposta) {
                            // console.log(risposta.responseText);
                            var risposta = JSON.parse(risposta.responseText);
                            alert(risposta.message);
                            f[0].reset();
                            f[0].category_name.value = '';

                            //L'AGGIUNTA DELL'HTML NON E' BANALE
                        }
                    });
                return false;
            });

            //MODIFICA CATEGORY
            $('#categoryList').on('click', 'a.btn-info', function(event) {
                event.preventDefault(); //SENNO' IL PULSANTE INVIA IL FORM E MI RICARICA TUTTO

                var idCategory = this.id.replace('update-','')*1;//RESTA SOLO L'ID
                var categoryTR = $('#tr-' + idCategory);
                $('#manageCategoryForm tr').css('border', '0px');
                categoryTR.css('border', '2px solid red');

                var urlUpdate = this.href.replace('/edit','');
                var categoryTD = $('#td-' + idCategory);
                var categoryName = categoryTD.text();


                var f = $('#manageCategoryForm');
                // console.log(f);
                f.attr('action', urlUpdate);
                f[0].category_name.value = categoryName;
                f[0].category_name.addEventListener('keyup', function() {
                    categoryTD.html(f[0].category_name.value);
                });

                var input   = document.createElement('input');
                input.type  = 'hidden';
                input.name  = '_method';
                input.value = 'PATCH';
                f[0].appendChild(input);
                console.log(f);

                return false;

                // var data = f.serialize();   //MI DA' TUTTI I DATI DEL FORM
                // console.log(data);
                // console.log(f.attr('action'));
                // var urlCategory = f.attr('action');
                // return false;

            });
        });



    </script>
@endsection