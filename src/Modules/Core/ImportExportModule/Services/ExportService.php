<?php
namespace Serff\Cms\Modules\Core\ImportExportModule\Services;

use Alchemy\Zippy\Zippy;

/**
 * Class ExportService
 *
 * @package Serff\Cms\Modules\Core\ImportExportModule\Services
 */
class ExportService
{
    /**
     * @var string
     */
    /**
     * @var string
     */
    protected $archive_dir, $db_export_path;

    /**
     * ExportService constructor.
     */
    public function __construct()
    {
        $this->archive_dir = storage_path('exports');
        $this->db_export_path = $this->archive_dir . '/db/';
    }

    /**
     * @return array
     */
    public function getExports()
    {
        $files = \File::files($this->archive_dir);
        $exports = [];
        foreach ($files as $file) {
            $exports[] = [
                'name'       => \File::name($file),
                'size'       => \File::size($file),
                'created_at' => \File::lastModified($file),
                'fullname'   => \File::basename($file),
            ];
        }

        return $exports;
    }

    /**
     *
     */
    public function createExport()
    {
        $this->preparePath();
        $database_backup = $this->createDatabaseBackup();
        $this->createArchive([$database_backup, storage_path('media')]);
        $this->cleanUp($database_backup);
    }

    /**
     *
     */
    protected function preparePath()
    {
        if (\File::exists($this->db_export_path) === false) {
            \File::makeDirectory($this->db_export_path, 493, true);
        }
    }

    /**
     * @return Zippy
     */
    protected function createArchive($paths)
    {
        $archive = Zippy::load();
        $archive->create($this->archive_dir . '/export_' . time() . '.zip', $paths);

        return $archive;
    }

    /**
     * @return string
     */
    protected function createDatabaseBackup()
    {
        $dump_command = 'mysqldump -u %s --password=%s -h %s --port=%s %s > %s';
        $db_file = $this->db_export_path . time() . '.sql';
        $dump_command = sprintf($dump_command, env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_HOST'), env('DB_PORT'), env('DB_DATABASE'), $db_file);
        exec($dump_command);

        return $db_file;
    }

    /**
     * @param $database_backup
     */
    protected function cleanUp($database_backup)
    {
        \File::delete($database_backup);
    }

    /**
     * @param $id
     */
    public function deleteExport($id)
    {
        $path = $this->archive_dir . '/' . $id;
        if (\File::exists($path)) {
            \File::delete($path);
        }
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getExport($id)
    {
        $path = $this->archive_dir . '/' . $id;
        if (\File::exists($path)) {
            return [
                'content' => \File::get($path),
                'mime'    => \File::mimeType($path),
                'path'    => $path,
            ];
        }

        return [];
    }

}