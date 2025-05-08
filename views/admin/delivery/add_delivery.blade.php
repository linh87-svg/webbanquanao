@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                                <header class="panel-heading">
                                    Thêm phí vận chuyển
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
                                 
                                <form method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tỉnh</label>
                                    <select name="province" id="province" class="form-control input -sm m-bot15 choose province">
                                            <option value="0">Chọn tỉnh thành</option>
                                            @foreach($province as $key => $tinh)
                                            <option value="{{$tinh->province_id}}">{{$tinh->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quận Huyện</label>
                                    <select name="district" id="district" class="form-control input -sm m-bot15  district choose">
                                            <option value="0">----Chọn quận huyện----</option>
                                          
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xã Phường Thị Trấn</label>
                                    <select name="wards" id="wards" class="form-control input -sm m-bot15 wards">
                                            <option value="0">----Chọn xã phường thị trấn----</option>
                                          
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phí vận chuyển</label>
                                    <input type="text" name="fee_ship" class="form-control fee-ship" id="exampleInputEmail1" >
                                    @if ($errors->has('fee_ship'))
                                        <span class="text-danger">{{ $errors->first('fee_ship') }}</span>
                                    @endif
                                </div>
                                <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                            </form>

                            </div><br>
                            
                <div id="load_delivery">
                </div>
                        </div>

                    </section>

            </div>
@endsection

