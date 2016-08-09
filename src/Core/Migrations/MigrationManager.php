<?php
namespace Serff\Cms\Core\Migrations;

use App;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * Class Manager
 *
 * @package Serff\Cms\Core\Migrations
 */
class MigrationManager
{
    /**
     * @var Filesystem $filesystem
     */
    protected $filesystem = null;

    /**
     * @var string
     */
    protected $table = 'migrations';

    /**
     * @var DatabaseMigrationRepository $repository
     */
    protected $repository = null;

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->filesystem = App::make(Filesystem::class);

        $this->repository = new DatabaseMigrationRepository(app()['db'], $this->table);
    }

    /**
     * Load the migration classes from path and namespace
     *
     * @param $path
     * @param $namespace
     *
     * @return array
     */
    public function getMigrations($path, $namespace)
    {
        $files = $this->filesystem->files($path);

        $ran = $this->repository->getRan();
        
        $migrations = array_diff($files, $ran);

        $this->requireFiles($migrations);

        $items = $this->getMigrationClasses($namespace, $migrations);

        return $items;
    }


    /**
     * Resolve a migration instance from a file.
     *
     * @param string $file
     * @param string $namespace
     *
     * @return object
     */
    public function resolve($file, $namespace)
    {
        $file = implode('_', array_slice(explode('_', $file), 4));

        $class = $namespace . Str::studly($file);

        return new $class;
    }

    /**
     * Require in all the migration files in a given path.
     *
     * @param  array $files
     *
     * @return void
     */
    public function requireFiles(array $files)
    {
        foreach ($files as $file) {
            $this->filesystem->requireOnce($file);
        }
    }

    /**
     * @param $namespace
     * @param $files
     *
     * @return array
     */
    public function getMigrationClasses($namespace, $files)
    {
        $items = array_map(function ($file) use ($namespace) {
            $filename = str_replace('.php', '', $file);

            return $this->resolve($filename, $namespace);
        }, $files);

        return $items;
    }

    /**
     * @return bool
     */
    public function installed()
    {
        return $this->repository->repositoryExists();
    }

    /**
     * prepare migrations table if needed
     */
    public function prepare()
    {
        if ($this->installed() === false) {
            $this->repository->createRepository();
        }
    }

    public function run($migrations)
    {
        $batch = $this->repository->getNextBatchNumber();

        foreach ($migrations as $migration) {
            $reflectionClass = new \ReflectionClass(get_class($migration));
            $file = $reflectionClass->getFileName();
            $migration->up();
            $this->repository->log($file, $batch);
        }
    }

}