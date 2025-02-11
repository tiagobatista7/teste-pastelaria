<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();
        DB::statement('PRAGMA foreign_keys=ON;');
    }
}
