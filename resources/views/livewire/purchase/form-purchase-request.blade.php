<div>
    {{-- @section('content') --}}
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-6">
          <div class="col-sm-6">
            <h1>{{ $header_title }} </h1>
          </div>
          <div>
            <div class="col-sm-12" style="text-align: right;">
            </div>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
   
    <!-- /.content -->
    

    <section class="content">
      @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
      @endif
      @if (session()->has('message'))
          <div class="pt-3">
              <div class="alert alert-success">
                  {{ session('message') }}
              </div>
          </div>
      @endif
      <div class="my-3 p-3 bg-body rounded shadow-sm">
          <form>
              @csrf
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">General</h3>
  
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="username" class="col-form-label">Created by</label>
                      <div>
                          <input type="hidden" class="form-control" wire:model="user_id" value="{{ $this->user_id }}" >
                          <input type="hidden" class="form-control" wire:model="dept_id" value="{{ $this->dept_id }}" >
                          <input type="hidden" class="form-control" wire:model="pr_status" value= 0 >
                          <input type="text" class="form-control" wire:model="username">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="remark" class="col-form-label">Notes</label>
                      <div>
                        <textarea wire:model.live="remark" class="form-control" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="deptname" class="col-form-label">Department</label>
                      <div>
                          <input type="text" class="form-control" wire:model="deptname" aria-readonly="true">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="need_date" class="col-form-label">Expected Date</label>
                        <div>
                            <input type="date" class="form-control" id="need_date" wire:model.live="need_date">
                        </div>
                    </div>
                  </div>
                </div>
                
              
              
              <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                      <button type="button" class="btn btn-primary" name="submit" wire:click="store()">SUBMIT</button>
                      <button type="button" class="btn btn-primary" name="submit" wire:click="cancel()">CANCEL</button>
                  </div>
              </div>
              </div>
          </form>
      </div>
      <div class="card card-secondary">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Selected Goodss </h3>
          </div>
              <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name of Goods</th>
                  <th>Type</th>
                  <th>Unit</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($poreqdet as $item_req)
                  <tr>
                    <td>{{ $item_req->id }}</td>
                    <td>{{ $item_req->name }}</td>
                    <td>{{ $item_req->goods_type }}</td>
                    <td>{{ $item_req->unit }}</td>
                    <td>{{ $item_req->qty_req }}</td>
                    <td>{{ $item_req->goods_price }}</td>
                    <td>{{ $item_req->total_price }}</td>
                    <td>
                      <a wire:click="edit_req({{ $item_req }})" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#Modal1">Edit</a>
                      <a wire:click="unselect({{ $item_req->id }})" class="btn btn-danger btn-xs">UnSelect</a>
                      
                    </td>
                  </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
        {{-- <div class="row">
          <div class="col-12">
            <a href="#" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Save Changes" class="btn btn-success float-right">
          </div>
        </div> --}}
    </section>


  </div>

  <!-- Button trigger modal -->


  <!-- Modal -->

  <div wire:ignore.self class="modal" id="Modal1" tabindex="-1" aria-labelledby="Modal1Label">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Modal1">Edit Qty</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
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