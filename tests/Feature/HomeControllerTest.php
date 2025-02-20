<?php

namespace Tests\Feature;

use App\Services\BlogService;
use Database\Seeders\BlogSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    private BlogService $blogService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->blogService = App::make(BlogService::class);
    }

    public function testIndex()
    {
        $this->seed([UserSeeder::class, BlogSeeder::class]);

        $response = $this->get("/");

        $blogs = $this->blogService->getAll();

        $titles = array_map(function($blog) {
            return $blog->title;
        }, $blogs);

        $created_ats = array_map(function($blog) {
            return $blog->created_at->format('Y-m-d');
        }, $blogs);

        $response->assertSeeTextInOrder($titles);
        $response->assertSeeTextInOrder($created_ats);
    }
}
