<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <strong>Locatie</strong>
            </div>
            <div class="box-body">
                <div class="col-md-3">
                    <p><strong>Regels</strong></p>
                    Maak regels aan om te bepalen op welke edit screen jouw extra velden verschijnen
                </div>
                <div class="col-md-9">
                    <p><strong>Toon deze groep als</strong></p>
                    <div id="rulesGroups">
                        @for($i = 0; $i < $rules_rows; $i++)
                            <div id="rulesGroup" class="rules-group">
                                <div class="col-md-4 no-padding">{!! Form::select('rules[' . $i . '][type]', ['template' => 'Pagina Template', 'page' => 'Pagina'], array_get($group, 'rules.'.$i.'.key'), ['class' => 'form-control rules-type', 'id' => 'rulesType']) !!}</div>
                                <div class="col-md-3 no-padding">{!! Form::select('rules[' . $i . '][comparator]', ['equals' => 'gelijk is aan', 'unequals' => 'niet gelijk is aan'], array_get($group, 'rules.'.$i.'.comparator'), ['class' => 'form-control', 'id' => 'rulesComparator']) !!}</div>
                                <div class="col-md-4 no-padding">{!! Form::select('rules[' . $i . '][key]', [], array_get($group, 'rules.'.$i.'.value'), ['class' => 'form-control', 'id' => 'rulesKey']) !!}</div>
                                <div class="col-md-1">
                                    <button class="btn btn-secondary btn-add-rules-item" id="btn-add-rules-item"><i
                                                class="fa fa-plus"></i></button>
                                    <button class="btn btn-default btn-delete-rules-item pull-right"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>