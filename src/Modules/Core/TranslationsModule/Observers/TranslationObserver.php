<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Observers;

use Serff\Cms\Modules\Core\TranslationsModule\Cache\TranslationCacheManager;

class TranslationObserver
{
    /**
     * @var TranslationCacheManager
     */
    protected $cacheManager;

    public function __construct()
    {
        $this->cacheManager = app()->make(TranslationCacheManager::class);
    }

    /**
     * @param $model
     */
    public function saved($model)
    {
        $this->cacheManager->forgetTranslation($model->key, $model->locale);
    }

    /**
     * @param $model
     */
    public function deleted($model)
    {
        $this->cacheManager->forgetTranslation($model->key, $model->locale);
    }

}