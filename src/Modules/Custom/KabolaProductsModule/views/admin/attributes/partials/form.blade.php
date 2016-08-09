
<div class="form-group">
    <label for="name">Naam</label>
    {!! Form::text('name', array_get($attribute, 'name'), ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="label">Label</label>
    {!! Form::text('label', array_get($attribute, 'label'), ['class' => 'form-control', 'id' => 'label']) !!}
</div>

<div class="form-group">
    <label for="type">Type</label>
    {!! Form::select('type', \Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models\Attribute::getTypesAsList(), array_get($attribute, 'type'), ['class' => 'form-control', 'id' => 'type']) !!}
</div>

<div class="form-group">
    <label for="prefilled_list_items">Voorgedefinieerde opties (alleen optie bij tekst), scheiden d.m.v. || </label>
    {!! Form::text('prefilled_list_items', array_get($attribute, 'prefilled_list_items'), ['class' => 'form-control', 'id' => 'prefilled_list_items']) !!}
</div>