@section('header.scripts')
    @parent
    <link href="{{ asset('/plugins/redactor/redactor.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ $wysiwyg_css }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/products.css')}}" rel="stylesheet" type="text/css"/>
@endsection
<div class="form-group">
    <label for="name">Naam</label>
    {!! Form::text('name', array_get($category, 'name'), ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="title">Titel</label>
    {!! Form::text('title', array_get($category, 'title'), ['class' => 'form-control', 'id' => 'title']) !!}
</div>

<div class="form-group">
    <label for="importance">Extra zoekwaarde (bij hoger getal, hoger in de zoekresultaten)</label>
    {!! Form::number('importance', array_get($category, 'importance'), ['class' => 'form-control', 'id' => 'importance']) !!}
</div>

<div class="form-group">
    <label for="product_image">Product Afbeelding</label>
    {!! Form::text('product_image', array_get($category, 'product_image'), ['class' => 'form-control', 'id' => 'product_image', 'cf_type' => 'image']) !!}
</div>

<div class="form-group">
    <label for="intro_text">Intro Tekst</label>
    {!! Form::textarea('intro_text', array_get($category, 'intro_text'), ['class' => 'form-control', 'id' => 'intro_text']) !!}
</div>

<div class="form-group">
    <label for="overview_preview_text">Product Overzicht Tekst</label>
    {!! Form::textarea('overview_preview_text', array_get($category, 'overview_preview_text'), ['class' => 'form-control', 'id' => 'overview_preview_text']) !!}
</div>

<div class="form-group">
    <label for="product_content">Product Tekst</label>
    {!! Form::textarea('product_content', array_get($category, 'product_content'), ['class' => 'form-control', 'id' => 'product_content']) !!}
</div>

<div class="form-group">
    <label for="product_gallery">Product Gallerij</label>
    {!! Form::text('product_gallery', array_get($category, 'product_gallery'), ['class' => 'form-control', 'id' => 'product_gallery', 'cf_type' => 'gallery']) !!}
</div>

<div class="form-group">
    <label for="attribute_groups">Attribuut groepen</label>
    {!! Form::select('attribute_groups[]', array_pluck($attribute_groups, 'name', 'id'), array_pluck($selected_attribute_groups, 'id'), ['class' => 'form-control select2element', 'multiple' => 'multiple']) !!}
</div>

<div class="form-group">
    <label for="style_class">Style class</label>
    {!! Form::text('style_class', array_get($category, 'style_class'), ['class' => 'form-control', 'id' => 'style_class']) !!}
</div>

@section('scripts')
    @parent
    <script src="{{ asset('/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/redactor.min.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/imagemanager.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/source.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/table.js') }}"></script>
    <script defer="defer">
        var GeneralRoutes = {
            image_route: "{{ route('media.view', ['id' => 'id', 'name' => 'name', 'width' => 'width', 'height' => 'height']) }}",
            modal_route: "{{ route('admin.customfields.ajax.gallery_modal') }}",
            media_library_route: "{{ route('admin.media.images.json') }}"
        };

        $(function () {

            $('#product_content, #intro_text, #overview_preview_text').redactor(
                    {
                        imageUpload: '{{ route('admin.media.upload') }}',
                        imageManagerJson: '{{ route('admin.media.images.json') }}',
                        plugins: ['imagemanager', 'source', 'table'],
                        imageEditable: true,
                        imageResizable: true,
                        replaceTags: false
                    }
            );

            $('.select2element').each(function () {
                $(this).select2();
            });
        });
    </script>
    <script src="{{ asset('/js/products.js') }}"></script>
@endsection