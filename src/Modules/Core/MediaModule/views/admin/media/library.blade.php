@extends('layouts.app')

@section('htmlheader_title')
    Media Bibliotheek
@endsection

@section('contentheader_title')
    Media Bibliotheek
@endsection

@section('contentheader_description')
    Beheer alle bestanden binnen het CMS
@endsection

@section('header.scripts')
    @parent
    <link href="{{ asset('/css/library.css') }}" rel="stylesheet" type="text/css"/>
@append

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-body">

                        <div class="media-library">
                            @foreach ($media as $item)
                                <div class="col-md-1 vertical-center image-library-container">
                                    <input type="hidden" name="title" value="{{ array_get($item, 'title') }}"
                                           id="media-title">
                                    <input type="hidden" name="image" value="{{ route('media.view', ['id' => array_get($item, 'id'),
                                    'name' => array_get($item, 'original_name'),
                                    'width' => array_get($item, 'image.width'),
                                    'height' => array_get($item, 'image.height'),
                                ]) }}" id="media-image">
                                    <img src="{{ route('media.view', ['id' => array_get($item, 'id'),
                                    'name' => array_get($item, 'original_name'),
                                    'width' => array_get($item, 'thumbnail.width'),
                                    'height' => array_get($item, 'thumbnail.height'),
                                ]) }}"
                                         alt="{{ array_get($item, 'title') }}" class="img-responsive">
                                    <div class="library-overlay">
                                        <div class="library-overlay-options">
                                            <a href="{{ route('admin.media.delete', ['id' => array_get($item, 'id')]) }}"><i
                                                        class="fa fa-trash"></i></a>
                                            <i class="fa fa-search pull-right"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mediaModalLabel"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/" id="mediaModalImage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('/js/medialibrary.js') }}"></script>
@append
