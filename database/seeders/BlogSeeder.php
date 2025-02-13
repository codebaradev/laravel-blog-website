<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where("username", "=", "codebara")->first();
        for ($i = 0; $i < 5; $i++) {
            Blog::query()->create([
                "user_id" => $user->id,
                "unique_title" => "title_$i",
                "title" => "Blog $i",
                "content" => "Blog Content $i"
            ]);
        }
    }
}
