<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Habilitar suporte a Foreign Keys no SQLite para evitar falhas de integridade referencial nos testes
        DB::statement('PRAGMA foreign_keys=ON;');
    }
}
