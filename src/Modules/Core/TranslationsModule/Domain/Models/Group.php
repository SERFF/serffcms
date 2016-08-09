<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'translation_groups';

    protected $fillable = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(Translation::class, 'group_id');
    }

}