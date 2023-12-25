<?php

namespace Tests;

use Database\Seeders\FoodicsTaskSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use CreatesApplication;
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(FoodicsTaskSeeder::class);
    }

    public function postJson($uri, array $data = [], array $headers = [])
    {
        $headers = array_merge($headers, [
            'accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ]);
        return $this->json('POST', $uri, $data, $headers);
    }
}
