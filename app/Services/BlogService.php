<?php

namespace App\Services;

use App\Models\Blog;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    private function createUniqueTitle(string $title): string
    {
        $unique_title = preg_replace('/[^a-z0-9 ]/', '', strtolower($title));
        $unique_title = str_replace(' ', '-', $unique_title);

        return $unique_title;
    }

    private function checkUniqueTitle(string $unique_title): string
    {

        $blog = $this->get($unique_title);

        if ($blog) {
            throw new ValidationException("The title is already exists");
        }

        return $unique_title;
    }

    public function create(array $data): bool
    {
        $user = Auth::user();

        $unique_title = $this->checkUniqueTitle($this->createUniqueTitle($data['title']));

        $blog = new Blog($data);
        $blog->user_id = $user->id;
        $blog->unique_title = $unique_title;
        $blog->save();

        return true;
    }

    public function get(string $uniqueTitle): ?Blog
    {
        $blog = Blog::query()->where("unique_title", $uniqueTitle)->first();
        return $blog;
    }

    public function getAll(): array
    {
        $blogs = Blog::query()->get()->all();
        return $blogs;
    }

    public function update(string $uniqueTitle, array $data): bool
    {
        $blog = Blog::query()->where("unique_title", $uniqueTitle)->first();

        $unique_title = $this->createUniqueTitle($data['title']);

        if ($blog->unique_title != $unique_title) {
            $this->checkUniqueTitle($unique_title);

            $blog->unique_title = $unique_title;
        }

        $blog->fill($data);
        $blog->save();

        return true;
    }

    public function delete(string $uniqueTitle): bool
    {
        $blog = $this->get($uniqueTitle);

        if ($blog) {
            $blog->delete();
        } else {
            throw new ValidationException("The blog is not found");
        }
        
        return true;
    }
}
