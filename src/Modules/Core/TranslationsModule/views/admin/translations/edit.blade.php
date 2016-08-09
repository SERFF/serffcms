@extends('layouts.app')

@section('htmlheader_title')
    Vertaling wijzigen
@endsection

@section('contentheader_title')
    Vertaling wijzigen
@endsection

@section('contentheader_description')
    Wijzig een vertaling
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.translations.store', 'method' => 'post', 'id' => 'translationform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.translations.partials.form')
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-info">
                    <div class="box-body">
                        {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::hidden('id', array_get($translation, 'id')) !!}
    {!! Form::close() !!}
@endsection
