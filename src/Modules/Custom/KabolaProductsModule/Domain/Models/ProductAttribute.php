<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductAttribute
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models
 */
class ProductAttribute extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_attributes';

    /**
     * @var array
     */
    protected $fillable = ['product_id', 'attribute_id', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

}