<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hashids\Hashids;
use App\Models\Category;
use App\Models\Article;
class HomeController extends Controller
{
    //
    public function index(){
        $hash=new Hashids();
        $articles=Article::inRandomOrder()->orderBy('id','DESC')->paginate(5);
        return view('home',compact('articles','hash'));
    }
}
