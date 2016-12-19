<?php
namespace Serff\Cms\Modules\Core\PagesModule\Domain\Models\Pages;

use Serff\Cms\Modules\Core\OptionsModule\Domain\Models\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\Revision;
use Venturecraft\Revisionable\RevisionableTrait;

class Page extends Model
{
    use RevisionableTrait, SoftDeletes;

    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUS_DRAFT = 'DRAFT';

    /**
     * @var string
     */
    protected $table = 'pages';
    /**
     * @var array
     */
    protected $fillable = ['title', 'content', 'slug', 'status', 'locale', 'author_id', 'published_at'];

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
     * @return string
     */
    public static function getSlugsInPipeFormat($locale)
    {
        $slugs = self::where('status', self::STATUS_PUBLISHED)->pluck('slug')
            ->all();

        $old_slugs = Revision::whereRevisionableType(Page::class)
            ->whereKey('slug')
            ->join('pages', 'revisionable_id', '=', 'pages.id')
            ->where('pages.status', Page::STATUS_PUBLISHED)
            ->where('pages.status', $locale)
            ->pluck('old_value')
            ->all();

        $slugs = array_merge($slugs, $old_slugs);

        //return $slugs;
        //});

        return implode('|', (array)$slugs) . '|';
    }

    /**
     * @return HasMany
     */
    public function meta()
    {
        return $this->hasMany(Meta::class , 'type_id')->where('type', 'page');
    }
}