@extends('layouts.front.app')
@section('content')
    <div class="col-lg-8">
        <h1 class="mt-4">Manajemen Artikel</h1>
        <p class="lead"><a href="{{route('article.create')}}">Tambah Artikel</a></p>
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
        @endif
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Artikel</th>
                    <th scope="col"></th>
                    <th scope="col"></th>                                                                                       
                </tr>
            </thead>
            <body>
                @foreach($articles as $index=>$article)
                <tr>
                    <td scope="row">{{$index+1}}</td>
                    <td scope="row"><a href="{{route('article.show',[$hash->encodeHex($article->id),Str::slug($article->title)])}}">{{$article->title}}</a></td>
                    <td scope="row">{{--{{$article->category->name}}--}} {{$article->category}}</td>
                    <td scope="row">{{--{{ Str::limit($article->content,115) }}--}} {!! Str::limit($article->content,115) !!}</td>
                    <td scope="row"><a href="{{route('article.edit',$article->id)}}">Edit</a></td>
                    <td scope="row">
                        <form action="{{route('article.destroy',$article->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link p-0 m-0 d-inline align-baseline">Delete</button>
                        </form> 
                    </td>            
                </tr>
                @endforeach
            </body>
        </table>

    </div>
@endsection