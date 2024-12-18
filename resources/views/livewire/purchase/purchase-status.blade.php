<div>
    {{-- @section('content') --}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-6">
          <div class="col-sm-6">
            <h1>{{ $header_title }}</h1>
          </div>
          <div>
            <div class="col-sm-12" style="text-align: right;">
              <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">Next</a>
            </div>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
   
    <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          {{-- <div class="col-md-6"> --}}
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Request List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Requestor</th>
                      <th>Dept</th>
                      <th>Notes</th>
                      <th>Need Date</th>
                      <th>Status</th>
                      <th>Current Resp.</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($poreq as $item)
                      <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->deptname }}</td>
                        <td>{{ $item->remark }}</td>
                        <td>{{ $item->need_date }}</td>
                        <td>{{ $item->status_desc }}</td>
                        <td>{{ $item->taskname }}</td>
                        <td>
                          {{-- <a href="{{ url('admin/admin/select/'.$item->id ) }}" class="btn-xs btn-primary">Select</a>  --}}
                          <a wire:click="select({{ $item->id }})" class="btn btn-warning btn-xs">Select</a>
                        </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            <!-- /.card -->
          {{-- </div> --}}
          
          
        </div>
        <!-- /.row -->
        
        <!-- /.row -->
        
        <!-- /.row -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
          Launch static backdrop modal
        </button>
      </div><!-- /.container-fluid -->
    </section>


  </div>

  <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>


{{-- @endsection --}}
</div>
