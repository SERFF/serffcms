<div class="box box-info">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <label for="homepageSelect">Selecteer pagina om toe te voegen</label>
                <div class="col-md-11">
                    {!! Form::select('addpage',  array_pluck($pages, 'title', 'id'), null, ['class' => 'form-control', 'id' => 'addpageSelect']) !!}
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" id="addPage"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>