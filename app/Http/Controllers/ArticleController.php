<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hashids\Hashids;
use App\Models\Category;
use App\Models\Article;
use Path\To\DOMDocument;
use Intervention\Image\ImageManagerStatic as Image;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return view('article.manage.index',compact('articles','hash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::get();
        return view('article.manage.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    
     public function store(Request $request)
    {
        //
        $rules=[
            'category'=>'required',
            'title'=>'required|unique:articles|min:5|max:20',
            //'content'=>'required|min:20|max:200',
            'content'=>'required|min:20',
            'file'=>'required|max:500|mimes:jpeg,png,jpg',
        ];
        $messages=[
            'category.required'=>' Kategori tidak boleh kosong',
            'title.required'=>'judul tidak boleh kosong',
            'title.unique'=>' judul sudah digunakan',
            'title.min'=>' judul  karakter terlalu pendek',
            'title.max'=>' judul karakter terlalu panjang',
            'content.required'=>'artikel tidak boleh kosong',
            'content.min'=>' artikel  karakter terlalu pendek',
            'content.max'=>' artikel karakter terlalu panjang',
            'file.required'=>'file tidak boleh kosong',
            'file.max'=>' file ukurannya terlalu besar',
        ];
        $this->validate($request,$rules,$messages);

        $storage="storage/content";
        $dom=new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($request->content,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();
        $images=$dom->getElementsByTagName('img');
        foreach($images as $img){
            $src=$img->getAttribute('src');
            if(preg_match('/data:image/',$src)){
                preg_match('/data:image\/(?<mime>.*?)\;/',$src,$groups);
                $mimetype=$groups['mime'];
                $fileNameContent=uniqid();
                $fileNameContentRand=substr(md5($fileNameContent),6,6).'_'.time();
                $filepath=("$storage/$fileNameContentRand.$mimetype");
                $image=Image::make($src)
                    ->resize(1200,1200)
                    ->encode($mimetype,100)
                    ->save(public_path($filepath));
                $new_src=asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src',$new_src);
                $img->setAttribute('class','img-responsive');
            }
        }

        $fileName=time().'.'.$request->file->extension();
        $request->file('file')->storeAs('public',$fileName);
        $articles=Article::create([
           // 'category_id'=>$request->category,
            'title'=>$request->title,
            //'content'=>$request->content,
            'content'=>$dom->saveHTML(),
            'file'=>$fileName,
        ]);

        $categories=$request->category;
        $articles->category()->sync($categories);
        /*$articles=New Article();
        $articles->category_id=$request->category;
        $articles->title=$request->title;
        $articles->content=$request->content;
        $articles->save();*/
        return back()->with('success','Posting data sukses!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug)
    {
        //
        $hash=new Hashids();
        //$articles=Article::whereId($id)->first();
        $articles=Article::leftjoin('article_categories as a','a.article_id','=','articles.id')
        ->leftjoin('categories as b','a.category_id','=','b.id')
        ->select(
            'articles.id','articles.title','articles.content','articles.file','articles.created_at','a.article_id',
            \DB::raw('GROUP_CONCAT(b.name) as category')
        )
        ->groupBy('articles.id','a.article_id')
        ->where('articles.id',$hash->decodeHex($id))
        ->first();
        return view('article.show',compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories=Category::get();
        $articles=Article::find($id);
        return view('article.manage.edit',compact('categories','articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $articles=Article::whereId($id)->first();
        if($request->hasFile('file')){
            $fileCheck='required|max:500|mimes:jpeg,png,jpg';
        }
        else{
            $fileCheck='max:500|mimes:jpeg,png,jpg';
        }
        if($articles->title==$request->title){
            $title='required|min:5|max:20';
        }
        elseif($request->title==''){
            $title='required|unique:articles|min:5|max:20';
        }
        elseif($articles->title==''){
            $title='required|unique:articles|min:5|max:20';
        }
        elseif(!empty($request->title)){
            $title='required|unique:articles|min:5|max:20';
        }
        elseif(!empty($articles->title)){
            $title='required|min:5|max:20';
        }
        else{
            $title='required|unique:articles|min:5|max:20';
        }
        $rules=[
            'category'=>'required',
            'title'=>$title,
            //'content'=>'required|min:20|max:200',
            'content'=>'required|min:20',
            'file'=>$fileCheck,
        ];
        $messages=[
            'category.required'=>' Kategori tidak boleh kosong',
            'title.required'=>'judul tidak boleh kosong',
            'title.unique'=>' judul sudah digunakan',
            'title.min'=>' judul  karakter terlalu pendek',
            'title.max'=>' judul karakter terlalu panjang',
            'content.required'=>'artikel tidak boleh kosong',
            'content.min'=>' artikel  karakter terlalu pendek',
            'content.max'=>' artikel karakter terlalu panjang',
            'file.required'=>'file tidak boleh kosong',
            'file.max'=>' file ukurannya terlalu besar',
        ];
        $this->validate($request,$rules,$messages);
        if($request->hasFile('file')){
            if(\File::exists('storage/'.$articles->file)){
                \File::delete('storage/'.$articles->file);
            }
            $fileName=time().'.'.$request->file->extension();
            $request->file('file')->storeAs('public',$fileName);
         }
         if($request->hasFile('file')){
             $checkFileName=$fileName;
         }
         else{
            $checkFileName=$articles->file;
         }


         $storage="storage/content";
         $dom=new \DOMDocument();
         libxml_use_internal_errors(true);
         $dom->loadHTML($request->content,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
         libxml_clear_errors();
         $images=$dom->getElementsByTagName('img');
         foreach($images as $img){
             $src=$img->getAttribute('src');
             if(preg_match('/data:image/',$src)){
                 preg_match('/data:image\/(?<mime>.*?)\;/',$src,$groups);
                 $mimetype=$groups['mime'];
                 $fileNameContent=uniqid();
                 $fileNameContentRand=substr(md5($fileNameContent),6,6).'_'.time();
                 $filepath=("$storage/$fileNameContentRand.$mimetype");
                 $image=Image::make($src)
                     ->resize(1200,1200)
                     ->encode($mimetype,100)
                     ->save(public_path($filepath));
                 $new_src=asset($filepath);
                 $img->removeAttribute('src');
                 $img->setAttribute('src',$new_src);
                 $img->setAttribute('class','img-responsive');
             }
         }

         
        $articles->update([
            //'category_id'=>$request->category,
            'title'=>$request->title,
            //'content'=>$request->content,
            'content'=>$dom->saveHTML(),
            'file'=>$checkFileName,
        ]);
        $categories=$request->category;
        $articles->category()->sync($categories);
       /* $articles=Article::find($request->id);
        $articles->category_id=$request->category;
        $articles->title=$request->title;
        $articles->content=$request->content;
        $articles->save();*/
        
        return back()->with('success','Ubah data sukses!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $articles=Article::whereId($id)->first();
        if(\File::exists('storage/'.$articles->file)){
            \File::delete('storage/'.$articles->file);
        }
        Article::whereId($id)->delete();
        return back()->with('success','Hapus data sukses!');
    }
}
