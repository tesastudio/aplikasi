@extends('layouts.backend.blankpage')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-6">
          <div class="col-sm-6">
            <h1>{{ $header_title }} (Total: )</h1>
          </div>
          <div>
            <div class="col-sm-12" style="text-align: right;">
              <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">Add new Dept</a>
            </div>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h3 class="card-title">Search Admin</h3>
          </div>
          <form method="get" action="">
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="">Name</label>
                  <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" placeholder ="Name">
                </div>
                <div class="form-group col-md-3">
                  <label for="">Email</label>
                  <input type="text" class="form-control" name="email" value="{{ Request::get('email') }}" placeholder="Email">
                </div>
                <div class="form-group col-md-3">
                  <label for="">Date</label>
                  <input type="date" class="form-control" name="date" value="{{ Request::get('date') }}" placeholder="date">
                </div>
                <div class="form-group col-md-3">
                  <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                  <a href="{{ url('admin/admin/list') }}" class="btn btn-success" style="margin-top:30px;">Reset</a>
                </div>

              </div>
            </div>
          </form>
          <!-- /.col -->
          <div class="col-md-12">
            {{-- @include('_message') --}}
            
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Dept Name</th>
                      <th>Dept Head</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                        <td><a href="{{ url('admin/admin/edit/'.$user->id ) }}" class="btn btn-primary">Edit</a> 
                          <a href="{{ url('admin/admin/delete/'.$user->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                <div style="padding:10px; float:right">
                  {{-- {!! $depts->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!} --}}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        
        <!-- /.row -->
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection