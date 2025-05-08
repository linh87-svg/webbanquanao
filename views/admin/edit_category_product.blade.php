@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            cập nhật danh mục sản phẩm
                        </header>
                             <?php 
                            $message = Session::get('message');
                            if($message){
                                echo'<span class="text-alert">', $message,'</span>';
                                Session::put('message', null);
                            }
                            ?>
                        <div class="panel-body">
                            @foreach($edit_category_product as $key =>$edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{$edit_value->category_name}}" name="category_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                    @error('category_name')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thuộc danh mục</label>
                                    <select name="category_parent" class="form-control input-sm m-bot15" style="font-size: 14px;">
                                        <option value="0">---Danh mục cha---</option>

                                        @foreach($category as $key => $val)
                                            @if($val->category_parent == 0) 
                                                <option value="{{$val->category_id}}" 
                                                        {{$val->category_id == $edit_value->category_parent ? 'selected' : ''}}>
                                                    {{$val->category_name}} 
                                                </option>
                                            @endif
                                        @endforeach  
                                    </select>
                                     @error('category_parent')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
@endsection