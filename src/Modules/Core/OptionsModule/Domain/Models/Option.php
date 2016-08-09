<?php
namespace Serff\Cms\Modules\Core\OptionsModule\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    
    protected $fillable = ['name', 'value'];
    
    public $timestamps = false;
    
    

}