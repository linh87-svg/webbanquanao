<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Admin;
use App\Roles;
use Auth;
use Hash;
use Toastr;

class AuthController extends Controller
{
    public function register_auth(){
        return view('admin.user_login.register');
    }
    
    public function login_auth(){
        return view('admin.user_login.login_auth');
    }
    public function login(Request $request){

        $data = $request->validate([
        'admin_email' => 'required|email||max:50',
        'admin_password' => [
            'required',
            'max:255',
            'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/'
        ],
    ], [
        'admin_email.required' => 'Email không được để trống!',
        'admin_email.email' => 'Email không hợp lệ. Vui lòng nhập đúng định dạng email!',
        
        'admin_password.required' => 'Mật khẩu không được để trống!',
        'admin_password.max' => 'Mật khẩu không được quá 255 ký tự!',
        'admin_password.regex' => 'Mật khẩu phải có ít nhất một chữ hoa, một chữ thường và một số!',
        
    ]);

        $admin = Admin::where('admin_email', $request->admin_email)->first();

       if ($admin && md5($request->admin_password) === $admin->admin_password) {
            Auth::login($admin);
            Toastr::success('Đăng nhập thành công!', 'Thông báo');
            return redirect('/dashboard');
        } else {
            Toastr::error('Email hoặc mật khẩu không đúng!', 'Thông báo');
                return redirect('/login-auth');
        }
        
    }
       
    public function logout_auth(){
        Auth::logout();
        return redirect('/login-auth');
    }
    public function show_pass()
    {
        return view('admin.user_login.reset_pass');
    }

    public function reset_password(Request $request)
    {
        if (!Auth::check()) {
        return redirect('/show-pass')->withErrors(['error' => 'Bạn cần đăng nhập để đổi mật khẩu!']);
        }
        $admin = Auth::user();

        if (!$admin) {
            return redirect('/show-pass')->withErrors(['error' => 'Không tìm thấy tài khoản!']);
        }
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'max:255',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
                'confirmed'
            ],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại!',
            'new_password.required' => 'Mật khẩu mới không được để trống!',
            'new_password.regex' => 'Mật khẩu mới phải có ít nhất một chữ hoa, một chữ thường và một số!',
            'new_password.confirmed' => 'Mật khẩu xác nhận không trùng khớp!',
        ]);
        if (md5($request->current_password) !== $admin->admin_password) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng!']);
        }
        $admin->admin_password = md5($request->new_password);
        $admin->save();
        Toastr::success('Đổi mật khẩu thành công!','Thông báo');
        return redirect('/show-pass');
    }
}
