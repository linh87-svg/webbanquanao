@extends('admin_layout')
@section('admin_content')



<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin vận chuyển đơn hàng
    </div>
    
    <div class="table-responsive">
       <?php 
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">', $message, '</span>';
              Session::put('message', null);
          }
       ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $shipping->shipping_name }}</td>
            <td>{{ $shipping->shipping_address }}</td>
            <td>{{ $shipping->shipping_phone }}</td>
            <td>{{ $shipping->shipping_note }}</td>
            <td>@if($shipping->shipping_method) Chuyển khoản @else Tiền mặt @endif</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div> <!-- Thêm dòng này để đóng panel-heading -->
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
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng kho</th>
            <th>Mã giảm giá</th>
            <th>Giá sản phẩm</th>
            <th>Giá gốc</th>
            <th>Số lượng</th>
            <th>Phí vận chuyển</th>
            <th>Màu sắc</th>
            <th>Kích cỡ</th>
           
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
          $i =0; 
          $total = 0;
          @endphp
          @foreach($order_details as $key => $details)
          @php
          $i++;
          $subtotal = $details->product_quantity*$details->product_price;
          $total += $subtotal;
          @endphp
          <tr class="color_qty_{{$details->product_id}}">
            <td><i>{{$i}}</i></td>
            <td>{{$details->product_name}}</td>
             <td>{{$details->product->product_quantities }}</td><!-- Số lượng kho từ bảng product -->
            <td>@if($details->product_coupon != 'no')
                  {{$details->product_coupon}}
                @else
                  Không có mã giảm giá
                @endif
            </td>
            <td>{{number_format(floatval($details->product_price), 0, ',', '.')}} đồng</td>
            <td>{{number_format(floatval($details->product->price_cost), 0, ',', '.')}} đồng</td>
           <td>
              
               <input type="hidden"  style="width: 30px" class="order_qty_{{$details->product_id}}" value="{{$details->product_quantity}}" name="product_quantity" readonly>
               {{$details->product_quantity}}

              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantities}}">

              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">

             
          </td>
            <td>{{number_format($details->product_feeship,0,',','.')}} đồng</td>
            <td>{{$details->color_name}}</td>
            <td>{{$details->size_name}}</td>
            
          </tr>
          @endforeach
          <tr>
            <td colspan="2">
                @php
                    $total_coupon = 0;
                @endphp

                @if($coupon_condition == 1)
                    @php
                        $total_percent_coupon = ($total * $coupon_number)/100;
                        echo 'Tổng giảm: ' . number_format($total_percent_coupon, 0, ',', '.').' đồng'. '</br>';
                        $total_coupon = $total - $total_percent_coupon + $details->product_feeship;
                    @endphp
                @else
                    @php
                        echo 'Tổng giảm: ' . number_format($coupon_number, 0, ',', '.').' đồng'.'</br>';
                        $total_coupon = $total - $coupon_number + $details->product_feeship;
                    @endphp
                @endif
                Phí vận chuyển:  {{ number_format($details->product_feeship, 0, ',', '.') }} đồng </br>
                Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }} đồng
            </td>
        </tr>
        <tr>
          <td colspan="2">
              @foreach($order as $key => $or)
              @if($or->order_status == 1)
              <form>
                  @csrf
                  <select class="form-control order_detail">
                      <option value="0">---- Tình trạng đơn hàng ----</option>
                      <option id="{{$or->order_id}}" selected value="1">Chưa xử lí</option>
                      <option id="{{$or->order_id}}" value="2">Đã xử lí - Đã giao hàng</option>
                  </select>
              </form>
              @else
              <form>
                  @csrf
                  <select class="form-control order_detail">
                      <option value="0">---- Tình trạng đơn hàng ----</option>
                      <option disabled id="{{$or->order_id}}" value="1">Chưa xử lí</option>
                      <option id="{{$or->order_id}}" selected value="2">Đã xử lí - Đã giao hàng</option>
                  </select>
              </form>
              @endif
              @endforeach
          </td>
        </tr>

        </tbody>
      </table>
      @if($or->order_status == 2)
      <a target="_blank" href="{{url('/print-order/'. $details->order_code)}} " class="pull-right" style="margin-right: 10px;">In đơn hàng</a>
      @endif
    </div>
  </div>
</div>
@endsection
