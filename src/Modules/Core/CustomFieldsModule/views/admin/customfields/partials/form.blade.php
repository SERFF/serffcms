@section('header.scripts')
    @parent
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="{{ asset('/css/customfields.css') }}" rel="stylesheet" type="text/css"/>

@endsection
<div class="col-md-10">
    <div class="row">
        @include('admin.customfields.partials.form_group')
        @include('admin.customfields.partials.form_inputs')
        @include('admin.customfields.partials.form_location')
    </div>
</div>
<div class="col-md-2">
    <div class="box box-info">
        <div class="box-body">
            {!! Form::submit('Opslaan', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script type="text/javascript">
        var CustomFieldsVars = {
            rules_values_route: "{{ route('admin.customerfields.ajax.rules_values') }}"
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('/js/customfields.js') }}"></script>
@endsection