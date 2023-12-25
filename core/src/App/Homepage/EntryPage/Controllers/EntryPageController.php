<?php

namespace App\Homepage\EntryPage\Controllers;

use Illuminate\Contracts\View\View;
use Support\RouteAttributes\Attributes\Get;
use Support\RouteAttributes\Attributes\SkipModulePrefix;

#[SkipModulePrefix('')]
class EntryPageController
{
    public function __construct(
        private readonly string $module = 'HomepageEntryPage'
    ) {
    }

    #[Get(uri: '/', name: 'getEntryPage', skipModuleRouteName: true)]
    public function index(): View
    {
        return view($this->module . '::index');
    }
}
