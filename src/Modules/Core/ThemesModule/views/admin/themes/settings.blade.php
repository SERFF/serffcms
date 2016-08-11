@extends('layouts.app')

@section('htmlheader_title')
    Thema instellingen
@endsection

@section('contentheader_title')
    Thema instellingen
@endsection

@section('contentheader_description')
    Stel het thema in
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <div class="box-header">
                        <a href="{{ route('admin.theme.find') }}" class="btn btn-sm btn-primary pull-right">Find Themes</a>
                    </div>
                    <div class="box-body">
                        @foreach($themes as $theme)
                            @if(array_get($theme, 'hidden')) @php continue; @endphp @endif
                            <div class="col-md-3">
                                <div class="box box-widget widget-user">
                                    <div class="widget-user-header bg-black" style="background: url('{{ array_get($theme, 'screenshot') }}') center center;">
                                        <h3 class="widget-user-username">{{ array_get($theme, 'name') }}</h3>
                                        <h5 class="widget-user-desc">{{ array_get($theme, 'author') }}</h5>
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle" src="{{ array_get($theme, 'author_image') }}" alt="{{ array_get($theme, 'author') }}">
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-sm-12">
                                                <div class="description-block">
                                                    <h5 class="description-header">{{ array_get($theme, 'name') }}</h5>
                                                    <span class="description-text">{{ array_get($theme, 'description') }}</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                                
                                <h1>{{ array_get($theme, 'name') }}</h1>
                                @if(array_get($theme, 'active'))
                                    <strong>Actief</strong>
                                @else
                                    {!! Form::open(['route' => 'admin.theme.activate', 'method' =>'post']) !!}
                                
                                    {!! Form::hidden('theme', array_get($theme, 'class')) !!}
                                    {!! Form::submit('Activeren', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
