@section('header.scripts')
    @parent
    <link href="{{ asset('/plugins/redactor/redactor.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ $wysiwyg_css }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/pages.css')}}" rel="stylesheet" type="text/css"/>
@endsection

<div class="form-group">
    <label for="name">Naam</label>
    {!! Form::text('name', array_get($partial, 'name'), ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="content">Content</label>
    {!! Form::textarea('content', array_get($partial, 'content'), ['id' => 'content', 'rows' => 40, 'cols' => 80]) !!}
</div>

@section('scripts')
    @parent
    <script src="{{ asset('/plugins/redactor/redactor.min.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/imagemanager.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/source.js') }}"></script>
    <script defer="defer">

        var GeneralRoutes = {
            image_route: "{{ route('media.view', ['id' => 'id', 'name' => 'name', 'width' => 'width', 'height' => 'height']) }}",
            modal_route: "{{ route('admin.customfields.ajax.gallery_modal') }}",
            media_library_route: "{{ route('admin.media.images.json') }}"
        };

        $(function () {

            $('#content').redactor(
                    {
                        imageUpload: '{{ route('admin.media.upload') }}',
                        imageManagerJson: '{{ route('admin.media.images.json') }}',
                        plugins: ['imagemanager', 'source'],
                        imageEditable: true,
                        imageResizable: true,
                        replaceTags: false
                    }
            );
        });
    </script>
@endsection