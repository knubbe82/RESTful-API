<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' =>
                        [ 'The email field is required.' ],
                    'password' =>
                        [ 'The password field is required.']
                    ]
                ]);
    }

    public function testUserLoginsSuccessfully()
    {
        factory(User::class)->create([
            'email' => 'knubbe@nadlanu.com',
            'password' => bcrypt('collabos'),
        ]);

        $payload = ['email' => 'knubbe@nadlanu.com', 'password' => 'collabos'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
}
