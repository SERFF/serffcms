<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttributeGroup
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models
 */
class AttributeGroup extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'attribute_groups';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_group_attributes');
    }

}