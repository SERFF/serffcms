@extends('layouts.app')

@section('htmlheader_title')
    Custom Fields Groep wijzigen
@endsection

@section('contentheader_title')
    Custom Fields Groep wijzigen
@endsection

@section('contentheader_description')
    Wijzig een Custom Fields Groep
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.customfields.store', 'method' => 'post', 'id' => 'customfieldsform']) !!}
    <div class="container-fluid spark-screen">
        @include('admin.customfields.partials.form')
    </div>
    {!! Form::hidden('group_id', array_get($group, 'id')) !!}
    {!! Form::close() !!}
@endsection
