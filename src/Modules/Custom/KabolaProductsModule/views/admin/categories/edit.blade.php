@extends('layouts.app')

@section('htmlheader_title')
    Categorie Wijzigen
@endsection

@section('contentheader_title')
    Categorie Wijzigen
@endsection

@section('contentheader_description')
    Wijzig een categorie
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.products.categories.store', 'method' => 'post', 'id' => 'categoriesform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.categories.partials.form')
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-info">
                    <div class="box-body">
                        {!! Form::hidden('category_id', array_get($category, 'id')) !!}
                        {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
