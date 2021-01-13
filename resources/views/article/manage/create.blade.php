@extends('layouts.front.app')
@section('content')
<div class="col-lg-8">
        <h1 class="mt-4">Create Artikel</h1>
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
        @endif
        <form method="POST" action="{{route('article.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Kategori</label>
                <select class="selectpicker form-control @error('category') is-invalid @enderror" name="category[]" multiple data-live-search="true">
                    {{--<option value="" @if(old('category')=='' or old('category')==0) selected="selected" @endif>Pilih kategori</option>--}}
                    @foreach($categories as $category)
                        {{--<option value="{{$category->id}}" @if(old('category')==$category->id) selected="selected" @endif>{{$category->name}}</option>--}}
                        <option value="{{$category->id}}" @if(in_array($category->id,old('category',[]))) selected="selected" @endif>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title')}}">
                @error('title')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Artikel</label>
                <textarea id="summernote" class="form-control @error('content') is-invalid @enderror" rows="4" name="content">{{old('content')}}</textarea>
                @error('content')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>File</label><br>
                <input type="file" class="form-control-form @error('file') is-invalid @enderror" name="file" accept="image/*">
                @error('file')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create</button>            
        </form>
</div>        
@endsection
@push('styles')
    <link href="{{asset('front/select/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/vendor/summernote/summernote.min.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{asset('front/select/js/bootstrap-select.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/vendor/summernote/summernote.min.js')}}"></script>
    <script type="text/javascript">
        /*$(document).ready(function(){
            $('#summernote').summernote();
        })*/

        $('#summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
            ],
            height:400,
            popatmouse:true
        });
    </script>
@endpush