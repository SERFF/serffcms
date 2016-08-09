<?php
namespace Serff\Cms\Modules\Core\MediaModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    
    protected $fillable = ['original_name', 'extension', 'author_id', 'title', 'description', 'width', 'height'];

}