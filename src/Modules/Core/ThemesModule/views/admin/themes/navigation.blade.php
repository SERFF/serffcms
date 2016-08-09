@extends('layouts.app')

@section('htmlheader_title')
    Navigatie / Menu instellingen
@endsection

@section('contentheader_title')
    Navigatie / Menu instellingen
@endsection

@section('contentheader_description')
    Stel het menu in
@endsection

@section('header.scripts')
    @parent
    <link href="{{ asset('/css/navigation.css')}}" rel="stylesheet" type="text/css"/>
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            {!! Form::open(['route' => 'admin.theme.store_navigation', 'method' => 'post']) !!}
            <div class="col-md-10">
                @include('admin.themes.partials.navigation.homepage')
                @include('admin.themes.partials.navigation.add_item')
                @include('admin.themes.partials.navigation.item_handler')
            </div>
            <div class="col-md-2">
                {!! $sidebar_form_views !!}
                <div class="box box-info">
                    <div class="box-body">
                        <div class="col-md-12">
                            {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function () {
            initTrash();
            $("#itemsWrapper").sortable();
            $("#itemsWrapper").disableSelection();

            $('#locale_select').on('change', function () {
                var new_locale = $(this).val();
                window.location.href = "{{ route('admin.theme.navigation') }}?locale=" + new_locale;
            });

            $('#addPage').on('click', function (e) {
                e.preventDefault();
                var item = $('#addpageSelect').find('option:selected');
                $('#itemsWrapper').append(
                        '<li id="' + item.val() + '"><div class="input-group"><div class="input-group-btn"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> </button></div><input class="form-control" name="item_' + item.val() + '" type="text" value="' + item.text() + '"></div></li>'
                );
                initTrash();
            });
        })

        function initTrash() {
            $('.btn-danger').each(function () {
                $(this).unbind('click');
                $(this).on('click', function (e) {
                    e.preventDefault();
                    $(this).closest('li').remove();
                });
            });
        }
    </script>
@endsection