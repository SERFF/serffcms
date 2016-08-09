@extends('layouts.app')

@section('htmlheader_title')
    Custom Fields Groep toevoegen
@endsection

@section('contentheader_title')
    Custom Fields Groep toevoegen
@endsection

@section('contentheader_description')
    Maak een Custom Fields Groep aan
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.customfields.store', 'method' => 'post', 'id' => 'customfieldsform']) !!}
    <div class="container-fluid spark-screen">
        @include('admin.customfields.partials.form')
    </div>
    {!! Form::close() !!}
@endsection
