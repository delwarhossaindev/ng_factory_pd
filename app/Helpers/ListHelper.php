<?php

use App\Models\Tag;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use App\Models\Article;
use App\Models\Backup;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Website;

if (!function_exists('tagList')) {
    function tagList()
    {
        return Tag::active()->get()
            ->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name
                ];
            });
    }
}

if (!function_exists('category_list')) {
    function category_list()
    {
        return Category::query()
            ->active()
            ->where('parent_id', NULL)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('categories')) {
    function categories()
    {
        return Category::where('status', true)
            ->withCount('posts')
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('permission_list')) {
    function permission_list()
    {
        return Permission::orderBy('description', 'asc')->get();
    }
}

if (!function_exists('role_list')) {
    function role_list()
    {
        return Role::orderBy('name', 'asc')
            ->get();
    }
}

if (!function_exists('role_with_user_count_list')) {
    function role_with_user_count_list()
    {
        return Role::withCount('users')->get();
    }
}

if (!function_exists('trash_posts')) {
    function trash_posts()
    {
        return Article::with('author')
            ->trash()
            ->get();
    }
}

if (!function_exists('user_with_count_post')) {
    function user_with_count_post()
    {
        return User::active()->withCount('posts')->get();
    }
}

if (!function_exists('trash_users')) {
    function trash_users()
    {
        return User::with('posts')
            ->trash()
            ->get();
    }
}

if (!function_exists('trash_tags')) {
    function trash_tags()
    {
        return Tag::with('posts')
            ->trash()
            ->get();
    }
}

if (!function_exists('trash_categories')) {
    function trash_categories()
    {
        return Category::with('posts')
            ->trash()
            ->get();
    }
}

if (!function_exists('trash_pages')) {
    function trash_pages()
    {
        return Page::trash()->get();
    }
}

if (!function_exists('website_slogan')) {
    function website_slogan()
    {
        return Website::first();
    }
}
