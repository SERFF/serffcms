@extends('layouts.app')

@section('htmlheader_title')
    Overzicht product verzoeken
@endsection

@section('contentheader_title')
    Overzicht product verzoeken
@endsection

@section('contentheader_description')
    Overzicht van alle product verzoeken
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
                                <th>Email</th>
                                <th>Telefoon</th>
                                <th>Datum</th>
                                <th>Behandeld</th>
                                <th>-</th>
                            </tr>

                            @foreach($requests as $request)
                                <tr>
                                    <td>{{ $request->email }}</td>
                                    <td>{{ $request->phone }}</td>
                                    <td>{{ $request->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        @if($request->handled == false)
                                            <a href="{{ route('admin.tailormade.requests.handle', ['id' => $request->id]) }}"
                                               class="btn btn-sm btn-danger"><i class="fa fa-times"></i> </a>
                                        @else
                                            <a href="{{ route('admin.tailormade.requests.handle', ['id' => $request->id]) }}"
                                               class="btn btn-sm btn-default"><i class="fa fa-check"></i> </a>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('admin.tailormade.requests.view', ['id' => $request->id]) }}"
                                           class="btn btn-sm btn-primary"><span class="fa fa-eye"></span> </a>
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
