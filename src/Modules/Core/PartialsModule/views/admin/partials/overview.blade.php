@extends('layouts.app')

@section('htmlheader_title')
    Deelpagina Overzicht
@endsection

@section('contentheader_title')
    Deelpagina Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle deelpagina's in het CMS
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
                                <th>Naam</th>
                                <th>Slug</th>
                                <th>Auteur</th>
                                <th>Taal</th>
                                <th>Aanmaakdatum</th>
                                <th>Wijzigingsdatum</th>
                                <th>-</th>
                            </tr>

                            @foreach($partials as $partial)
                                <tr>
                                    <td>{{ array_get($partial, 'name') }}</td>
                                    <td>{{ array_get($partial, 'slug') }}</td>
                                    <td>{{ get_username_by_id(array_get($partial, 'author_id')) }}</td>
                                    <td>{{ array_get($partial, 'locale') }}</td>
                                    <td>{{ array_get($partial, 'created_at')->format('H:i:s d-m-Y') }}</td>
                                    <td>{{ array_get($partial, 'updated_at')->format('H:i:s d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.partials.edit', ['id' => array_get($partial, 'id')]) }}"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.partials.delete', ['id' => array_get($partial, 'id')]) }}" class="pull-right"><i class="fa fa-trash"></i></a>
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
