<?php

namespace Tests\Feature\Controllers\Api\AuthController;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthTest extends TestCase
{
    /**
     * @return void
     * @group AuthTest
     * @group testLoginShouldBeFails
     */
    public function testLoginShouldBeFails()
    {
        $mockUser = User::factory()->create();

        $body = [
            'username' => $mockUser->email,
            'password' => 'wrong_password'
        ];
        $response =  $this->json('POST','/api/auth/login',$body,['Accept' => 'application/json']);

        $this->assertEquals(401, $response->json('status'));
        $this->assertEquals('Unauthorized', $response->json('error'));
    }

    /**
     * @return void
     * @group AuthTest
     * @group testLoginShouldBeOk
     */
    public function testLoginShouldBeOk()
    {
        $mockUser = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('Admin'),
        ]);

        $body = [
            'email' => $mockUser->email,
            'password' => 'Admin'
        ];
        $response =  $this->json('POST','/api/auth/login',$body,['Accept' => 'application/json']);

        $this->assertEquals(200, $response->json('status'));
        $response->assertJsonStructure([
            'status',
            'data' => [
                'access_token',
                'expires_in',
            ]
        ]);
    }
}
