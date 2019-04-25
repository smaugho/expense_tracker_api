<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function testLogin()
    {
        User::create([
            'name' => 'User',
            'lastname' => 'Test',
            'email' => 'test@domain.com',
            'phone' => '54830917',
            'password' => bcrypt('asdasd'),
        ]);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'test@domain.com',
            'password' => 'asdasd',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }




}
