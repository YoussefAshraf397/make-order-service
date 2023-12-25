<?php

namespace App\BaseApp\ViewModel;

use Spatie\ViewModels\ViewModel;

abstract class BaseViewModel extends ViewModel
{
    public array $breadcrumb = [];

    abstract public function module(): string;

    abstract public function route(): string;

    abstract public function pageTitle(): string;

    public function setBreadcrumb(array $appendedBreadcrumb = []): self
    {
        if (isset($appendedBreadcrumb)) {
            $result = array_merge($this->breadcrumb, $appendedBreadcrumb);
            $this->breadcrumb = $result;
        }
        return $this;
    }
}
