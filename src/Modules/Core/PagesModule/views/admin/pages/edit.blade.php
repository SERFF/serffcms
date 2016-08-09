@extends('layouts.app')

@section('htmlheader_title')
    Pagina Aanpassen
@endsection

@section('contentheader_title')
    Pagina Aanpassen
@endsection

@section('contentheader_description')
    Wijzig pagina
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.pages.store', 'method' => 'post', 'id' => 'pageform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.pages.partials.form')
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                @include('admin.pages.partials.form_sidebar')
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
