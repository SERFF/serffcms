<?php
namespace Serff\Cms\Modules\Core\ImportExportModule\Console;

use Serff\Cms\Modules\Core\ImportExportModule\Services\ImportService;
use Illuminate\Console\Command;

/**
 * Class ImportExport
 *
 * @package Serff\Cms\Modules\Core\ImportExportModule\Console
 */
class ImportExport extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:export {export : the export file}';

    /**
     * @var string
     */
    protected $description = 'Import an export file';

    /**
     * @var ImportService
     */
    protected $importService;

    /**
     * ImportExport constructor.
     */
    public function __construct()
    {
        $this->importService = app(ImportService::class);
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {
        $path = $this->argument('export');
        if (\File::exists($path) === false) {
            return $this->error('No such file');
        }

        $confirm = $this->confirm('This will delete your database and media files, are you sure? [Y/n]', true);
        if ($confirm === false) {
            return $this->error('Import cancelled');
        }

        $this->importService->import($path);

        $this->comment(PHP_EOL . 'Import is done' . PHP_EOL);
    }
}