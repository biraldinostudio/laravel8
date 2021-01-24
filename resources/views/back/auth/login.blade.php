<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Halaman login Administrator</title>
<link rel="stylesheet" href="{{asset('back/vendor/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login Administrator</h3></div>
                            <div class="card-body">
                                @if (Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{Session::get('success')}}
                                    </div>
                                @endif
                            <form method="POST" action="{{route('admin.login')}}" novalidate>
                                @csrf
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control py-4 @error('email') is-invalid @enderror" id="inputEmailAddress" type="email" placeholder="Isi email" name="email" value="{{old('email')}}" />
                                     @error('email')
                                        <span class="invalid-feedback"><strong>{{$message}}</strong></span>
                                     @enderror   
                                </div>
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputPassword">Password</label>
                                        <input class="form-control py-4 @error('email') is-invalid @enderror" id="inputPassword" type="password" placeholder="Isi password" name="password"/>
                                        @error('password')
                                            <span class="invalid-feedback"><strong>{{$message}}</strong></span>
                                        @enderror  
                                    </div>
                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary">{{__('login')}}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>