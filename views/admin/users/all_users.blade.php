@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Quản lý nhân viên
    </div>
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên user</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Admin</th>
            <th>User</th>
            
           
          </tr>
        </thead>
        <tbody>
          @foreach($admin as $key => $user)
            <form action="{{url('/assign-roles')}}" method="POST">
              @csrf
              <tr>
               
               
                <td>{{ $user->admin_name }}</td>
                <td>
                  {{ $user->admin_email }} 
                  <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
                  <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
                </td>
                <td>{{ $user->admin_phone }}</td>
                <td>{{ $user->admin_password }}</td>
                <td><input type="checkbox" name="admin_role"  {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                <td><input type="checkbox" name="user_role"  {{$user->hasRole('user') ? 'checked' : ''}}></td>
              <td>
                <p><input type="submit" value="Phân quyền" class="btn btn-sm btn-default"></p>
                 <p><a style="margin: 5px" class="btn btn-sm btn-danger" href="{{url('/delete-user-roles/'.$user->admin_id)}} ">Xóa user</a></p>
              </td> 

              </tr>
            </form>
          @endforeach
        </tbody>
      </table>
      <div class="pagination">
                {!! $admin->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection