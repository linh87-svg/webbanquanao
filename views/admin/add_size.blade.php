@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                           <?php 
                            $message = Session::get('message');
                            if($message){
                                echo'<span class="text-alert">', $message,'</span>';
                                Session::put('message', null);
                            }
                            ?>
                            <div>
                                <form role="form" action="{{URL::to('/save-size')}}" method="post">
                                    {{csrf_field()}}
                                <div style="display: flex;">
                                    <label for="exampleInputEmail1">Tên kích thước : </label>
                                    <input type="text" name="size_name" class="form-control" id="exampleInputEmail1" style="width: 35%; margin-right: 10px;margin-left: 10px; ">
                                   
                                    <button type="submit" name="add_size" class="btn btn-info">Thêm</button>
                                    
                                </div>
                                @error('size_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
        </div>
    <div class="panel-heading">
      Liệt kê kích thước
    </div>
        <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Kích thước</th>
           <th>Action</th>
        
          </tr>
        </thead>
        <tbody>
          @php
          $i =0; 
          @endphp 
          @foreach($all_size as $key => $size_pro)
          @php
          $i++;
          @endphp
          <tr>
           <td><i>{{$i}}</i></td>
            <td>{{ $size_pro->size_name}}</td>          
            <td>
              <a onclick="return confirm('Bạn có muốn xóa không????')" href="{{URL::to('/delete-size/'.$size_pro->size_id)}}" class="active stylying-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
@endsection