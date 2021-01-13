@extends('layouts.front.app')
@section('content')
<div class="col-lg-8">

<!-- Title -->
<h1 class="mt-4">{{$articles->title}}</h1>

<!-- Author -->
<p class="lead">
  {{--{{$articles->category->name}}--}}{{$articles->category}}
</p>

<hr>

<!-- Date/Time -->
<p>{{date('d M Y',strtotime($articles->created_at))}}</p>

<hr>

<!-- Preview Image -->
<img class="img-fluid rounded" src="{{asset('storage/'.$articles->file)}}" alt="">

<hr>
<p>{{--{{$articles->content}}--}} {!!$articles->content!!}</p>

</div>
@endsection