@extends('layouts.front.app')
@section('content')
<div class="col-md-8">

<h1 class="my-4">Halaman Home
  <small>Artikel Terbaru</small>
</h1>
@foreach($articles as $article)
<!-- Blog Post -->
<div class="card mb-4">
  <img class="card-img-top" src="{{asset('storage/'.$article->file)}}" alt="Card image cap">
  <div class="card-body">
    <h2 class="card-title">{{$article->title}}</h2>
    <p class="card-text">{!!Str::limit($article->content,200)!!}</p>
    <a href="{{route('article.show',[$hash->encodeHex($article->id),Str::slug($article->title)])}}" class="btn btn-primary">Read More &rarr;</a>
  </div>
  <div class="card-footer text-muted">
    {{date('d M Y',strtotime($article->created_at))}}

  </div>
</div>
@endforeach

</div>
@endsection
