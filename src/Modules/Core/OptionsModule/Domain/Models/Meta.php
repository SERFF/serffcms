<?php
namespace Serff\Cms\Modules\Core\OptionsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Meta
 *
 * @package Serff\Cms\Modules\Core\OptionsModule\Domain\Models
 */
class Meta extends Model
{
    /**
     * @var string
     */
    protected $table = 'meta';
    /**
     * @var array
     */
    protected $fillable = ['type', 'type_id', 'name', 'value'];
    /**
     * @var bool
     */
    public $timestamps = false;

}