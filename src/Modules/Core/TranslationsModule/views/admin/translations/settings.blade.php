@extends('layouts.app')

@section('htmlheader_title')
    Taalinstellingen
@endsection

@section('contentheader_title')
    Taalinstellingen
@endsection

@section('contentheader_description')
    Instellingen voor vertalingen en landen
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-body">
                        {!! Form::open(['route' => 'admin.translations.settings.save','method' => 'post']) !!}
                        <h4>In welke talen moet de website actief zijn?</h4>

                        @php $locale_list = []; @endphp
                        @foreach($locales as $locale => $item)
                            @php $locale_list[$locale] = array_get($item, 'label'); @endphp
                            <div class="form-group">
                                {!! Form::checkbox('locale[]', $locale, in_array($locale, $site_locales), ['id' => 'checkbox_' . $locale]) !!}
                                {!! Form::label('checkbox_' . $locale, array_get($item, 'label'), ['for' => 'checkbox_' . $locale]) !!}
                            </div>
                        @endforeach
                        <div class="form-group">
                            <h4>Wat is de standaard taal?
                                <small>De geselecteerde taal is automatisch actief</small>
                            </h4>
                            {!! Form::select('selected_locale', $locale_list, $selected_locale, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
