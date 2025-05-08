@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê sản phẩm
    </div>
    <div class="table-responsive">
       <?php 
          $message = Session::get('message');
            if($message){
              echo'<span class="text-alert">', $message,'</span>';
                Session::put('message', null);
            }
       ?>
       <!-- Ô tìm kiếm -->
       <form action="{{url('/export-csv')}}" method="POST" style="margin-top:10px;float: right;margin-right: 10px;">
          @csrf
       <input style="font-size: 14px;" type="submit" value="Export File Excel" name="export_csv" class="btn btn-success btn-sm">
      </form>
       <label style="margin-left: 10px;">Tìm kiếm :</label>
      <input type="text" id="searchInput" class="form-control" style="width: 300px; margin: 10px;" >
        
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Thư viện ảnh</th>
            <th>Giá sản phẩm</th>
            <th>Giá gốc</th>
            <th>Hình ảnh sản phẩm</th>
            <th>Danh mục sản phẩm</th>
            <th>Số lượng</th>
          
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
          $i =0; 
          @endphp 
          @foreach($all_product as $key => $pro)
          @php
          $i++;
          @endphp
          <tr>
            <td><i>{{$i}}</i></td>
            <td>{{ $pro->product_name}}</td>
            <td><a href="{{url('add-gallery/'.$pro->product_id)}} ">Thêm thư viện ảnh</a> </td>
            <td>{{number_format(floatval($pro->product_price), 0, ',', '.')}} đồng</td>
<td>{{number_format(floatval($pro->price_cost), 0, ',', '.')}} đồng</td>
            <td><img src="public/upload/product/{{ $pro->product_images}}" height="170" width="120"> </td>
            <td>{{ $pro->category_name}}</td>
            <td>{{ $pro->product_quantities}}</td>
             
            <td>
              <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="active stylying-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có muốn xóa không????')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active stylying-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>

    </div>
    
    <ul class="pagination pagination-sm m-t-none m-b-none pull-right">
      {!!$all_product->links()!!}
 </ul>
  </div>
</div>

@endsection