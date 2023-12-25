<?php

namespace App\BaseApp\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class TranslationServiceProvider extends ServiceProvider
{
    private Finder $files;

    private array $dirs = [];

    public function boot()
    {
        $this->loadFiles();
        $this->registerFiles();
    }

    private function loadFiles()
    {
        $this->files = (new Finder())->files()->in(
            app()->basePath()
            . DIRECTORY_SEPARATOR
            . 'src'
            . DIRECTORY_SEPARATOR
            . 'App'
            . DIRECTORY_SEPARATOR
            . '*'
            . DIRECTORY_SEPARATOR
            . '*'
            . DIRECTORY_SEPARATOR
            . 'Lang'
        );
    }

    private function registerFiles()
    {
        foreach ($this->files as $directory) {
            $this->dirs[] = $directory->getPath();
        }
        $this->dirs = array_unique($this->dirs);
        foreach ($this->dirs as $directory) {
            $directory = substr($directory, 0, strpos($directory, 'Lang') + 4);
            $qualifiedNameSpace = $this->fullQualifiedModuleFormDirectory($directory);
            $this->loadTranslationsFrom($directory, $qualifiedNameSpace);
        }
    }

    protected function fullQualifiedModuleFormDirectory($file): string
    {
        $moduleNameSpace = trim(Str::replaceFirst(app()->basePath(), '', $file), DIRECTORY_SEPARATOR);
        $moduleNameSpace = explode('/', $moduleNameSpace);
        return $moduleNameSpace[2] . $moduleNameSpace[3];
    }
}
