<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 *
 * @package Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Models
 */
class Attribute extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'attributes';
    /**
     * @var array
     */
    protected $fillable = ['type', 'name', 'label', 'prefilled_list_items'];

    const TYPE_TEXT = 'TEXT';
    const TYPE_INTEGER = 'INTEGER';
    const TYPE_FLOAT = 'FLOAT';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(AttributeGroup::class, 'attribute_group_attributes');
    }

    /**
     * @return array
     */
    public static function getTypesAsList()
    {
        return [
            'TEXT'    => 'Tekst',
            'INTEGER' => 'Heel getal',
            'FLOAT'   => 'Getal met cijfer achter komma',
        ];
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public static function getTypeAsText($type)
    {
        $list = self::getTypesAsList();

        return array_get($list, $type, null);
    }

}