<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="form-group">
                    <label for="title">Naam</label>
                    {!! Form::text('name', array_get($group, 'name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Hier een naam invoeren']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
