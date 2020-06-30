@extends('templates.admin')

@section('content')
    <h1>USERS</h1>

    <table class="table table-striped" id="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>ROLE</th>
                <th>EMAIL</th>
                <th>CREATED AT</th>
                <th>DELETED</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
{{--
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->email }}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$user->deleted_at}}</td>
                    <td>
                        <div class="row">
                            <div class="col-4">
                                <button
                                        @if($user->deleted_at)
                                            disable
                                        @else
                                        @endif

                                        class="btn btn-info" title="UPDATE">
                                    <i class="far fa-edit"></i>
                                </button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-danger btn-sm" title="DELETE">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-danger" title="FORCEDELETE">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
--}}
        </tbody>
    </table>
@endsection


@section('footer')
    @parent
    <script>

        //LA ESEGUE QUANDO IL DOM E' PRONTO: EQUIVALE A:
        //$(document).ready(function(){...
        $(function () {

            //NON LA POSSO DICHIARARE 2 VOLTE NEL DOM: COMMENTO LA DICHIARAZIONE NEL FILE.js
            var tabella = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.getUsers')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'role'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created'},
                    {data: 'deleted_at', name: 'deleted'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#dataTable').on('click', '.my-ajax', function(element) {
                element.preventDefault();

                if(!confirm('Do you really want to delete this record')){
                    return false;
                }

                var urlUsers = $(this).attr('href');
//                alert(urlUsers);
//                return;

                var tr = this.parentNode.parentNode;
                $.ajax(urlUsers, {
                    // method: 'DELETE',
                    method: this.id.startsWith('delete') ? 'DELETE' : 'PATCH',
                    data: { '_token' : window.Laravel.csrfToken },

                    complete: function (resp) {
                        console.log(resp);

                        if(resp.responseText == 1){
                            if(urlUsers.endsWith('hard=1')){
                                tr.parentNode.removeChild(tr); //RIMUOVO TR DALLA TABELLA
                            }
                            tabella.ajax.reload();
                            alert('User eliminato correttamente');

                        } else {
                            alert(resp.responseText);
                        }
                    }
                });
            });

        }); //END FUNZIONE ANONIMA

    </script>
@endsection
