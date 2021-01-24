@extends('layouts.back.app')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    <h1>Halaman Administrator</h1>
    <p>Ini adalah halaman Administrator!</p>
@endsection