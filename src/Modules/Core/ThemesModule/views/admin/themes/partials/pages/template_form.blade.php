<div class="box box-info">
    <div class="box-header">
        <strong>Template</strong>
    </div>
    <div class="box-body">
        <label for="template_select">Selecteer de pagina template</label>
        {!! Form::select('template', array_merge([null => 'Geen'],$templates),  $selected_template, ['class' => 'form-control', 'id' => 'template_select']) !!}
    </div>
</div>