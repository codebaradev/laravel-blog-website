<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    // Login

    public function testShowLoginSuccess()
    {
        $response = $this->get("/admin/login?key=123");

        $response->assertSeeText("Email or Username");
        $response->assertSeeText("Password");
        $response->assertSeeText("Login");
    }

    public function testShowLoginFailed()
    {
        $response = $this->get("/admin/login?key=salah");

        $response->assertSeeText("404");
        $response->assertSeeText("Not Found");
    }

    public function testLoginByUsernameSuccess()
    {
        $this->seed([UserSeeder::class]);

        $response = $this->post("/admin/login?key=123", [
            "email_username" => "codebara",
            "password" => "123"
        ]);

        $response->assertStatus(302);
        $response->assertRedirect("/");
    }

    public function testLoginByEmailSuccess()
    {
        $this->seed([UserSeeder::class]);

        $response = $this->post("/admin/login?key=123", [
            "email_username" => "codebara@gmail.com",
            "password" => "123"
        ]);

        $response->assertStatus(302);
        $response->assertRedirect("/");
    }

    public function testLoginFailed()
    {
        $this->seed([UserSeeder::class]);

        $response = $this->post("/admin/login?key=123", [
            "email_username" => "salah",
            "password" => "salah"
        ]);

        $response->assertStatus(302);
        $response->assertRedirect("/"); // im tired
    }
}
