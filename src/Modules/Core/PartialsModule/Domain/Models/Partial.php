<?php
namespace Serff\Cms\Modules\Core\PartialsModule\Domain\Models;

use Serff\Cms\Modules\Core\OptionsModule\Domain\Models\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Partial
 *
 * @package Serff\Cms\Modules\Core\PartialsModule\Domain\Models
 */
class Partial extends Model
{
    use RevisionableTrait;

    /**
     * @var bool
     */
    protected $revisionEnabled = true;
    /**
     * @var bool
     */
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    /**
     * @var int
     */
    protected $historyLimit = 500;
    
    /**
     * @var string
     */
    protected $table = 'partials';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'content', 'locale', 'author_id'];

    /**
     * @return HasMany
     */
    public function meta()
    {
        return $this->hasMany(Meta::class, 'type_id')->where('type', 'partial');
    }
}