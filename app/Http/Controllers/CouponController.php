<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use DB;
use Session;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponController extends Controller
{
    public function AuthLogin(){
          $admin_id = Auth::id();
          if($admin_id){
           return Redirect::to('dashboard');
          }else{
           return Redirect::to('login-auth')->send();
          }
    }
    public function insert_coupon(){
        $this->AuthLogin();
            
        return view('admin.coupon.insert_coupon');
    }
    public function insert_coupon_code(Request $request){
        $this->AuthLogin();
       $data = $request->validate([
        'coupon_name'       => 'required|string|max:255',
        'coupon_code'       => 'required|string|max:50|unique:tbl_coupon,coupon_code',
        'coupon_date_start' => 'required|date',
        'coupon_date_end'   => 'required|date|after:coupon_date_start',
        'coupon_quantity'   => 'required|numeric|min:1',
        'coupon_condition'  => 'required|in:1,2', 
        'coupon_number'     => 'required|numeric'
    ], [
        'coupon_name.required'        => 'Tên mã giảm giá không được để trống!',
        'coupon_code.required'        => 'Mã giảm giá không được để trống!',
        'coupon_code.unique'          => 'Mã giảm giá đã tồn tại, vui lòng chọn mã khác!',
        'coupon_date_start.required'  => 'Ngày bắt đầu không được để trống!',
        'coupon_date_start.date'      => 'Ngày bắt đầu không đúng định dạng!',
        'coupon_date_end.required'    => 'Ngày kết thúc không được để trống!',
        'coupon_date_end.date'        => 'Ngày kết thúc không đúng định dạng!',
        'coupon_date_end.after'       => 'Ngày kết thúc phải lớn hơn ngày bắt đầu!',
        'coupon_quantity.required'    => 'Số lượng không được để trống!',
        'coupon_quantity.numeric'     => 'Số lượng phải là số nguyên!',
        'coupon_quantity.min'         => 'Số lượng phải lớn hơn hoặc bằng 1!',
        'coupon_condition.required'   => 'Loại giảm giá không được để trống!',
        'coupon_condition.in'         => 'Loại giảm giá không hợp lệ (1: giảm theo %; 2: giảm theo tiền)!',
        'coupon_number.required'      => 'Mức giảm giá không được để trống!',
        'coupon_number.numeric'     => 'Số tiền phải là số nguyên!'
    ]);
        $coupon = new Coupon();

        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_date_start = $data['coupon_date_start'];
        $coupon->coupon_date_end = $data['coupon_date_end'];
        $coupon->coupon_quantity = $data['coupon_quantity'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->save();

        Toastr::success('Thêm mã giảm giá thành công!','Thông báo');
        return Redirect::to('insert-counpon');
    }
    public function list_coupon(){
        $this->AuthLogin();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');

        $coupon = Coupon::orderBy('coupon_id', 'DESC')->get();
         return view('admin.coupon.list_coupon')->with(compact('coupon', 'today'));
    }

    public function delete_coupon($coupon_id){
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();

        Toastr::success('Xóa mã giảm giá thành công!','Thông báo');
        return Redirect::to('list-coupon');
    }

    
    public function check_coupon(Request $request){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $data = $request->all();
        if(Session::get('user_id')){
            $coupon = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>=',$today)->where('coupon_used','LIKE','%'.Session::get('user_id').'%')->first();
            if($coupon){
                 return redirect()->back()->with('message','Mã giảm giá đã được sử dụng, vui lòng nhập mã khác!');
            }else{
                $coupon_login = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status',1)->whereDate('coupon_date_end','>=',$today)->first();
                if($coupon_login){
                        $count_coupon = $coupon_login->count();
                        $quantity = $coupon_login->coupon_quantity;
                    if($quantity <= 0){
                        return redirect()->back()->with('message','Mã giảm giá đã hết lượt sử dụng!');
                    }
                    if( $count_coupon > 0){
                        $coupon_session = Session::get('coupon');
                        if( $coupon_session == true){
                            $is_avaiable = 0;
                            if($is_avaiable == 0){
                                $cou[] = array(
                                    'coupon_code' => $coupon_login->coupon_code,
                                    'coupon_condition' => $coupon_login->coupon_condition,
                                    'coupon_number' => $coupon_login->coupon_number,
                                );
                                Session::put('coupon',$cou);
                            }
                        }else{
                             $cou[] = array(
                                    'coupon_code' => $coupon_login->coupon_code,
                                    'coupon_condition' => $coupon_login->coupon_condition,
                                    'coupon_number' => $coupon_login->coupon_number,
                                );
                                Session::put('coupon',$cou);
                        }
                        Session::save();
                        return redirect()->back()->with('message','Thêm mã giảm giá thành công');
                    }
                }else{
                    return redirect()->back()->with('message','Mã giảm giá không tồn tại hoặc đã hết hạn');
                }
            }
        }else{
        $coupon = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>=',$today)->first();
        if($coupon){
                $count_coupon = $coupon->count();
            if( $count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if( $coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable == 0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                     $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                }
                Session::save();
                return redirect()->back()->with('message','Thêm mã giảm giá thành công');
            }
        }else{
            return redirect()->back()->with('message','Mã giảm giá không tồn tại hoặc đã hết hạn');
        }
    }
  

    }
}
