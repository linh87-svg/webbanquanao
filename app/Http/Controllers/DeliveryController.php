<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Province;
use App\District;
use App\Wards;
use App\Feeship;
use Auth;
use Toastr;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class DeliveryController extends Controller
{
    public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }
    public function delivery(Request $request){
        $this->AuthLogin();
        $province = Province::orderBy('province_id','ASC')->get();
        
        return view('admin.delivery.add_delivery')->with(compact('province'));
    }
    public function select_delivery(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        if($data['action']){
            $output ='';
            if($data['action'] == "province"){

                $select_district = District::where('province_id',$data['ma_id'])->orderBy('district_id', 'ASC')->get();
                 $output.='<option >Chọn quận huyện</option>';
                foreach($select_district as $key => $district ){
                $output.='<option value ="'.$district->district_id.'">'.$district->name.'</option>';
                }
            }else{

                $select_wards = Wards::where('district_id',$data['ma_id'])->orderBy('wards_id', 'ASC')->get();
                 $output.='<option >Chọn xã phường thị trấn</option>';
                foreach($select_wards as $key => $wards ){
                $output.='<option value ="'.$wards->wards_id.'">'.$wards->name.'</option>';
                }
            }
        }
        echo $output;
    }
    public function insert_delivery(Request $request) {
        $this->AuthLogin();
        $data = $request->all();

        $exists = Feeship::where('province_id', $data['province'])
                         ->where('district_id', $data['district'])
                         ->where('wards_id', $data['wards'])
                         ->exists();

        if ($exists) {
            return response()->json(['message' => 'Phí vận chuyển đã tồn tại!']);
        }

        $fee_ship = new Feeship();
        $fee_ship->province_id = $data['province'];
        $fee_ship->district_id = $data['district'];
        $fee_ship->wards_id = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();

        return response()->json(['message' => 'Thêm phí vận chuyển thành công!']);
}
    public function select_feeship(){
        $this->AuthLogin();
        $feeship = Feeship::orderBy('fee_id', 'desc')->get();
        $output = '';
        $output .= '<div class="table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên tỉnh thành</th>
                    <th>Tên quận huyện</th>
                    <th>Tên xã phường thị trấn</th>
                    <th>Phí ship</th>
                </tr>
            </thead>
            <tbody>
            ';
            foreach($feeship as $key => $fee){
                $output .='
                <tr>
                    <td>'.$fee->province->name.'</td>
                    <td>'.$fee->district->name.'</td>
                    <td>'.$fee->wards->name.'</td>
                    <td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
                </tr>
                ';
            }  
            $output .='
            </tbody>
            </table>
            </div>
            ';
        echo $output;    
    }
    public function update_delivery(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'], '.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
        Toastr::success('Cập nhật phí vận chuyển thành công!','Thông báo');
    }

}
