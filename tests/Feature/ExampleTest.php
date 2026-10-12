<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRootRedirectsToLogin()
    {
        $this->get('/')->assertRedirect(route('login'));
    }

    public function testLoginPageLoads()
    {
        $this->get('/login')->assertOk();
    }
}
