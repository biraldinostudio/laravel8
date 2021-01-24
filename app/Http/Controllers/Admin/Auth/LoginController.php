<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\Admin;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    protected $guard='adminMiddle';
    protected $redirectTo='admin/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard(){
        return auth()->guard('adminMiddle');
    }

    public function loginForm(){
        if(auth()->guard('adminMiddle')->user()){
            return back();
        }
        return view('back.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->guard('adminMiddle')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            \Session::put('success','Anda berhasil login!');
            return redirect()->route('admin.home');
        } else {
            return back()->with('error','email atau password salah!');
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('adminMiddle')->logout();
        \Session::flush();
        \Session::put('success','Anda berhasil keluar dari halaman administrator!');
        return redirect(url('admin/login'));
    }
}
