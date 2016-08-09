@php $id_name = str_slug(array_get($input, 'group.name')) . '_' . $input['name'];  @endphp
@php $key = str_slug(array_get($input, 'group.name')) . '.' . $input['name'];  @endphp
@php $value = get_cf_form_option($key, 'page', array_get($record, 'id'), array_get($input, 'type'), null); @endphp
<div class="form-group">
    <label for="{{ $id_name }}">{!! $input['label'] !!} </label>
    <small>{{ array_get($input, 'description') }}</small>
    {!! Form::text($id_name , $value , ['class' => 'form-control', 'id' => $id_name, 'cf_type' => 'gallery' ]) !!}
</div>
{!! Form::hidden('script[]', asset('/js/customfieldhandler.js'), ['class' => 'extrascript']) !!}


