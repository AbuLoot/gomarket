<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\News;

class NewsController extends Controller
{
    public function news()
    {
        $newsCategories = Page::where('slug', 'news')->get()->toTree();
        $news = News::orderBy('sort_id')->paginate(10);

        return view('pages.news', compact('news', 'newsCategories'));
    }

    public function newsCategory($page)
    {
        $newsCategory = Page::where('slug', $page)->first();
        $newsCategories = Page::where('slug', 'news')->get()->toTree();
        $news = News::where('page_id', $newsCategory->id)->paginate(10);

        return view('pages.news-category', compact('newsCategory', 'news', 'newsCategories'));
    }

    public function newsSingle($page)
    {
        $newsSingle = News::where('slug', $page)->first();

        return view('pages.news-single', compact('newsSingle'));
    }
}
