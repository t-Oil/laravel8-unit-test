<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     * @return void
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }
}
