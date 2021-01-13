<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hashids\Hashids;
use App\Models\Article;
class WelcomeController extends Controller
{
    //
    public function index(){
        $hash=new Hashids();
        $articles=Article::inRandomOrder()->orderBy('id','DESC')->paginate(5);    
        return view('welcome',compact('articles','hash'));
    }
}
