@php $id_name = str_slug(array_get($input, 'group.name')) . '.' . $input['name'];  @endphp
@php $key = str_slug(array_get($input, 'group.name')) . '.' . $input['name'];  @endphp
<div class="form-group">
    <label for="{{ $id_name }}">{!! $input['label'] !!} </label>
    <small>{{ array_get($input, 'description') }}</small>
    {!! Form::select($id_name.'[]' , get_all_partials_for_select_by_locale(array_get($record, 'locale')), get_cf_form_option($key, 'page', array_get($record, 'id'), array_get($input, 'type'), []), ['class' => 'form-control select2element', 'id' => $id_name, 'multiple' => 'multiple']) !!}
</div>
