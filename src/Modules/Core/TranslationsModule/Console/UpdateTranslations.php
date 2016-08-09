<?php
namespace Serff\Cms\Modules\Core\TranslationsModule\Console;

use Serff\Cms\Modules\Core\TranslationsModule\Services\TranslationService;
use Illuminate\Console\Command;

/**
 * Class UpdateTranslations
 *
 * @package Serff\Cms\Modules\Core\TranslationsModule\Console
 */
class UpdateTranslations extends Command
{
    /**
     * @var string
     */
    protected $signature = 'translate:update';

    /**
     * @var string
     */
    protected $description = 'Update the translations for the application';
    /**
     * @var TranslationService
     */
    protected $service;

    /**
     * UpdateTranslations constructor.
     */
    public function __construct()
    {
        $this->service = app()->make(TranslationService::class);
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {
        $this->service->updateRecordsWithMissingKeys();
        $this->service->updateRecordsWithLangFiles();
        $this->comment(PHP_EOL . 'Translations are updated' . PHP_EOL);
    }

}