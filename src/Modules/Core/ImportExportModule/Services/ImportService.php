<?php
namespace Serff\Cms\Modules\Core\ImportExportModule\Services;

use Alchemy\Zippy\Zippy;

/**
 * Class ImportService
 *
 * @package Serff\Cms\Modules\Core\ImportExportModule\Services
 */
class ImportService
{
    /**
     * @var string
     */
    protected $extract_dir;

    /**
     * ImportService constructor.
     */
    public function __construct()
    {
        $this->extract_dir = storage_path('exports/tmp');
    }

    /**
     * @param $path
     */
    public function import($path)
    {
        $this->extractExport($path);

        $this->setMediaFolder();

        $this->importDatabase();

        $this->cleanUp();

        $this->clearCache();
    }

    /**
     * @param $path
     */
    protected function extractExport($path)
    {
        if (\File::exists($this->extract_dir)) {
            \File::deleteDirectory($this->extract_dir);
        }
        \File::makeDirectory($this->extract_dir, 493, true);

        $zippy = Zippy::load();

        $zippy->open($path)->extract($this->extract_dir);
    }

    /**
     *
     */
    protected function setMediaFolder()
    {
        $media_folder = storage_path('media');
        if (\File::exists($media_folder)) {
            \File::deleteDirectory($media_folder);
        }

        \File::copyDirectory($this->extract_dir . '/media', $media_folder);
    }

    /**
     *
     */
    protected function cleanUp()
    {
        \File::deleteDirectory($this->extract_dir);
    }

    /**
     *
     */
    protected function clearCache()
    {
        \Cache::flush();
    }

    /**
     * @throws \Exception
     */
    protected function importDatabase()
    {
        $db_file = null;
        foreach (\File::files($this->extract_dir) as $file) {
            if (\File::extension($file) == 'sql') {
                $db_file = $file;
            }
        }

        if ($db_file == null) {
            throw new \Exception('SQL file not found');
        }

        $this->dropDatabase();
        $this->createDatabase();
        $this->importSql($db_file);
    }

    /**
     *
     */
    protected function dropDatabase()
    {
        $drop_command = 'mysql -u %s --password=%s -h %s -P %s -e "%s"';
        $drop_command = sprintf($drop_command, env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_HOST'), env('DB_PORT'), 'drop database ' . env('DB_DATABASE'));

        exec($drop_command);
    }

    /**
     *
     */
    protected function createDatabase()
    {
        $create_command = 'mysql -u %s --password=%s -h %s -P %s -e "%s"';
        $create_command = sprintf($create_command, env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_HOST'), env('DB_PORT'), 'create database ' . env('DB_DATABASE'));
        
        exec($create_command);
    }

    /**
     * @param $db_file
     */
    protected function importSql($db_file)
    {
        $import_command = 'mysql -u %s --password=%s -h %s -P %s %s < %s';
        $import_command = sprintf($import_command, env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_HOST'), env('DB_PORT'), env('DB_DATABASE'), $db_file);

        exec($import_command);
    }

}