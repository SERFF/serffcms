<div class="form-group">
    <label for="key">Key</label>
    {!! Form::text('key', array_get($translation, 'key'), ['class' => 'form-control', 'id' => 'key', 'disabled' => 'disabled']) !!}
</div>

<div class="form-group">
    <label for="locale">Taal / landinstelling</label>
    {!! Form::text('locale', array_get($translation, 'locale'), ['class' => 'form-control', 'id' => 'locale', 'disabled' => 'disabled']) !!}
</div>

<div class="form-group">
    <label for="value">Vertaling</label>
    {!! Form::text('value', array_get($translation, 'value'), ['class' => 'form-control', 'id' => 'value']) !!}
</div>