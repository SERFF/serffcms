<div class="box box-info">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <label for="homepageSelect">Selecteer uw homepage</label>
                {!! Form::select('homepage',  array_pluck($pages, 'title', 'id'), array_get($data, 'home'), ['class' => 'form-control', 'id' => 'homepageSelect']) !!}
            </div>
        </div>
    </div>
</div>