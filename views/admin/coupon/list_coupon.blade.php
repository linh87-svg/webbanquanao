@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê mã giảm giá
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
            <th>Tên mã giảm giá</th>
            <th>Mã giảm giá</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Số lượng mã</th>
            <th>Điều kiện</th>
            <th>Số giảm</th>
            <th>Tình trạng</th>
            <th>Hết hạn</th>
            <th>Quản lý</th>
            <th>Gửi mã</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <td>{{ $cou->coupon_name}}</td>
            <td>{{ $cou->coupon_code}}</td>
             <td>{{ $cou->coupon_date_start}}</td>
            <td>{{ $cou->coupon_date_end}}</td>
            <td>{{ $cou->coupon_quantity}}</td>
            <td><span class="text-ellipsis"> 
            <?php 
             if($cou->coupon_condition == 1){
            ?>
                Giảm theo phần trăm
            <?php 
             }else{
            ?>
                Giảm theo tiền
            <?php 
             }
             ?>
             </span> </td>
             <td><span class="text-ellipsis"> 
            <?php 
             if($cou->coupon_condition == 1){
            ?>
                Giảm {{$cou->coupon_number}} %
            <?php 
             }else{
            ?>
                Giảm {{$cou->coupon_number}} đồng
            <?php 
             }
             ?>
             </span> </td>

             <!-- <td><span class="text-ellipsis"> 
            <?php 
             if($cou->coupon_date_end>= $today){
            ?>
                <span style="color:green;">Đang hoạt động</span>
            <?php 
             }else{
            ?>
                <span style="color:red;">Đã khóa</span>
            <?php 
             }
             ?>
             </span> </td> -->
             <td><span class="text-ellipsis"> 
  @if(Carbon\Carbon::createFromFormat('d-m-Y', $cou->coupon_date_end)->gte(Carbon\Carbon::createFromFormat('d-m-Y', $today)))
      <span style="color:green;">Đang hoạt động</span>
  @else
      <span style="color:red;">Đã khóa</span>
  @endif
</span></td>

<!-- Tình trạng hoạt động -->
            <td><span class="text-ellipsis">
              @if(Carbon\Carbon::createFromFormat('d-m-Y', $cou->coupon_date_end)->gte(Carbon\Carbon::createFromFormat('d-m-Y', $today)))
                <span style="color:green;">Đang hoạt động</span>
              @else
                <span style="color:red;">Đã khóa</span>
              @endif
            </span></td>

            <!-- Hết hạn -->
            <td>
              @if(Carbon\Carbon::createFromFormat('d-m-Y', $cou->coupon_date_end)->gte(Carbon\Carbon::createFromFormat('d-m-Y', $today)))
                <span>Còn hạn</span>
              @else
                <span style="color:red;">Đã hết hạn</span>
              @endif
            </td>

            <!-- Quản lý xóa -->
           

            <!-- Gửi mã -->
            <td>
              @if(Carbon\Carbon::createFromFormat('d-m-Y', $cou->coupon_date_end)->gte(Carbon\Carbon::createFromFormat('d-m-Y', $today)))
                <p><a href="{{url('/send-coupon', [
                    'coupon_quantity' => $cou->coupon_quantity,
                    'coupon_condition' => $cou->coupon_condition,
                    'coupon_number' => $cou->coupon_number,
                    'coupon_code' => $cou->coupon_code
                ])}}" class="btn btn-primary btn-xs" style="margin:5px 0;">Gửi mã khách hàng</a></p>
              @else
                <p><span class="text-danger">Mã đã hết hạn, không thể gửi!</span></p>
              @endif
          </td>
           <td>
              <a onclick="return confirm('Bạn có muốn xóa mã này không????')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active stylying-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection