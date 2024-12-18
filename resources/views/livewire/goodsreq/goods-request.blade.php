<div>
    {{-- @section('content') --}}
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $header_title }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="float-sm-left">
            
          </ol>
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-6">
          <div class="col-sm-6">
            <h1>{{ $header_title }} (Total: {{ $goods->count() }})</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section> --}}

    <!-- Main content -->
   
    <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Goods List </h3>
              </div>
              <div class="row">
                <div class="col-sm-2 mt-3 ml-3">
                  <label for="" class="form-label">Filter</label>
                </div>
                <div class="col-sm-8 mt-2">
                  <input type="text" class="form-control" wire:model.live="search" placeholder="Search by name or type" >
                </div>
              </div>
              {{-- <form method="get" action="">
                <div class="card-body">
                  

                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="">Name of Goods</label>
                      <input type="text" class="form-control" name="goodsname" value="{{ Request::get('goodsname') }}" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="">Type</label>
                      <input type="text" class="form-control" name="goodstype" value="{{ Request::get('goodstype') }}" >
                    </div>
                    <div class="form-group col-md-4">
                      <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                      <a href="{{ url('goodsrequest') }}" class="btn btn-success" style="margin-top:30px;">Reset</a>
                    </div>
                  </div>
                </div>
              </form> --}}

              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name of Goods</th>
                      <th>Type</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($goods as $item)
                      <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->goods_type }}</td>
                        <td>
                          {{-- <a href="{{ url('admin/admin/select/'.$item->id ) }}" class="btn-xs btn-primary">Select</a>  --}}
                          <a wire:click="select({{ $item->id }})" class="btn btn-warning btn-xs">Select</a>
                        </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                {{-- <div style="padding:10px; float:right">
                  {!! $goods->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div> --}}
                <div class="d-flex justify-content-right">
                  {{ $goods->links('pagination::bootstrap-5') }}
                </div>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Selected Goods</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name of Goods</th>
                      <th>Type</th>
                      <th>Qty</th>
                      <th>Unit</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($goodsreqdet as $item_req)
                      <tr>
                        <td>{{ $item_req->id }}</td>
                        <td>{{ $item_req->name }}</td>
                        <td>{{ $item_req->goods_type }}</td>
                        <td>{{ $item_req->qty_req }}</td>
                        <td>{{ $item_req->unit }}</td>
                        <td>
                          <a wire:click="edit_req({{ $item_req }})" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#Modal1">Edit</a>
                          <a wire:click="unselect({{ $item_req->id }})" class="btn btn-danger btn-xs">UnSelect</a>
                        </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="col-sm-10">
            <button type="button" class="btn btn-primary" wire:click="submit()">Process</button>
            <button type="button" class="btn btn-warning" wire:click="clearall()">Clear All</button>
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      
      </div><!-- /.container-fluid -->
    </section>


  </div>

  <!-- Button trigger modal -->


<!-- Modal -->
<div wire:ignore.self class="modal" id="Modal1" tabindex="-1" aria-labelledby="Modal1Label">
  <div class="modal-dialog">
    <div class="modal-content">
      @if ($gr_status = 0)
        <div class="modal-header">
          <h5 class="modal-title" id="Modal1">Edit Qty</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      @endif
      <div class="modal-body">
        <form action="">
          <div class="mb-3">
            <label for="">Name</label>
            <input type="hidden" class="form-control" id="id" wire:model="id" disabled>
            <input type="text" class="form-control" id="name" wire:model="name" disabled>
          </div>
          <div class="mb-3">
            <label for="">Type</label>
            <input type="text" class="form-control" id="goods_type" wire:model="goods_type" disabled>
          </div>
          <div class="mb-3">
            <label for="">Qty</label>
            <input type="number" class="form-control" id="qty_req" wire:model.live="qty_req">
          </div>
          <div class="mb-3">
            <label for="">Unit</label>
            <input type="text" class="form-control" id="unit" wire:model="unit" disabled>
          </div>
          
        </form>
        <p>Anda hanya dapat merubah quantity barang </p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <button type="submit" class="btn btn-primary" wire:click="upd_qty_req({{ $id }}, {{ $qty_req }})" data-bs-dismiss="modal">Ya</button>
      </div>
    </div>
  </div>
</div>


{{-- @endsection --}}
</div>