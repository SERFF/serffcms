@extends('layouts.app')

@section('htmlheader_title')
    Attributen Groepen Overzicht
@endsection

@section('contentheader_title')
    Attributen Groepen Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle Attributen Groepen -
    <a href="{{ route('admin.products.attributes.groups.create') }}" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Nieuw</a>
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
                                <th>Attributen</th>
                                <th>Aanmaak datum</th>
                                <th>Update datum</th>
                                <th>-</th>
                            </tr>

                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group->id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->attributes()->count() }}</td>
                                    <td>{{ $group->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>{{ $group->updated_at->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.attributes.groups.edit', ['id' => array_get($group, 'id')]) }}"><i
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
