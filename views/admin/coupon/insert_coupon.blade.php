@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm mã giảm giá
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
                                <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                    <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1" >
                                    @error('coupon_name')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã giảm giá</label>
                                    <input type="text" name="coupon_code" class="form-control" id="exampleInputEmail1" >
                                    @error('coupon_code')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                    <input type="text" name="coupon_date_start" class="form-control" id="start_coupon" >
                                    @error('coupon_date_start')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày kết thúc</label>
                                    <input type="text" name="coupon_date_end" class="form-control" id="end_coupon" >
                                    @error('coupon_date_end')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng</label>
                                    <input type="text" name="coupon_quantity" class="form-control" id="exampleInputEmail1" >
                                    @error('coupon_quantity')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Tính năng mã</label>
                                    <select name="coupon_condition" class="form-control">
                                            <option value="0">----Chọn----</option>
                                            <option value="1">Giảm theo phần trăm</option>
                                            <option value="2">Giảm theo tiền</option>
                                    </select>
                                    @error('coupon_condition')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                     @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nhập số % hoặc tiền giảm</label>
                                    <input type="text" name="coupon_number" class="form-control" id="exampleInputEmail1" >
                                    @error('coupon_number')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                               
                                <button type="submit" name="add_coupon" class="btn btn-info">Thêm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection