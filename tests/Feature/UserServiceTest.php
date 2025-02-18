<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    // Login Test

    public function testLoginUsernameSuccess()
    {
        $this->seed([UserSeeder::class]);

        $data = [
            "email_username" => "codebara",
            "password" => "123"
        ];

        $result = $this->userService->login($data);

        $this->assertTrue($result);
    }

    public function testLoginEmailSuccess()
    {
        $this->seed([UserSeeder::class]);

        $data = [
            "email_username" => "codebara@gmail.com",
            "password" => "123"
        ];

        $result = $this->userService->login($data);

        $this->assertTrue($result);
    }

    public function testLoginFailed()
    {
        $this->seed([UserSeeder::class]);

        $data = [
            "email_username" => "codebara@gmail.com",
            "password" => "salah"
        ];

        $result = $this->userService->login($data);

        $this->assertFalse($result);

        $data = [
            "email_username" => "salah",
            "password" => "123"
        ];

        $result = $this->userService->login($data);

        $this->assertFalse($result);

        $data = [
            "email_username" => "salah",
            "password" => "salah"
        ];

        $result = $this->userService->login($data);

        $this->assertFalse($result);
    }
}
