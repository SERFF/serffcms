@extends('layouts.app')

@section('htmlheader_title')
    Product Overzicht
@endsection

@section('contentheader_title')
    Product Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle producten
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
                                <th>Type</th>
                                <th>Aanmaak datum</th>
                                <th>Update datum</th>
                                <th>-</th>
                            </tr>

                            @foreach($products as $product)
                                <tr>
                                    <td>{{ array_get($product, 'id') }}</td>
                                    <td>{{ array_get($product, 'name') }}</td>
                                    <td>{{ array_get($product, 'type') }}</td>
                                    <td>{{ array_get($product, 'created_at')->format('H:i:s d-m-Y') }}</td>
                                    <td>{{ array_get($product, 'updated_at')->format('H:i:s d-m-Y') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', ['id' => array_get($product, 'id')]) }}"><i
                                                    class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('admin.products.delete', ['id' => array_get($product, 'id')]) }}"><i
                                                    class="fa fa-trash"></i></a>
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
