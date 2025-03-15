<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Page;

class DashboardController extends Controller
{
    /**
     * Summary of index
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // $post = Article::count();
        // $category = Category::count();
        // $tag = Tag::count();
        // $page = Page::count();

        if ($request->ajax()) {
            //$date = convertQueryStringToArray($request);
            return view('admin.dashboard._html', [
                // 'post' => Article::query()->whereBetween(
                //     DB::raw('DATE(created_at)'),
                //     [
                //         getDateFromFilterRequest($date)[1],
                //         getDateFromFilterRequest($date)[0]
                //     ]
                // )->count(),
                // 'category' => Category::query()->whereBetween(
                //     DB::raw('DATE(created_at)'),
                //     [
                //         getDateFromFilterRequest($date)[1],
                //         getDateFromFilterRequest($date)[0]
                //     ]
                // )->count(),
                // 'tag' => Tag::query()->whereBetween(
                //     DB::raw('DATE(created_at)'),
                //     [
                //         getDateFromFilterRequest($date)[1],
                //         getDateFromFilterRequest($date)[0]
                //     ]
                // )->count(),
                // 'page' => Page::query()->whereBetween(
                //     DB::raw('DATE(created_at)'),
                //     [
                //         getDateFromFilterRequest($date)[1],
                //         getDateFromFilterRequest($date)[0]
                //     ]
                // )->count(),
            ]);
        }
        // return view('admin.dashboard', compact('post', 'category', 'tag', 'page'));
        return view('admin.dashboard');
    }
}
