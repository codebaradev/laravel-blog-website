<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use App\Services\BlogService;
use Database\Seeders\BlogSeeder;
use Database\Seeders\UserSeeder;
use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BlogServiceTest extends TestCase
{
    private BlogService $blogService;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->blogService = new BlogService();

        $this->seed([UserSeeder::class]);
        $this->user = User::query()->where("username", "codebara")->first();
        Auth::login($this->user);
    }

    // test Create and get

    public function testCreateSuccess(): void
    {
        $data = ["title" => "The Future of AI!!!"];

        $result = $this->blogService->create($data);

        $this->assertTrue($result);

        $blog = $this->blogService->get("the-future-of-ai");

        $this->assertEquals($data["title"], $blog->title);
    }

    public function testCreateFailed(): void
    {
        $this->testCreateSuccess();

        $this->expectException(ValidationException::class);

        $data = ["title" => "The Future of AI!!!"];

        $this->blogService->create($data);
    }

    // getAll

    public function testGetAll()
    {
        $this->seed([BlogSeeder::class]);

        $blogs = $this->blogService->getAll();

        $this->assertEquals(5, count($blogs));
    }

    public function testGetAllEmpty()
    {
        $blogs = $this->blogService->getAll();

        $this->assertEquals(0, count($blogs));
    }

    // update

    public function testUpdateSuccess()
    {
        $this->seed([BlogSeeder::class]);

        $data = [
            "title" => "The Future of AI in 2025!!!",
            "content" => "The Future of AI in 2025 is bruh"
        ];

        $oldBlog = Blog::query()->first();

        $result = $this->blogService->update($oldBlog->unique_title, $data);

        $updatedBlog = Blog::query()->first();

        Log::debug($updatedBlog->toJson(JSON_PRETTY_PRINT));

        $this->assertEquals($data['title'], $updatedBlog->title);
        $this->assertEquals($data['content'], $updatedBlog->content);
    }

    public function testUpdateSuccessWithSameTitle()
    {
        $this->testUpdateSuccess();

        $data = [
            "title" => "The Future of AI in 2025!!!",
            "content" => "The Future of AI in 2025 is bruh edited again"
        ];

        $oldBlog = Blog::query()->first();

        $result = $this->blogService->update($oldBlog->unique_title, $data);

        $updatedBlog = Blog::query()->first();

        Log::debug($updatedBlog->toJson(JSON_PRETTY_PRINT));

        $this->assertEquals($data['title'], $updatedBlog->title);
        $this->assertEquals($data['content'], $updatedBlog->content);
    }

    public function testUpdateFailed()
    {
        $this->testUpdateSuccess();

        $this->expectException(ValidationException::class);

        $data = [
            "title" => "The Future of AI in 2025!!!",
            "content" => "The Future of AI in 2025 is bruh edited again"
        ];

        $oldBlog = Blog::query()->where('unique_title', "title-3")->first();

        $this->blogService->update($oldBlog->unique_title, $data);
    }

    // delete

    public function testDeleteSuccess()
    {
        $this->seed([BlogSeeder::class]);

        $blog = Blog::query()->first();

        $result = $this->blogService->delete($blog->unique_title);

        $this->assertTrue($result);

        $blog = $this->blogService->get($blog->unique_title);

        $this->assertNull($blog);
    }

    public function testDeleteFailed()
    {
        $this->expectException(ValidationException::class);
        
        $this->seed([BlogSeeder::class]);

        $this->blogService->delete("salah");
    }
}
