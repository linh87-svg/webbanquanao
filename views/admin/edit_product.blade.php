@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-heading">
             Cập nhật sản phẩm
            </div>

            <div class="panel-body">

                <div class="position-center">
                   
                    <form role="form" action="{{ URL::to('/update-product/'.$edit_product->product_id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control"  value="{{$edit_product->product_name}}">
                            @if ($errors->has('product_name'))
                                <span class="text-danger">{{ $errors->first('product_name') }}</span>
                            @endif
                            
                        </div>

                       <div class="form-group">
                            <label for="product_price">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control price_format" value="{{$edit_product->product_price}}">
                            @if ($errors->has('product_price'))
                                <span class="text-danger">{{ $errors->first('product_price') }}</span>
                            @endif
                        </div>

                         <div class="form-group">
                            <label for="price_cost">Giá gốc</label>
                            <input type="text" name="price_cost" class="form-control price_format" value="{{$edit_product->price_cost}}">
                            @if ($errors->has('price_cost'))
                                <span class="text-danger">{{ $errors->first('price_cost') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="product_images">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_images" class="form-control" >
                            <img src="{{URL::to('public/upload/product/'.$edit_product->product_images)}}" height="150" width="120">
                            @if ($errors->has('product_images'))
                                <span class="text-danger">{{ $errors->first('product_images') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="product_desc">Mô tả sản phẩm</label>
                            <textarea name="product_desc" style="resize: none;" rows="5" class="form-control"  >{{$edit_product->product_desc}}</textarea>
                            @if ($errors->has('product_desc'))
                                <span class="text-danger">{{ $errors->first('product_desc') }}</span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="product_category">Danh mục sản phẩm</label>
                            <select name="product_category" class="form-control"  required>
                        @foreach($cate_product as $cate)
                        @if($cate->category_parent != 0)
                                @if($cate->category_id == $edit_product->category_id)

                                    <option selected value="{{ $cate->category_id }}">{{$cate->category_name }}</option>
                                @else
                                    <option value="{{ $cate->category_id }}">{{$cate->category_name }}</option>
                                    @endif
                        @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_color">Màu sắc</label>
                            <select name="product_color[]" class="form-control" multiple>
                                @foreach($color_product as $color)
                                    <option value="{{ $color->color_id }}" 
                                        {{ in_array($color->color_id, $selected_colors) ? 'selected' : '' }}>
                                        {{ $color->color_name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_color'))
                                <span class="text-danger">{{ $errors->first('product_color') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="product_size">Kích thước</label>
                            <select name="product_size[]" class="form-control" multiple>
                                @foreach($size_product as $size)
                                    <option value="{{ $size->size_id }}" 
                                        {{ in_array($size->size_id, $selected_sizes) ? 'selected' : '' }}>
                                        {{ $size->size_name }}
                                    </option>
                                @endforeach
                            </select>
                             @if ($errors->has('product_size'))
                                <span class="text-danger">{{ $errors->first('product_size') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="product_quantities">Số lượng sản phẩm</label>
                            <input type="number" name="product_quantities" class="form-control" value="{{$edit_product->product_quantities}}">
                            @if ($errors->has('product_quantities'))
                                <span class="text-danger">{{ $errors->first('product_quantities') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="product_status">Trạng thái</label>
                            <select name="product_status" class="form-control" >
                                <option value="0" {{ $edit_product->product_status == 0 ? 'selected' : '' }}>Ẩn</option>
                                <option value="1" {{ $edit_product->product_status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            </select>
                        </div>
                       <button type="submit" class="btn btn-info">Cập nhật sản phẩm</button>
                    </form>
                   
            </div>
        </section>
    </div>
</div>

@endsection
