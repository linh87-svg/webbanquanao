@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div>
                    <form role="form" action="{{ URL::to('/save-color') }}" method="post">
                        {{ csrf_field() }}
                        <div style="display: flex; align-items: center;">
                            <label for="exampleInputEmail1">Tên màu sắc :</label>
                            <input type="text" name="color_name" class="form-control" id="exampleInputEmail1" placeholder="Tên màu sắc" style="width: 35%; margin: 0 10px;">
                                <button type="submit" name="add_color" class="btn btn-info">Thêm</button>
                        </div>
                        @error('color_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="panel-heading">
      Liệt kê màu sắc
    </div>
        <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Màu sắc</th>
           <th>Action</th>
           
          </tr>
        </thead>
        <tbody>
            @php
          $i =0; 

          @endphp 
          @foreach($all_color as $key => $color_pro)
          @php
          $i++;
          @endphp
          <tr>
            <td><i>{{$i}}</i></td>
            <td>{{ $color_pro->color_name}}</td>
            <td>
              <a onclick="return confirm('Bạn có muốn xóa không????')" href="{{URL::to('/delete-color/'.$color_pro->color_id)}}" class="active stylying-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
       <ul class="pagination pagination-sm m-t-none m-b-none pull-right">
      {!!$all_color->links()!!}
        </ul>
@endsection