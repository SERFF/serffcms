@extends('layouts.app')

@section('htmlheader_title')
    Product verzoek #{{ $request->id }}
@endsection

@section('contentheader_title')
    Product verzoek #{{ $request->id }}
@endsection

@section('contentheader_description')
    Product verzoek #{{ $request->id }}
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>Email</th>
                                <td>{{ $request->email }}</td>
                            </tr>
                            <tr>
                                <th>Telefoon</th>
                                <td>{{ $request->phone}}</td>
                            </tr>

                            <tr>
                                <th>Verzoek</th>
                                <td>{!! $request->message !!}</td>
                            </tr>
                            </tbody>
                        </table>
                        
                        <a href="{{ route('admin.tailormade.requests') }}" class="btn btn-info">Terug naar overzicht</a>
                        @if($request->handled == false)
                            <a href="{{ route('admin.tailormade.requests.handle', ['id' => $request->id]) }}" class="btn btn-success pull-right">Markeer als behandeld</a>
                        @else
                            <a href="{{ route('admin.tailormade.requests.handle', ['id' => $request->id]) }}" class="btn btn-default pull-right">Markeer als NIET behandeld</a>
                        @endif
                        
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
