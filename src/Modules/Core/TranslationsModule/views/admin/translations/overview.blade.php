@extends('layouts.app')

@section('htmlheader_title')
    Vertaaloverzicht
@endsection

@section('contentheader_title')
    Vertaaloverzicht
@endsection

@section('contentheader_description')
    Overzicht van alle vertalingen
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-9">
                <div class="box box-info">

                    <div class="box-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Locale</th>
                                <th>Name</th>
                                <th>Value</th>
                                <th>-</th>
                            </tr>
                            @foreach($translations as $translation)
                                <tr>
                                    <td>{{ $translation->id }}</td>
                                    <td>{{ $translation->locale }}</td>
                                    <td>{{ $translation->key }}</td>
                                    <td>{{ $translation->value }}</td>
                                    <td><a href="{{ route('admin.translations.edit', ['id' => $translation->id]) }}"><i class="fa fa-edit"></i></a> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $translations->links() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-info">
                    <div class="box-header">
                        <strong>Filter</strong>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => 'admin.translation.overview', 'method' => 'get']) !!}
                        <div class="form-group">
                            <label for="searcher">Zoeken</label>
                            {!! Form::input('text', 'query', array_get($query, 'query'), [
                            'id' => 'searcher', 
                            'class' =>'form-control',
                            'placeholder' => 'Voer een zoekwoord in'
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <label for="locales">Taal</label>
                            <hr/>
                            @foreach($locales as $locale => $item)
                                <div>
                                    {!! Form::checkbox('locale[]', $locale, in_array($locale, array_get($query, 'locales', [])), ['id' => 'checkbox_' . $locale]) !!}
                                    {!! Form::label('checkbox_' . $locale, array_get($item, 'label'), ['for' => 'checkbox_' . $locale]) !!}
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="groups">Groepen</label>
                            <hr/>
                            @foreach($groups as $id => $name)
                                <div>
                                    {!! Form::checkbox('group[]', $id, in_array($id, array_get($query, 'group')), ['id' => 'group_' . $id]) !!}
                                    {!! Form::label('group_'.$id, $name, ['for' => 'group_'.$id]) !!}
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Filter', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
