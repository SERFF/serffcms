<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models;

use Serff\Cms\Modules\Core\OptionsModule\Domain\Models\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Product
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models
 */
class Product extends Model
{
    /**
     * @var string
     */
    protected $table = 'products';
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function meta()
    {
        return $this->hasMany(Meta::class , 'type_id')->where('type', 'product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id', 'attribute_id')->withPivot('value');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}