<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use App\Users;
use Auth;
use Toastr;

class CustomerController extends Controller
{
    public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }
    public function index()
    {
        $this->AuthLogin();

        $customers = Users::with(['orders' => function ($query) {
            $query->select('user_id', DB::raw('SUM(tbl_order_details.product_price * tbl_order_details.product_quantity) as total_spent'))
                  ->join('tbl_order_details', 'tbl_order.order_code', '=', 'tbl_order_details.order_code')
                  ->groupBy('tbl_order.user_id');
        }])->paginate(10);

        foreach ($customers as $customer) {
            $totalSpent = $customer->orders->sum('total_spent');

            // Gán vào biến tạm để hiển thị
            $customer->total_spent = $totalSpent; 
        }

        return view('admin.customer.all_customer', compact('customers'));
        }

    // Khóa / Mở khóa tài khoản khách hàng
    public function toggleStatus($user_id)
    {
        $this->AuthLogin();
        $customer = Users::findOrFail($user_id); 
        $customer->user_status = !$customer->user_status; // Đảo trạng thái
        $customer->save();

        $message = $customer->user_status ? 'Mở khóa khách hàng thành công!' : 'Khóa khách hàng thành công!';
       Toastr::success($message, 'Thông báo');

        return redirect()->back(); 
    }

    
}
