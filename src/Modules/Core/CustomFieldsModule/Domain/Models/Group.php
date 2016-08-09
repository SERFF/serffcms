<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models
 */
class Group extends Model
{
    /**
     * @var string
     */
    protected $table = 'cf_groups';
    /**
     * @var array
     */
    protected $fillable = ['name', 'status'];

    const STATUS_DRAFT = 'DRAFT';
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

}