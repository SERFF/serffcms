<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';

    protected $fillable = ['group_id', 'key', 'value', 'locale'];

}


