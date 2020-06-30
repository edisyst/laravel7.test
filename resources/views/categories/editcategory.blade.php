@extends('templates.layout')

@section('content')
    <div class="row">
        <div class="col-8 push-4">
            <h2>{{!isset($category->category_name)?'Nuova categoria':'Modifica categoria'}}</h2>
            @include('categories.categoryform')
        </div>
    </div>
@endsection
