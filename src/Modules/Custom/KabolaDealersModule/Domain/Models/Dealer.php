<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Dealer
 *
 * @package Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Models
 */
class Dealer extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'dealers';
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'street',
        'postcode',
        'city',
        'country',
        'contact_address',
        'phone',
        'emergency_phone',
        'latitude',
        'longitude',
    ];

    /**
     * The visible output in toArray or toJson methods
     *
     * @var array
     */
    protected $visible = [
        'name',
        'street',
        'postcode',
        'city',
        'country',
        'contact_address',
        'phone',
        'emergency_phone',
        'latitude',
        'longitude',
        'distance',
        'id'
    ];

}