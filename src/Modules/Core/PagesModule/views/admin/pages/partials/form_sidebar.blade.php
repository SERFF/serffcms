{!! $sidebar_form_view !!}

<div class="box box-info">
    <div class="box-header">
        <strong>Publiceren</strong>
    </div>
    <div class="box-body">
        <p>Status:</p>
        @if((array_get($page, 'status') == 'DRAFT') || ($method == 'create'))
        <a href="javascript:draft()" class="btn btn-default">Opslaan als concept</a>
        @endif
        <a href="javascript:publish()" class="btn btn-primary pull-right">Publiceren</a>
    </div>
</div>

@section('scripts')
    @parent
    
    <script>
        var type = 'PUBLISHED';
        function publish()
        {
            type = 'PUBLISHED';
            submitForm();
        }
        
        function draft()
        {
            type = 'DRAFT';
            submitForm();
        }
        
        function submitForm()
        {
            var form = $('#pageform');
            form.find('#page_type').val(type);
            form.submit();
        }
    </script>
@endsection