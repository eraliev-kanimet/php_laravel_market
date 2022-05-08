<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @var User
     */
    private User $user;

    /**
     * @var string
     */
    private string $user_password = 'password';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $data = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make($this->user_password)
        ];

        $this->user = User::create($data);
    }

    /**
     * @return void
     */
    public function test_success_login(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => $this->user->email,
            'password' => $this->user_password
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'token'
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_error_email_must_not_be_empty(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => '',
            'password' => $this->user_password
        ]);
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
        $response = $this->postJson(route('login'), [
            'email' => $this->user->email,
            'password' => ''
        ]);
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
    public function test_failed_error_password_must_contain_at_least_6(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => $this->user->email,
            'password' => 12345
        ]);
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
        $response = $this->postJson(route('login'), [
            'email' => 'adminadmin.com',
            'password' => $this->user->password
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'email'
            ]
        ]);
    }
}
