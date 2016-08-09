<?php
namespace Serff\Cms\Core\Cms\Loader;

use Symfony\Component\Finder\Finder;

class Loader
{

    public function find($namespace, $path)
    {
        $finder = new Finder();

        $finder->files()
            ->name('*.php')
            ->in($path);

        $items = [];

        foreach ($finder->files() as $file) {
            $ns = $namespace;
            if ($relativePath = $file->getRelativePath()) {
                $ns .= '\\' . strtr($relativePath, '/', '\\');
            }

            $class = $ns . '\\' . $file->getBasename('.php');

            try {
                $items[] = new \ReflectionClass($class);

            } catch (\Exception $e) {

            }
        }

        return $items;
    }
}