<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Main;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticle = Article::count();
        $totalArticlePublished = Article::isPublished()->count();

        // dd($totalPropertyVisit);
        return view('admin.dashboard', compact(
            'totalArticle',
            'totalArticlePublished',
        ));
    }
}
