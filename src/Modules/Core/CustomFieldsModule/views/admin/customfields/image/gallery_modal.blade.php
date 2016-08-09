
<div class="modal" id="galleryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Afbeelding kiezer</h4>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#gallery" aria-controls="gallery" role="tab"
                                                              data-toggle="tab">Gallerij</a></li>
                    {{--<li role="presentation"><a href="#upload" aria-controls="upload" role="tab"--}}
                                               {{--data-toggle="tab">Upload</a></li>--}}
                </ul>
            </div>
            <div class="modal-body">
                <div>


                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="gallery"></div>
                        {{--<div role="tabpanel" class="tab-pane" id="upload"></div>--}}
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Sluiten</button>
                <button type="button" class="btn btn-primary" id="finishSelectImages">Kies</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    {!! Form::hidden('max_gallery_items', 1,  ['id' => 'max_gallery_items']) !!}
</div>
<!-- /.modal -->