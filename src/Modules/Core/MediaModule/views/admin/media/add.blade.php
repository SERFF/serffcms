@extends('layouts.app')

@section('htmlheader_title')
    Bestand toevoegen aan Media Bibliotheek
@endsection

@section('contentheader_title')
    Bestand toevoegen aan Media Bibliotheek
@endsection

@section('contentheader_description')
    Bestand toevoegen aan Media Bibliotheek
@endsection

@section('header.scripts')
    @parent
    <link href="{{ asset('/plugins/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css"/>
@append

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-body">
                        {!! Form::open(['route' => 'admin.media.upload', 'method' => 'post', 'class' => 'dropzone']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('/plugins/dropzone/dropzone.js') }}"></script>
@append
