<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Auth;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Gallery;

class GalleryController extends Controller
{
    public function AuthLogin(){
      $admin_id = Auth::id();
        if($admin_id){
           return Redirect::to('dashboard');
        } else{
           return Redirect::to('login-auth')->send();
        }
    }
    public function add_gallery($product_id){
        $this->AuthLogin();
        $pro_id = $product_id;
        return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }
    public function select_gallery(Request $request){
        $this->AuthLogin();
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id' ,$product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
        <form>
                         '.csrf_field().'
        <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th>Thứ tự</th>
                                        <th>Tên hình ảnh</th>
                                        <th>Hình ảnh</th>
                                        <th>Quản lý</th>
                                      </tr>
                                    </thead>
                                    <tbody>
        ';
        if($gallery_count>0){
            $i = 0;
            foreach($gallery as $key => $gal){
                $i++;
                $output .='
                       <tr>
                        <td>'.$i.'</td>
                        <td contenteditable class="edit_gal_name" data-gal_id="'.$gal->gallery_id.'">'.$gal->gallery_name.'</td>
                        <td>
                        <img src="'.url('public/upload/gallery/'.$gal->gallery_image).'" class="img-thumbnail" width="100px" height="100px">
                        </td>
                        <td>
                        <button type="button" data-gal-id="'.$gal->gallery_id.'" class=" btn btn-xs btn-danger delete-gallery">Xóa</button>
                       
                        </td>
                    </tr>
                ';
            }
        }
        else{
            $output .='
                <tr>
                    <td colspan ="4">Sản phẩm chưa có thư viện ảnh </td>
                </tr>
            ';
        }
         $output .='
                </tbody>
                </table>
                </form>
            ';
        echo $output;
    }
    public function insert_gallery(Request $request, $pro_id){
        $this->AuthLogin();
        $get_image = $request->file('file');

        if(!$get_image || count($get_image) == 0){
             Toastr::error('Vui lòng chọn file ảnh!','Thông báo');
            return redirect()->back();
        }

        foreach($get_image as $image){
            if($image->getSize() > 2000000){
                Session::put('message', 'Không thêm được: File ảnh "'.$image->getClientOriginalName().'" lớn hơn 2MB');
                return redirect()->back();
            }

            $get_name_images = $image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_images));
            $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
            $image->move('public/upload/gallery', $new_image);

            $gallery = new Gallery();
            $gallery->gallery_name = $new_image;
            $gallery->gallery_image = $new_image;
            $gallery->product_id = $pro_id;
            $gallery->save();
        }

         Toastr::success('Thêm thư viện ảnh thành công!','Thông báo');
        return redirect()->back();
    }
    public function update_gallery_name(Request $request){
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = Gallery::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save();
    }
    public function delete_gallery(Request $request){
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('public/upload/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }
}
