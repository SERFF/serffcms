<div class="box box-info">
    <div class="box-header">
        <strong>Locale</strong>
    </div>
    <div class="box-body">
        <label for="locale_select">Kies een taal</label>
        {!! Form::select('locale', $available_locales, $selected_locale, ['class' => 'form-control', 'id' => 'locale_select']) !!}
    </div>
</div>