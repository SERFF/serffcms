@extends('layouts.app')

@section('htmlheader_title')
    Categoriën Overzicht
@endsection

@section('contentheader_title')
    Categoriën Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle Categoriën -
    <a href="{{ route('admin.products.categories.create') }}" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Nieuw</a>
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
                                <th>Aanmaak datum</th>
                                <th>Update datum</th>
                                <th>-</th>
                            </tr>

                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>{{ $category->updated_at->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.products.categories.edit', ['id' => array_get($category, 'id')]) }}"><i
                                                    class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('admin.products.categories.delete', ['id' => array_get($category, 'id')]) }}"><i
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
