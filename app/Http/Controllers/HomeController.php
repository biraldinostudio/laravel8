<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hashids\Hashids;
use App\Models\Category;
use App\Models\Article;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hash=new Hashids();
        //$articles=Article::orderBy('id','DESC')->paginate(5);
        $articles=Article::leftjoin('article_categories as a','a.article_id','=','articles.id')
            ->leftjoin('categories as b','a.category_id','=','b.id')
            ->select(
                'articles.id','articles.title','articles.content','a.article_id',
                \DB::raw('GROUP_CONCAT(b.name) as category')
            )
            ->groupBy('articles.id','a.article_id')
            ->paginate(5);
        //return view('article.index');
        return view('home',compact('articles','hash'));
    }
}
