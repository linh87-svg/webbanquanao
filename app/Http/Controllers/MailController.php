<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Session;
use App\Product;
use App\Coupon;
use App\Users;
use Toastr;
use Mail;

class MailController extends Controller
{
   
    public function send_coupon($coupon_quantity, $coupon_condition, $coupon_number, $coupon_code){
        
        $user_vip = Users::where('customer_vip', 1)->get();

        $coupon = Coupon::where('coupon_code', $coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
         $title_mail = "Mã khuyến mãi ngày".''.$now;
         $data = [];
         foreach($user_vip as $vip){
            $data ['email'][] = $vip->user_email;
         }

         $coupon = array(
            'start_coupon' => $start_coupon,
            'end_coupon'=>$end_coupon,
            'coupon_quantity' =>$coupon_quantity,
            'coupon_condition'=>$coupon_condition,
            'coupon_number'=>$coupon_number,
            'coupon_code' =>$coupon_code
         );
         Mail::send('pages.send_coupon', ['coupon'=>$coupon], function($message) use ($title_mail, $data){
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'], $title_mail);
         });  
         Toastr::success('Gửi mã thành công!','Thông báo');  
         return redirect()->back();
    }
    public function mail_example(){

        return view('pages.send_coupon');
    }

    public function forget_password(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.checkout.forget_pass')->with('category',$cate_product);
    }
    public function recover_pass(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu.com".' '.$now;
        $customer = Users::where('user_email','=',$data['email_account'])->get();
        foreach($customer as $key => $value){
            $user_id = $value->user_id;
        }
        if($customer){
            $count_customer = $customer->count();
            if($count_customer==0){
                Toastr::error('Email chưa được đăng ký để khôi phục mật khẩu!','Thông báo');
                return redirect()->back();
            }
            else{
                $token_random = Str::random();
                $customer = Users::find($user_id);
                $customer->customer_token = $token_random;
                $customer->save();
                //send mail
                $to_email = $data['email_account'];
                $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);
                $data = array("name"=>$title_mail,"body"=>$link_reset_pass,'email'=>$data['email_account']);
                Mail::send('pages.checkout.forget_pass_notify',['data'=>$data],function($message) use ($title_mail,$data){
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'],$title_mail);
                });
                Toastr::success('Gửi mail thành công vui lòng kiểm tra mail của bạn!','Thông báo');
                return redirect()->back();
            }
        }
        
    }
    public function update_new_pass(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.checkout.new_pass')->with('category',$cate_product);
    }
    public function update_pass(Request $request){
        $data = $request->all();
        $token_random = Str::random();
        $customer = Users::where('user_email','=',$data['email'])->where('customer_token','=',$data['token'])->get();
        $count = $customer->count();
        if($count > 0){
            foreach($customer as $key => $cus){
                $user_id = $cus->user_id;
            }
            $reset = Users::find($user_id);
            $reset->user_password = md5($data['password_account']);
            $reset->customer_token = $token_random;
            $reset->save();
            Toastr::success('Cập nhật mật khẩu thành công!','Thông báo');
            return redirect('login-checkout');
        }else{
            Toastr::error('Cập nhật mật khẩu không thành công!','Thông báo');
            return redirect('login-checkout');
        }
    }
}
