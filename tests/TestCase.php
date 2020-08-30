<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertClassUseTrait($class, $trait)
    {
        $this->assertArrayHasKey(
            $trait,
            class_uses($class),
            "{$class} must use the trait {$trait}"
        );
    }
}
