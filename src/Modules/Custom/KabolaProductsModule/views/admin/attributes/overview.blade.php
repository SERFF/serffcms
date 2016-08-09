@extends('layouts.app')

@section('htmlheader_title')
    Attributen Overzicht
@endsection

@section('contentheader_title')
    Attributen Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle Attributen - 
    <a href="{{ route('admin.products.attributes.create') }}" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Nieuw</a>
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>Naam</th>
                                <th>Label</th>
                                <th>Type</th>
                                <th>Aanmaak datum</th>
                                <th>Update datum</th>
                                <th>-</th>
                            </tr>

                            @foreach($attributes as $attribute)
                                <tr>
                                    <td>{{ $attribute->id }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>{{ $attribute->label }}</td>
                                    <td>{{ $attribute->type }}</td>
                                    <td>{{ $attribute->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>{{ $attribute->updated_at->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.attributes.edit', ['id' => array_get($attribute, 'id')]) }}"><i
                                                    class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
