<?php

namespace App\BaseApp\ViewModel\Api;

use Spatie\ViewModels\ViewModel;

abstract class BaseApiViewModel extends ViewModel
{
    private array $errors;

    abstract public function module(): string;

    public function getErrors(): array
    {
        $errorArray = [];
        foreach ($this->errors as $error) {
            if (is_array($error)) {
                $errorArray[] = [
                    'status' => $error['status'],
                    'title' => snake_case($error['title']),
                    'detail' => $error['detail'],
                ];
            } else {
                $errorArray[] = [
                    'status' => $this->errors['status'],
                    'title' => snake_case($this->errors['title']),
                    'detail' => $this->errors['detail'],
                ];
                break;
            }
        }
        return ['errors' => $errorArray];
    }

    public function setError($status, $detail, $title): void
    {
        $error['status'] = $status;
        $error['detail'] = $detail;
        $error['title'] = $title;
        $this->errors[] = $error;
    }
}
