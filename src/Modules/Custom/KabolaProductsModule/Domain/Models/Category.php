<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models
 */
class Category extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributeGroups()
    {
        return $this->belongsToMany(AttributeGroup::class, 'category_attribute_groups', 'category_id', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}