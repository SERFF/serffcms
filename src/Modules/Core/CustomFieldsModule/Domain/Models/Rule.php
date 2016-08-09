<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rule
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models
 */
class Rule extends Model
{
    /**
     * @var string
     */
    protected $table = 'cf_rules';
    /**
     * @var array
     */
    protected $fillable = ['group_id', 'key', 'comparator', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}