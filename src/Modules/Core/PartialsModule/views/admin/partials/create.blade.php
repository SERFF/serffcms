@extends('layouts.app')

@section('htmlheader_title')
    Deelpagina Toevoegen
@endsection

@section('contentheader_title')
    Deelpagina Toevoegen
@endsection

@section('contentheader_description')
    Maak een nieuwe deelpagina aan
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.partials.store', 'method' => 'post', 'id' => 'partialform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.partials.partials.form')
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                {!! $sidebar_form_view !!}
                <div class="box box-info">
                    <div class="box-body">
                        {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
