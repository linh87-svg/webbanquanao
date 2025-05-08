@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê bình luận
     </div>
    <div id="notify_comment">
      
    </div>
    <div class="table-responsive">
       <?php 
          $message = Session::get('message');
            if($message){
              echo'<span class="text-alert">', $message,'</span>';
                Session::put('message', null);
            }
       ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên người gửi</th>
            <th>Bình luận</th>
            <th>Ngày </th>
            <th>Sản phẩm</th>
          
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($comment as $key => $cmt)
         <tr>
            <!-- <td>
              @if($cmt->comment_status == 1)
                <input type="button" data-comment_status="0" data-comment_id="{{$cmt->comment_id}}" id="{{$cmt->comment_product_id}}" class="btn btn-primary btn-xs comment_status_btn" value="Chưa duyệt">

              @else
                <input type="button" data-comment_status="1" data-comment_id="{{$cmt->comment_id}}" id="{{$cmt->comment_product_id}}" class="btn btn-danger btn-xs comment_status_btn" value=" Đã duyệt">
              @endif
              
            </td> -->
            <td>{{ $cmt->comment_name}}</td>
            <td>{{ $cmt->comment}}
              <br>ShopMay:
              <ul class="list_rep">
                <style type="text/css">
                  ul.list_rep {
                      list-style-type: decimal;
                      color: royalblue;
                      margin: 5px 40px;
                  }
                </style>
                @foreach($comment_rep as $key => $comm_reply)
                    @if($comm_reply->comment_parent_comment==$cmt->comment_id)
                      <li>{{$comm_reply->comment}}</li>
                    @endif
                @endforeach
              </ul>
             
                <br><textarea class="form-control reply_comment_{{$cmt->comment_id}}" rows="5"> </textarea>
                <br><button class="btn btn-default btn-xs btn-reply-comment" data-product_id="{{$cmt->comment_product_id}}" data-comment_id="{{$cmt->comment_id}}">Trả lời</button>

             
            </td>
            <td>{{ $cmt->comment_date}}</td>
            
            <td>{{ $cmt->product->product_name}}</td>

          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
