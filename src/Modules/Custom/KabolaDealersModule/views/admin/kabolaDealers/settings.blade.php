@extends('layouts.app')

@section('htmlheader_title')
    Kabola Dealer Instellingen
@endsection

@section('contentheader_title')
    Kabola Dealer Instellingen
@endsection

@section('contentheader_description')
    De instellingen voor het Kabola Dealer gedeelte
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.kabola_dealers.settings.store', 'method' => 'post', 'id' => 'dealer_settings_form']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.kabolaDealers.partials.settings_form')
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
