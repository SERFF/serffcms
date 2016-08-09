@section('header.scripts')
    @parent
    <link href="{{ asset('/plugins/redactor/redactor.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ $wysiwyg_css }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/pages.css')}}" rel="stylesheet" type="text/css"/>
@endsection

<div class="form-group">
    <label for="title">Titel</label>
    {!! Form::text('title', array_get($page, 'title'), ['class' => 'form-control', 'id' => 'title']) !!}
</div>
@if($method !== 'create')
    <div class="form-group">
        <label for="slug">Permalink</label>
        {!! Form::text('slug', array_get($page, 'slug'), ['class' => 'form-control', 'id' => 'slug']) !!}
    </div>
@endif

<div class="form-group">
    <label for="content">Content</label>
    {!! Form::textarea('content', array_get($page, 'content'), ['id' => 'content', 'rows' => 40, 'cols' => 80]) !!}
</div>

{!! Form::hidden('status', array_get($page, 'status', 'PUBLISH'), ['id' => 'page_type']) !!}
{!! Form::hidden('page_id', array_get($page, 'id', null)) !!}
{!! Form::hidden('method', $method) !!}

{!! $main_form_view !!}


@section('scripts')
    @parent
    <script src="{{ asset('/plugins/select2/select2.min.js') }}"></script>
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
            var scripts = [];
            $('.extrascript').each(function () {
                array_add_unique(scripts, $(this).val());
            });

            for (i = 0; i < scripts.length; i++) {
                $.getScript(scripts[i]);
            }

            $('.select2element').each(function () {
                $(this).select2();
            });


        });

        function array_add_unique(array, value) {
            if (!in_array(array, value)) {
                array[array.length] = value;
            }
            return array;
        }

        function in_array(array, value) {
            found = false;
            for (i = 0; i < array.length; i++) {
                if (array[i] == value) {
                    found = true;
                }
            }
            return found;
        }

    </script>
@endsection