<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Database\Seeders\BlogSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    public function testUsers()
    {
        $this->seed([UserSeeder::class]);

        $user = User::query()->where("username", "=", "codebara")->first();

        $this->assertEquals('codebara@gmail.com', $user->email);

    }

    public function testBlogs()
    {
        $this->seed([UserSeeder::class, BlogSeeder::class]);

        $user = User::query()->where("username", "=", "codebara")->first();
        $blog = Blog::query()->first();
        $blogs = $user->blogs;

        $this->assertEquals($user->id, $blog->user_id);
        foreach ($blogs as $blog) {
            $this->assertEquals($user->id, $blog->user_id);
        }

    }
}
