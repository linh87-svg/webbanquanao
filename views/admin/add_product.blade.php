@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm  sản phẩm
            </header>

            <div class="panel-body">
                
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/save-product') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                                <label for="product_name">Tên sản phẩm</label>
                                <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Nhập tên sản phẩm">
                                @error('product_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_price">Giá sản phẩm</label>
                                <input type="text" name="product_price" class="form-control price_format" id="product_price" placeholder="Nhập giá sản phẩm">
                                @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price_cost">Giá gốc</label>
                                <input type="text" name="price_cost" class="form-control price_format" id="price_cost" placeholder="Nhập giá gốc">
                                @error('price_cost')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_images">Hình ảnh sản phẩm</label>
                                <input type="file" name="product_images" class="form-control" id="product_images">
                                @error('product_images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_desc">Mô tả sản phẩm</label>
                                <textarea name="product_desc" style="resize: none;" rows="8" class="form-control" placeholder="Mô tả sản phẩm"></textarea>
                                @error('product_desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        <div class="form-group">

                            <label for="product_category">Danh mục sản phẩm</label>
                            <select name="product_category" class="form-control" id="product_category" >
                                @foreach($cate_product as $cate)
                                @if($cate->category_parent != 0)
                                 <option value="{{ $cate->category_id }}">{{ $cate->category_name }}</option>
                                 @endif
                                @endforeach
                            </select>
                            @error('product_category')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_color">Chọn màu sắc</label>
                            <select name="product_color[]" class="form-control" id="product_color" style="height: 200px" multiple>
                                @foreach($color_product as $color)
                                    <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                           @error('product_color')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="product_size">Chọn kích thước</label>
                            <select name="product_size[]" class="form-control" id="product_size" multiple>
                                @foreach($size_product as $size)
                                    <option value="{{ $size->size_id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                            @error('product_size')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                                <label for="product_quantities">Số lượng sản phẩm</label>
                                <input type="text" name="product_quantities" class="form-control" id="product_quantities" placeholder="Nhập số lượng sản phẩm">
                                @error('product_quantities')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        <button type="submit" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
