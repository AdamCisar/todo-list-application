<?php

namespace Tests;

use App\Features\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected const string API_BASE = '/api';

    protected function createUser($attributes = [])
    {
        return User::factory()->create($attributes);
    }

    protected function createAuthenticatedUser($attributes = [])
    {
        $user = $this->createUser($attributes);
        $this->actingAs($user);

        return $user;
    }
}
