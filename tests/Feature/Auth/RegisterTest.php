<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @return void
     */
    public function test_success_register(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'token'
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_name_must_not_be_empty(): void
    {
        $data = [
            'name' => '',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'name'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_email_must_not_be_empty(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'email'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_password_must_not_be_empty(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'password'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_password_confirmation_must_not_be_empty(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => ''
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'password'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_email_is_already_taken(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        User::create($data);

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'email'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_name_must_be_a_string(): void
    {
        $data = [
            'name' => 123456789,
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'name'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_password_must_contain_at_least_6(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 12345,
            'password_confirmation' => 12345
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'password'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_email_invalid_format(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'adminadmin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'email'
            ]
        ]);
    }
}
