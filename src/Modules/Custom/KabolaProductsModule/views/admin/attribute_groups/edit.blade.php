@extends('layouts.app')

@section('htmlheader_title')
    Attribuut Groep Wijzigen
@endsection

@section('contentheader_title')
    Attribuut Groep Wijzigen
@endsection

@section('contentheader_description')
    Wijzig een attribuut groep
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.products.attributes.groups.store', 'method' => 'post', 'id' => 'attributegroupform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.attribute_groups.partials.form')
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box box-info">
                    <div class="box-body">
                        {!! Form::hidden('attribute_group_id', array_get($group, 'id')) !!}
                        {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
