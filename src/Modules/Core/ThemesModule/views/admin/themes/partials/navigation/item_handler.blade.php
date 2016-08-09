<div class="box box-info">
    <div class="box-body">
        <div class="col-md-12">
            <ul id="itemsWrapper">
                @foreach (array_get($data, 'pages', []) as $page)
                    <li id="{{ array_get($page, 'id') }}"><div class="input-group"><div class="input-group-btn"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> </button></div><input class="form-control" name="item_{{ array_get($page, 'id') }}" type="text" value="{{ array_get($page, 'title') }}"></div></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>