@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
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
            <th>Thứ tự</th>
            <th>Mã đơn hàng</th>
            <th>Ngày tháng năm</th>
            <th>Tình trạng đơn hàng</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
          $i =0; 
          @endphp

          @foreach($order as $key => $ord)
          @php
          $i++;
          @endphp
         <tr>
            <td><i>{{$i}}</i></td>
            <td>{{$ord->order_code}}</td>
            <td>{{$ord->created_at}}</td>
            <td>@if($ord->order_status==1)
                    <span class="text text-success">Đơn hàng mới</span>
                @elseif($ord->order_status==2)
                    <span class="text text-primary">Đã xử lý - Đã giao hàng</span>
                @else
                    <p><span class="text text-danger">Đơn hàng đã bị hủy</span></p>
                    <p><span class="text text-danger">Lý do : {{$ord->order_destroy}}</span></p>
                @endif
            </td>      
            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="btn btn-success" ui-toggle-class="">Xem chi tiết</a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
