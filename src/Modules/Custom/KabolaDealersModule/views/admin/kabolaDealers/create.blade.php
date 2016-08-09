@extends('layouts.app')

@section('htmlheader_title')
    Kabola Dealer Toevoegen
@endsection

@section('contentheader_title')
    Kabola Dealer Toevoegen
@endsection

@section('contentheader_description')
    Maak een nieuwe Kabola Dealer aan
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.kabola_dealers.store', 'method' => 'post', 'id' => 'dealerform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.kabolaDealers.partials.form')
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
