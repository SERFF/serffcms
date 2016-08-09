@section('header.scripts')
    @parent
    <link href="{{ asset('/css/products.css')}}" rel="stylesheet" type="text/css"/>
@endsection
<div class="form-group">
    <label for="name">Naam</label>
    {!! Form::text('name', array_get($product, 'name'), ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="type">Type</label>
    {!! Form::select('type', ['CV' => 'C.V.', 'BOILER' => 'Boiler', 'COMBI' => 'Combi'], array_get($product, 'type'), ['class' => 'form-control', 'id' => 'type']) !!}
</div>

<div class="form-group">
    <label for="category_id">Categorie</label>
    {!! Form::select('category_id', array_pluck($categories, 'name', 'id'), array_get($product, 'category_id'), ['class' => 'form-control', 'id' => 'category_id']) !!}
</div>
<hr/>
<h3 class="text-center">Attributen</h3>
@foreach(array_get($product, 'attributes', []) as $attribute)
    <div class="form-group">
        <label for="attr_{{array_get($attribute, 'id')}}">{{ array_get($attribute, 'label') }}</label>
        @php $list_value = array_get($attribute, 'prefilled_list_items', ''); @endphp
        @if(($list_value !== '') && ($list_value !== null))
        @php
        $tmpitems = explode('||', array_get($attribute, 'prefilled_list_items', ''));
        $preffiled_list_items = [];
        foreach($tmpitems as $tmpitem) {
            $preffiled_list_items[$tmpitem] = $tmpitem;
        }
        @endphp
        {!! Form::select('attr_'.array_get($attribute, 'id'), $preffiled_list_items, array_get($attribute, 'pivot.value'), ['class' => 'form-control', 'id' => 'attr_'.array_get($attribute, 'id')]) !!}    
        @else
        {!! Form::text('attr_'.array_get($attribute, 'id'), array_get($attribute, 'pivot.value'), ['class' => 'form-control', 'id' => 'attr_'.array_get($attribute, 'id')]) !!}
        @endif
    </div>
@endforeach



@section('scripts')
    @parent
    <script defer="defer">
        var GeneralRoutes = {
            image_route: "{{ route('media.view', ['id' => 'id', 'name' => 'name', 'width' => 'width', 'height' => 'height']) }}",
            modal_route: "{{ route('admin.customfields.ajax.gallery_modal') }}",
            media_library_route: "{{ route('admin.media.images.json') }}"
        };
    </script>
    <script src="{{ asset('/js/products.js') }}"></script>
@endsection