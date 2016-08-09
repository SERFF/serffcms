@extends('layouts.app')

@section('htmlheader_title')
    Attribuut Toevoegen
@endsection

@section('contentheader_title')
    Attribuut Toevoegen
@endsection

@section('contentheader_description')
    Maak een nieuw attribuut aan
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.products.attributes.store', 'method' => 'post', 'id' => 'attributeform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.attributes.partials.form')
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
    {!! Form::close() !!}
@endsection
