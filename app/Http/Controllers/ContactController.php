<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Contact;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();
class ContactController extends Controller
{
   public function lien_he(Request $request){
     // seo
        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "Liên hệ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $contact = Contact::where('info_id',1)->get();
    return view('pages.lienhe.contact')->with('category',$cate_product)->with('colors',$colors)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('contact',$contact);
   }
    public function information(Request $request){
        $contact = Contact::where('info_id', 1)->get();
        return view('admin.information.add_information')->with(compact('contact'));
    }

    public function save_info(Request $request){
        $data = $request->validate([
            'info_contact' => 'required|string',
            'info_map' => 'required|string',
            'info_fanpage' => 'required|string',
        ], 
        [
            'info_contact.required' => 'Thông tin liên hệ không được để trống',
            'info_map.required' => 'Bản đồ không được để trống',
            'info_fanpage.required' => 'Fanpage không được để trống',
        ]);
        $contact = new Contact();
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];
        $contact->save();
        Toastr::success('Cập nhật thông tin thành công!','Thông báo');
        return redirect()->back();
    }
    public function update_info(Request $request, $info_id){
        $data = $request->validate([
            'info_contact' => 'required|string',
            'info_map' => 'required|string',
            'info_fanpage' => 'required|string',
        ], 
        [
            'info_contact.required' => 'Thông tin liên hệ không được để trống',
            'info_map.required' => 'Bản đồ không được để trống',
            'info_fanpage.required' => 'Fanpage không được để trống',
        ]);
        $contact = Contact::find($info_id);
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];
        $get_images = $request->file('info_image');
        $path = 'public/upload/contact/';
        if ($get_images) {
            unlink($path.$contact->info_image);
            $get_name_images = $get_images->getClientOriginalName();
            $name_image = current(explode('.', $get_name_images));
            $new_image = $name_image . rand(0, 99) . '.' . $get_images->getClientOriginalExtension();
            $get_images->move($path, $new_image);
            $contact->info_image = $new_image;
        }
        $contact->save();
        Toastr::success('Cập nhật thông tin thành công!','Thông báo');
        return redirect()->back();
    }
}
