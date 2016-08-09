@extends('layouts.app')

@section('htmlheader_title')
    Overzicht van alle export's
@endsection

@section('contentheader_title')
    Overzicht van alle export's
@endsection

@section('contentheader_description')
    Overzicht van alle export's -
    <a href="{{ route('admin.import-export.export.create') }}" class="btn btn-sm btn-primary"><span
                class="fa fa-plus"></span> Nieuw</a>
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
                                <th>Grootte</th>
                                <th>Aanmaak datum</th>
                                <th>-</th>
                            </tr>

                            @foreach($exports as $export)
                                <tr>
                                    <td>{{ array_get($export, 'name') }}</td>
                                    <td>{{ number_format(array_get($export, 'size', 1) / 1000 / 1000, 1 , ',', '.') }}
                                        Mb
                                    </td>
                                    <td>{{ date('d-m-Y H:i:s', array_get($export, 'created_at', time())) }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary"
                                           href="{{ route('admin.import-export.export.download', ['id' => array_get($export, 'fullname')]) }}">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a class="btn btn-sm btn-primary pull-right"
                                           href="{{ route('admin.import-export.export.delete', ['id' => array_get($export, 'fullname')]) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
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
