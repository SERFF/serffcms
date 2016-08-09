@extends('layouts.app')

@section('htmlheader_title')
    Pagina Overzicht
@endsection

@section('contentheader_title')
    Pagina Overzicht
@endsection

@section('contentheader_description')
    Overzicht van alle pagina's in het CMS
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
                                @foreach($display_fields as $display_field)
                                    <th>{{ array_get($display_field, 'label') }}</th>
                                @endforeach
                                <th>-</th>
                            </tr>

                            @foreach($pages as $page)
                                <tr>
                                    @foreach($display_fields as $display_field)
                                        <td>{{ array_get($page, array_get($display_field, 'key')) }}</td>
                                    @endforeach                                    
                                    <td>
                                        <a href="{{ route('admin.pages.edit', ['id' => array_get($page, 'id')]) }}"><i class="fa fa-edit"></i></a>
                                        <a target="_blank" href="{{ route('page', ['slug' => array_get($page, 'slug')]) }}"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.pages.delete', ['id' => array_get($page, 'id')]) }}" class="pull-right"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="box-body">
                        {!!  $paginator->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
