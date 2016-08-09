@if(isset($page)):
<div id="pageUpdateModal" style="display: none; width: 80%;">
    <div class="modal-content">
        <div class="modal-body text-center" style="min-height:650px;">
            {!! Form::textarea('editor-content', array_get($page, 'content'), ['id' => 'editor-content', 'rows' => 40, 'cols' => 80]) !!}
            <button class="btn-good" id="pageUpdateSaveButton">Opslaan</button>
        </div>
    </div>
</div>
@endif