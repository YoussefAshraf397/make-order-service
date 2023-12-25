<?php

namespace App\BaseApp\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\ViewServiceProvider;
use Symfony\Component\Finder\Finder;

class ViewServiceProviders extends ViewServiceProvider
{
    private Finder $files;

    private array $dirs = [];

    public function boot(): void
    {
        $this->loadDirectories();
        $this->registerViews();
        Blade::componentNamespace('App\\BaseApp\\View\\Components', 'app');
    }

    private function loadDirectories(): void
    {
        $this->files = (new Finder())->files()
            ->name('*.blade.php')
            ->in(
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
                . 'Views'
                . DIRECTORY_SEPARATOR
            );
    }

    private function registerViews(): void
    {
        foreach ($this->files as $directory) {
            $this->dirs[] = $directory->getPath();
        }
        $this->dirs = array_unique($this->dirs);

        foreach ($this->dirs as $directory) {
            $directory = substr($directory, 0, strpos($directory, 'Views') + 5);
            $qualifiedNameSpace = $this->fullQualifiedModuleFormDirectory($directory);
            $this->loadViewsFrom($directory, $qualifiedNameSpace);
        }
    }

    protected function fullQualifiedModuleFormDirectory($file): string
    {
        $moduleNameSpace = trim(Str::replaceFirst(app()->basePath(), '', $file), DIRECTORY_SEPARATOR);
        $moduleNameSpace = explode('/', $moduleNameSpace);
        return $moduleNameSpace[2] . $moduleNameSpace[3];
    }
}
