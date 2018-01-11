<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'Nikola',
            'email' => 'knubbe@nadlanu.com',
            'password' => 'collabos',
            'password_confirmation' => 'collabos',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);;
    }

    public function testsRequiresEmailAndPassword()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' =>
                        [ 'The email field is required.' ],
                    'password' =>
                        [ 'The password field is required.' ]
                    ]
                ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'Nikola',
            'email' => 'knubbe@nadlanu.com',
            'password' => 'collabos',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' =>
                        [ 'The password confirmation does not match.' ]
                    ]
                ]);
    }
}
