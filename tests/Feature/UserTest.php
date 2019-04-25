<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{

    use RefreshDatabase;

    private function authenticate()
    {
        $user = User::create([
            'name' => 'User',
            'lastname' => 'Test',
            'email' => 'test@domain.com',
            'phone' => '54830917',
            'password' => bcrypt('asdasd'),
        ]);
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    public function testRegister()
    {
        $dataUser = [
            'name' => 'User',
            'lastname' => 'Test',
            'email' => 'test@domain.com',
            'phone' => '54830917',
            'password' => bcrypt('asdasd'),
        ];

        $response = $this->json('POST', route('auth.register'), $dataUser);

        $response->assertStatus(200);

        $this->assertArrayHasKey('token', $response->json());
    }

    public function testUpdate()
    {
        // Get JWT token
        $token = $this->authenticate();

        $data = [
            'name' => 'Danny',
            'lastname' => 'Almeida',
            'email' => 'newemail@domain.com',
            'phone' => '7 68 55555',
            'cellphone' => '+54 54545454',
            'address' => 'Direccion de prueba',
        ];

        // append Token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', route('profile.edit'), $data);

        $response->assertStatus(200);

        $this->assertArraySubset(['success' => true], $response->json());

    }
}
