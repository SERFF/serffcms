@extends('layouts.app')

@section('htmlheader_title')
    Product Wijzigen
@endsection

@section('contentheader_title')
    Product Wijzigen
@endsection

@section('contentheader_description')
    Wijzig product eigenschappen
@endsection


@section('main-content')
    {!! Form::open(['route' => 'admin.products.store', 'method' => 'post', 'id' => 'productform']) !!}
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-body">
                        @include('admin.products.partials.form')
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
    {!! Form::hidden('product_id', array_get($product, 'id')) !!}
    {!! Form::close() !!}
@endsection
