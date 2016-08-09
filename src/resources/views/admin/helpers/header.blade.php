@if(Auth::user() !== null)
    <link rel="stylesheet" href="/css/sweetalert.css" type="text/css">
    <link rel="stylesheet" href="/css/serffcms.css" type="text/css">
    <link href="{{ asset('/plugins/redactor/redactor.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/plugins/jqueryModal/jquery.modal.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView::getWysiwygCssRoute() }}" type="text/css">
@endif