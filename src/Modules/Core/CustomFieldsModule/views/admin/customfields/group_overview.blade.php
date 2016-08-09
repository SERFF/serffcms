@extends('layouts.app')

@section('htmlheader_title')
    Custom Fields Groep toevoegen
@endsection

@section('contentheader_title')
    Custom Fields Groep toevoegen
@endsection

@section('contentheader_description')
    Maak een Custom Fields Groep aan
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <strong>Velden</strong>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped no-padding">
                            <tr>
                                <th>Naam</th>
                                <th>Status</th>
                                <th>Aangemaakt</th>
                                <th>Laatste Update</th>
                                <th>-</th>
                            </tr>
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->status }}</td>
                                    <td>{{ $group->created_at->format('H:i:s d-m-Y') }}</td>
                                    <td>{{ $group->updated_at->format('H:i:s d-m-Y') }}</td>
                                    <td><a href="{{ route('admin.customfields.edit_group', ['id' => $group->id]) }}"><i
                                                    class="fa fa-edit"></i> </a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
