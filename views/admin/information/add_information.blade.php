@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
           <header class="panel-heading">
                            Thông tin website
                        </header>

            <div class="panel-body">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    {{ Session::put('message', null) }}
                @endif
                <div class="position-center">
                    @foreach($contact as $key => $cont)
                    <form role="form" action="{{url('/update-info/'.$cont->info_id)}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="info_contact">Thông tin liên hệ</label>
                            <textarea name="info_contact" style="resize: none;" rows="8" class="form-control" id="ckeditor1">{{$cont->info_contact}}</textarea>
                            @error('info_contact')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="info_map">Bản đồ</label>
                            <textarea name="info_map" style="resize: none;" rows="8" class="form-control">{{$cont->info_map}}</textarea>
                            @error('info_map')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="info_fanpage">Fanpage</label>
                            <textarea name="info_fanpage" style="resize: none;" rows="8" class="form-control">{{$cont->info_fanpage}}</textarea>
                             @error('info_fanpage')
                                        <span style="color:red;" class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-info">Cập nhật thông tin</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>

@endsection