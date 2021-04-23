<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

trait SetupDatabaseTrait
{
    // use RefreshDatabase; // When using in memory SQLite DB test
    use DatabaseMigrations;
    use DatabaseTransactions; // When using MySQL DB test
}
