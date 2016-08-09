@if(Auth::user() !== null)
    @include('admin.helpers.page_update_modal')
    <script src="{{ asset('/plugins/redactor/redactor.min.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/imagemanager.js') }}"></script>
    <script src="{{ asset('/plugins/redactor/plugins/source.js') }}"></script>
    <script src="{{ asset('/plugins/jqueryModal/jquery.modal.min.js') }}"></script>
    <script defer="defer">
        $(function () {
            $('#editor-content').redactor({
                minHeight: 600,
                imageUpload: '{{ route('admin.media.upload') }}',
                imageManagerJson: '{{ route('admin.media.images.json') }}',
                plugins: ['imagemanager', 'source']
            });
        });
    </script>
    <script>
        var GENERAL_SETTINGS = {
            locale: "<?php echo app()->getLocale() ?>"
        };
        var TRANSLATION_SETTINGS = {
            enabled: "{{ translateEnabled() }}"
        };
        var TranslationRoutes = {
            translationUrl: '{{ route('translation.ajax.update')  }}',
            translationToggle: '{{ route('translation.toggle') }}',
            translationGet: '{{ route('translation.get_value') }}'
        };
        var PagesRoutes = {
            valueGet: '{{ route('admin.pages.ajax.getContent') }}',
            currentPage: @if(isset($page)) {{ array_get($page, 'id') }} @else '' @endif,
            editPageRoute: '@if(isset($page)) {{ route('admin.pages.edit', ['id' => array_get($page, 'id')])  }} @endif',
            updateUrl: '{{ route('admin.pages.ajax.updateContent') }}'
        }
    </script>
    <script src="/js/sweetalert.min.js"></script>
    <script src="/js/serffcms.js"></script>
@endif