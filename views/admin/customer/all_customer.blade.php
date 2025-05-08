@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Quản lý khách hàng
        </div>

        <div class="table-responsive">
            @if(Session::has('message'))
                <span class="text-alert">{{ Session::get('message') }}</span>
                {{ Session::put('message', null) }}
            @endif

            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Tổng chi tiêu</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                          $i =0; 
                          @endphp

                         @foreach($customers as $customer)
                          @php
                          $i++;
                    @endphp
                    
                        <tr>
                            <td><i>{{$i}}</i></td>
                            <td>{{ $customer->user_name }}</td>
                            <td>{{ $customer->user_email }}</td>
                            <td>{{ $customer->user_phone }}</td>
                            <td>{{ $customer->user_address }}</td>
                            <td>
                                @if($customer->user_status)
                                    <span class="text-success">Hoạt động</span>
                                @else
                                    <span class="text-danger">Đã khóa</span>
                                @endif
                            </td>
                             <td>{{ number_format($customer->total_spent, 0, ',', '.') }} </td> 
                            
                            <td>
                                <a href="{{ url('/toggle-status/'.$customer->user_id) }}" 
                                   class="btn btn-xs {{ $customer->user_status ? 'btn-danger' : 'btn-success' }}">
                                    {{ $customer->user_status ? 'Khóa' : 'Mở khóa' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                {!! $customers->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection