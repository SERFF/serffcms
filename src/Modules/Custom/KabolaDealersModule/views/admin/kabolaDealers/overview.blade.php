@extends('layouts.app')

@section('htmlheader_title')
    Dealer Overzicht
@endsection

@section('contentheader_title')
    Dealer Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle Kabola Dealers
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
                                <th>Straat</th>
                                <th>Postcode</th>
                                <th>Plaats</th>
                                <th>Land</th>
                                <th>Aanmaakdatum</th>
                                <th>Datum laatste wijziging</th>
                                <th>-</th>
                            </tr>

                            @foreach($dealers as $dealer)
                                <tr>
                                    <td>{{ array_get($dealer, 'name') }}</td>
                                    <td>{{ array_get($dealer, 'street') }}</td>
                                    <td>{{ array_get($dealer, 'postcode') }}</td>
                                    <td>{{ array_get($dealer, 'city') }}</td>
                                    <td>{{ array_get($dealer, 'country') }}</td>
                                    <td>{{ array_get($dealer, 'created_at')->format('H:i:s d-m-Y') }}</td>
                                    <td>{{ array_get($dealer, 'updated_at')->format('H:i:s d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.kabola_dealers.edit', ['id' => array_get($dealer, 'id')]) }}"><i
                                                    class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.kabola_dealers.delete', ['id' => array_get($dealer, 'id')]) }}"
                                           class="pull-right"><i class="fa fa-trash"></i></a>
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
