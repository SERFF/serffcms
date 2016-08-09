@section('header.scripts')
    @parent
    <link href="{{ asset('/css/products.css')}}" rel="stylesheet" type="text/css"/>
@endsection

<div class="form-group">
    <label for="name">Naam</label>
    {!! Form::text('name', array_get($group, 'name'), ['class' => 'form-control', 'id' => 'name']) !!}
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Groep attributen</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="attributes sortable" id="selected">

                    @foreach($selected_attributes as $selected_attribute)
                        <li id="{{ $selected_attribute->id }}">
                            {{ $selected_attribute->label }}
                            (
                            {{ \Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Attribute::getTypeAsText($selected_attribute->type) }}
                            )
                        </li>
                    @endforeach

                </ul>

                {!! Form::hidden('selected_attributes', $selected_attributes_string, ['id' => 'selected_attributes']) !!}
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Beschikbare attributen</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="attributes draggable sortable" id="available">
                    @foreach($available_attributes as $available_attribute)
                        <li id="{{ $available_attribute->id }}">
                            {{ $available_attribute->label }}
                            (
                            {{ \Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Attribute::getTypeAsText($available_attribute->type) }}
                            )
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $(".sortable").sortable({
                revert: true
            });
            $(".draggable li").draggable({
                connectToSortable: ".sortable",
                revert: false,
                stop: function () {
                    setTimeout(update_selected_items, 800);
                }
            });
            $("ul, li").disableSelection();
        });

        function update_selected_items() {
            var selected_items = '';
            var items = $('#selected').find('li');
            var counter = 0;
            items.each(function () {
                var attr_id = $(this).attr('id');
                counter++;
                if (isNaN(attr_id) == false) {
                    selected_items += attr_id;
                    if (counter < items.length) {
                        selected_items += '||';
                    }
                }
            });

            $('#selected_attributes').val(selected_items);
        }
    </script>
@endsection