<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Field
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models
 */
class Field extends Model
{
    /**
     * @var string
     */
    protected $table = 'cf_fields';
    /**
     * @var array
     */
    protected $fillable = ['group_id', 'name', 'label', 'type', 'required', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}