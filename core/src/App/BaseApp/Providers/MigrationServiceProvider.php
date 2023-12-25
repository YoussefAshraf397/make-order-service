<?php

namespace App\BaseApp\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class MigrationServiceProvider extends ServiceProvider
{
    private Finder $files;

    private array $dirs;


    private string $domainsPath;


    public function boot()
    {
//        $this->domainsPath = Str::remove('/App/BaseApp', dirname(__DIR__)) . '/Domain';
//        $this->loadFiles();
//        $this->registerFiles();
    }

    private function loadFiles()
    {
        $this->files = (new Finder())->files()->in(
            $this->domainsPath
            . DIRECTORY_SEPARATOR
            . '*'
            . DIRECTORY_SEPARATOR
            . 'Database'
            . DIRECTORY_SEPARATOR
            . 'Migrations'
        );
    }

    private function registerFiles()
    {
        foreach ($this->files as $directory) {
            $this->dirs[] = $directory->getPath();
        }
        $this->dirs = array_unique($this->dirs);
        $this->loadMigrationsFrom($this->dirs);
    }
}
