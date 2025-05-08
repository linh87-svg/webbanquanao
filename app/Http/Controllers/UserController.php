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
use Toastr;
use Auth;

class UserController extends Controller

{
   public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }
    public function index(){
      $this->AuthLogin();
     $admin = Admin::with('roles')->orderBy('admin_id','ASC')->paginate(5);
        return view('admin.users.all_users')->with(compact('admin'));
   }
   public function add_users(){
      $this->AuthLogin();
        return view('admin.users.add_users');
   }
   public function delete_user_roles($admin_id){
      $this->AuthLogin();
      if(Auth::id()== $admin_id){
         Toastr::error('Bạn không được phân quyền chính mình','Thông báo');
         return redirect()->back();
      }
      $admin = Admin::find($admin_id);
      if($admin){
         $admin ->roles()->detach();
         $admin->delete();
      }
      Toastr::success('Xóa user thành công','Thông báo');
      return redirect()->back();
   }

   //phân quyền
   public function assign_roles(Request $request){

      if(Auth::id()==$request->admin_id){
         Toastr::error('Bạn không được phân quyền chính mình','Thông báo');
         return redirect()->back();
      }
       
        $user = Admin::where('admin_email',$request->admin_email)->first();
        // Kiểm tra nếu cả hai quyền đều được chọn
          if ($request->user_role && $request->admin_role) {
              Toastr::error('Chỉ được chọn một quyền (User hoặc Admin)', 'Thông báo');
              return redirect()->back();
          }

          // Kiểm tra nếu không có quyền nào được chọn
          if (!$request->user_role && !$request->admin_role) {
              Toastr::error('Vui lòng chọn một quyền', 'Thông báo');
              return redirect()->back();
          }

        $user->roles()->detach();
       
        if($request->user_role){
           $user->roles()->attach(Roles::where('name','user')->first());     
        }
        if($request->admin_role){
           $user->roles()->attach(Roles::where('name','admin')->first());     
        }
        Toastr::success('Cấp quyền thành công!','Thông báo');
        return redirect()->back();
   }
   public function store_users(Request $request){
       $data = $request->validate([
         'admin_name' => 'required|regex:/^[a-zA-Z\s]/|max:255',
        'admin_phone' => 'required|digits_between:10,15',
        'admin_email' => 'required|email|unique:tbl_admin,admin_email',
        'admin_password' => 'required|min:6',
    ], [
        'admin_name.required' => 'Vui lòng nhập tên nhân viên',
        'admin_name.regex' => 'Họ tên chỉ được nhập chữ cái',
        'admin_phone.required' => 'Vui lòng nhập số điện thoại',
        'admin_phone.digits_between' => 'Số điện thoại phải có từ 10 đến 15 chữ số',
        'admin_email.required' => 'Vui lòng nhập email',
        'admin_email.email' => 'Email không hợp lệ',
        'admin_email.unique' => 'Email đã tồn tại',
        'admin_password.required' => 'Vui lòng nhập mật khẩu',
        'admin_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
       ]);
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        $admin->roles()->attach(Roles::where('name','user')->first());
        
        Toastr::success('Thêm nhân viên thành công', 'Thông báo');
      return Redirect::to('users');
   }
   
}
