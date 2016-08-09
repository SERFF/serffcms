<div id="field_item_wrapper" class="@if($active)active @endif field_item_wrapper">
    <div id="field_item_header" class="row field_item_header">
        <div class="col-md-3"><span class="input_sorter">{{ $i+1 }}</span> <a id="toggler_{{ $i }}" href="javascript:CustomFields.toggleField({{ $i }})"><i class="toggler fa @if($active)fa-toggle-up @else fa-toggle-down @endif"></i></a> </div>
        <div class="col-md-3 headerLabel" id="headerLabel"></div>
        <div class="col-md-3 headerLabel" id="headerName"></div>
        <div class="col-md-2 headerLabel" id="headerType"></div>
        <div class="col-md-1"><a href="#"><i class="fa fa-trash pull-right" id="deleteRow"></i></a> </div>
    </div>
    <div class="field_item_fields">
        <div class="row">
            <div class="col-md-3 label-form-input">Veld label</div>
            <div class="col-md-9">{!! Form::text('input_label['.$i.']', array_get($group, 'fields.'.$i.'.label'), ['class' => 'form-control', 'id' => 'input_label']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label-form-input">Veld naam</div>
            <div class="col-md-9">{!! Form::text('input_name['.$i.']', array_get($group, 'fields.'.$i.'.name'), ['class' => 'form-control', 'id' => 'input_name']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label-form-input">Soort veld</div>
            <div class="col-md-9">{!! Form::select('input_type['.$i.']', $input_types, array_get($group, 'fields.'.$i.'.type'), ['class' => 'form-control', 'id' => 'input_type']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label-form-input">Instructies</div>
            <div class="col-md-9">{!! Form::textarea('description['.$i.']', array_get($group, 'fields.'.$i.'.description'), ['class' => 'form-control', 'rows' => '4']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label-form-input">Verplicht</div>
            <div class="col-md-9">

                <div class="radio">
                    <label>
                        {!! Form::radio('required['.$i.']', 'yes', array_get($group, 'fields.'.$i.'.required'), ['id' => 'required_yes']) !!} Ja
                    </label>
                    <label>
                        {!! Form::radio('required['.$i.']', 'no', !array_get($group, 'fields.'.$i.'.required'), ['id' => 'required_no']) !!} Nee
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>