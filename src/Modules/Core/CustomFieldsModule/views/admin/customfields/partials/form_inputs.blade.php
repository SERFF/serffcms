<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <strong>Velden</strong>
            </div>
            <div class="box-body">
                <div class="row" id="field_items_header">
                    <div class="col-md-3">Volgorde</div>
                    <div class="col-md-3">Label</div>
                    <div class="col-md-3">Naam</div>
                    <div class="col-md-3">Soort</div>
                </div>
                <div class="col-md-12" id="field_items_wrapper">
                    @for($i = 0; $i < $rows; $i++)
                        @php $active = ($i+1) == $rows ? true : false; @endphp 
                        @include('admin.customfields.partials.form_input_form')
                    @endfor
                </div>
                <div class="col-md-12" id="field_items_footer">
                    <button class="btn btn-primary pull-right" id="addInput"><i class="fa fa-plus"></i> Nieuw veld
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
