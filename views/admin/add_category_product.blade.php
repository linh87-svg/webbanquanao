@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                      
                        <header class="panel-heading">
                            Thêm danh mục sản phẩm
                        </header>

                        <div class="panel-body">
                           <?php 
                            $message = Session::get('message');
                            if($message){
                                echo'<span class="text-alert">', $message,'</span>';
                                Session::put('message', null);
                            }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" name="category_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                    @error('category_name')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thuộc danh mục</label>
                                      <select name="category_parent" class="form-control input-sm m-bot15" style="font-size: 14px;">
                                        <option value="0">---Danh mục cha---</option>
                                        @foreach($category as $key => $val)
                                           <option value="{{$val -> category_id}}">{{$val -> category_name}} </option>
                                        @endforeach  
                                    </select>
                                    @error('category_parent')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" name="add_category_product" class="btn btn-info pull-right">Thêm</button>
                            </form>
                            </div>
                        </div>
                    </section>

            </div>
        </div>
          <div class="panel-heading">
      Liệt kê danh mục
    </div>

    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên danh mục</th>
            <th>Thuộc danh mục</th>
           <th>Action</th>
            
          </tr>
        </thead>
        <tbody>
              @php
          $i =0; 

          @endphp
          @foreach($all_category_product as $key => $cate_pro)
          <tr>
            @php
          $i++;
          @endphp
          <td><i>{{$i}}</i></td>
            <td>{{ $cate_pro->category_name}}</td>
            <td>
              @if($cate_pro->category_parent == 0)
               <span style="color:red;">Danh mục cha</span>
              @else
              @foreach($category as $key => $cate_sub)
                @if( $cate_sub->category_id == $cate_pro->category_parent)
                <span style="color:black;">{{$cate_sub->category_name}}</span>
                @endif
                @endforeach
              @endif
            </td>
            <td>
              @if($cate_pro->category_parent != 0)
                  <a href="{{ URL::to('/edit-category-product/'.$cate_pro->category_id) }}" class="active stylying-edit">
                      <i class="fa fa-pencil-square-o text-success text-active"></i>
                  </a>
                  <a onclick="return confirm('Bạn có muốn xóa không????')" 
                     href="{{ URL::to('/delete-category-product/'.$cate_pro->category_id) }}" 
                     class="active stylying-edit">
                      <i class="fa fa-times text-danger text"></i>
                  </a>
              
              @endif
          </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
    <ul class="pagination pagination-sm m-t-none m-b-none pull-right">
      {!!$all_category_product->links()!!}
 </ul>
@endsection