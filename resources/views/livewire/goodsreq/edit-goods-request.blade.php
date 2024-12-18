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
      @include('_message')
      {{-- @if (session()->has('message'))
          <div class="pt-3">
              <div class="alert alert-success">
                  {{ session('message') }}
              </div>
          </div>
      @endif --}}
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
                          <input type="hidden" class="form-control" wire:model="gr_status" value="{{ $this->gr_status }}" >
                          <input type="text" class="form-control" wire:model="username" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="remark" class="col-form-label">Notes</label>
                      <div>
                        <textarea wire:model.live="remark" class="form-control" rows="3" disabled></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="comment" class="col-form-label">Comment</label>
                      <div>
                        <textarea wire:model="comment" class="form-control" rows="3"></textarea>
                      </div>
                    </div>
                    {{-- {{ $this->user_id }} --}}
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="deptname" class="col-form-label">Department</label>
                      <div>
                          <input type="text" class="form-control" wire:model="deptname" aria-readonly="true" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="need_date" class="col-form-label">Expected Date</label>
                        <div>
                            <input type="date" class="form-control" id="need_date" wire:model.live="need_date" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="doc_status" class="col-form-label">Doc Status</label>
                        <div>
                            <input type="text" class="form-control" id="doc_status" wire:model.live="doc_status" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="lastcomment" class="col-form-label">Last Comment</label>
                      <div>
                        <textarea wire:model.live="lastcomment" class="form-control" rows="3" disabled></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-3 row">
                  {{-- <label class="col-sm-2 col-form-label"></label> --}} 
                  <div class="col-sm-10">
                    {{-- appr_id: {{ $approval_id }} created_id: {{ $created_id }} Auth: {{ Auth::user()->id }}  --}}
                    {{-- nextappr: {{ $nextapproval }} nextreject: {{ $nextreject }} req_id {{ $req_id }}  --}}
                    @if ($goodsreq->task_userid == Auth::user()->id && $this->gr_status == 2 )
                      <button type="button" class="btn btn-primary" name="submit" wire:click="approval()">Approve . {{ $nextapproval }}</button>
                      <button type="button" class="btn btn-secondary" name="rejection" wire:click="rejection()">Reject</button>
                    @endif
                    @if ($created_id == Auth::user()->id )
                      <button type="button" class="btn btn-primary" name="submit" wire:click="send_approval()">Send for Reminder</button>
                      
                    @endif
                    @if ($goodsreq->task_userid == Auth::user()->id && $this->gr_status == 3)
                      <button type="button" class="btn btn-primary" name="submit" wire:click="deliver()">Deliver</button>
                      {{-- <button type="button" disabled class="btn btn-primary" name="submit" wire:click="send_approval()">Approval</button> --}}
                      {{-- <button type="button" class="btn btn-primary" name="submit" wire:click="cancel()">CANCEL</button> --}}
                      @endif
                    @if ($this->gr_status == 4 && Auth::user()->id == $goodsreq->task_userid)
                      <button type="button" class="btn btn-primary" name="submit" wire:click="received()">Received</button>
                    @endif
                    <button type="button" class="btn btn-warning" name="submin" data-bs-toggle="modal" data-bs-target="#ModalInfo">Info</button>
                  </div>
                  Current Process: {{ $this->task_username }}<br>
                  Next Process: {{ $this->nextapproval_name }} {{ $this->nextapproval }}
                </div>
              </div>
              {{-- {{ Auth::User()->id }}
              {{ $approval_id . $this->gr_status, $approval_id . Auth::User()->id }} --}}
          </form>
      </div>
      <div class="card card-secondary">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Selected Goods {{ $count_item }}</h3>
          </div>
              <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-striped">
              <thead>
                {{-- <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Quantity</td>
                </tr> --}}
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name of Goods</th>
                  <th>Type</th>
                  <th class="text-right" >Qty Request</th>
                  <th>Unit</th>
                  @if ($this->gr_status == 3)
                    <th class="text-right">Qty Remaind</th>
                    @if (Auth::user()->dept_id == 2 )
                      <th class="text-right">Qty Avail</th>
                    @endif
                    <th class="text-right">Qty Delvr</th>
                    <th class="text-right">Qty Rcved</th>
                  @endif
                  @if ($this->gr_status >= 4)
                    <th class="text-right">Qty Remaind</th>
                    <th class="text-right">Qty Delvr</th>
                    <th class="justify-content-center">Qty Received</th>
                  @endif
                </tr>
                
              </thead>
              <tbody>
                @foreach ($goodsreqdet as $item_req)
                  <tr>
                    <td>{{ $item_req->id }}</td>
                    <td>{{ $item_req->name }}</td>
                    <td style="width: 15px">{{ $item_req->goods_type }}</td>
                    <td class="text-right" style="width: 10px">{{ $item_req->qty_req }}</td>
                    <td style="width: 15px">{{ $item_req->unit }}</td>
                    @if ($this->gr_status == 3)
                        <td class="text-right" style="width: 10px">{{ $item_req->qty_rmn }}</td>
                        @if (Auth::user()->dept_id == 2 )
                          <td class="text-right" style="width: 10px">{{ $item_req->qty_onhand }}</td>
                        @endif
                        <td class="text-right" style="width: 10px">{{ $item_req->qty_delvr }}</td>
                        <td class="text-right" style="width: 10px">{{ $item_req->qty_recvd }}</td>
                      @endif
                      @if ($this->gr_status >= 4)
                        <td class="text-right" style="width: 10px">{{ $item_req->qty_rmn }}</td>
                        <td class="text-right" style="width: 10px">{{ $item_req->qty_delvr }}</td>
                        <td class="text-right" style="width: 10px">{{ $item_req->qty_recvd }}</td>
                      @endif
                    <td>
                      @if ($this->gr_status <= 1 && $created_id == Auth::user()->id)
                        <a wire:click="edit_req({{ $item_req }})" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#Modal1">Edit</a>
                      @endif
                      
                      @if ($this->gr_status == 3 && $goodsreq->task_userid == Auth::user()->id )
                        <a wire:click="edit_alloc({{ $item_req }})" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#Modal2">Edit</a>
                      @endif

                      @if ($this->gr_status == 4 && $goodsreq->task_userid == Auth::user()->id )
                        <a wire:click="edit_received({{ $item_req }})" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#Modal3">Edit</a>
                      @endif
                      {{-- <a wire:click="edit_req({{ $item_req }})" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#Modal1">Approved</a>
                      <a wire:click="unselect({{ $item_req->id }})" class="btn btn-danger btn-xs">Reject</a> --}}
                      
                    </td>
                  </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
      
    </section>
    <section>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Tracing Document</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body">
          <ul>
            @foreach ($tracedoc as $item)
              <li>

                <span class="text">{{ $item->created_at }}</span>
                <span class="badge badge-warning">{{ $item->action }}</span>
                <span class="text">{{ $item->username }}</span>
                <span class="text direct-chat-text">{{ $item->comment }}</span>
              </li>
            @endforeach

          </ul>
         
        </div>
      </div>

    </section>
      
      
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
              <input type="hidden" class="form-control" id="goods_id" wire:model="goods_id" disabled>
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
          <button type="submit" class="btn btn-primary" wire:click="upd_qty_req({{ $id }}, {{ $goods_id }}, {{ $qty_req }})" data-bs-dismiss="modal">Ya</button>
        </div>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal" id="Modal2" tabindex="-1" aria-labelledby="Modal2Label">
    <div class="modal-dialog">
      <div class="modal-content">
        @if ($gr_status = 3)
          <div class="modal-header">
            <h5 class="modal-title" id="Modal2">Edit Qty Allocation</h5>
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
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="">Type</label>
                  <input type="text" class="form-control" id="goods_type" wire:model="goods_type" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Request</label>
                  <input type="number" class="form-control" id="qty_req" wire:model.live="qty_req" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Alocation</label>
                  <input type="number" class="form-control" id="qty_delvr" wire:model.live="qty_delvr">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="">Unit</label>
                  <input type="text" class="form-control" id="unit" wire:model="unit" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Available</label>
                  <input type="number" class="form-control" id="qty_onhand" wire:model.live="qty_onhand" disabled>
                </div>
                
              </div>
            </div>
            
            
          </form>
          <p>Anda hanya dapat merubah quantity Alokasi barang </p>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-primary" wire:click="upd_qty_delvr({{ $id }}, {{ $goods_id }}, {{ $qty_delvr }})" data-bs-dismiss="modal">Ya</button>
        </div>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal" id="Modal3" tabindex="-1" aria-labelledby="Modal3Label">
    <div class="modal-dialog">
      <div class="modal-content">
        @if ($gr_status = 3)
          <div class="modal-header">
            <h5 class="modal-title" id="Modal3">Edit Qty Allocation</h5>
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
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="">Type</label>
                  <input type="text" class="form-control" id="goods_type" wire:model="goods_type" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Request</label>
                  <input type="number" class="form-control" id="qty_req" wire:model.live="qty_req" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Received</label>
                  <input type="number" class="form-control" id="qty_recvd" wire:model.live="qty_recvd">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="">Unit</label>
                  <input type="text" class="form-control" id="unit" wire:model="unit" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Delivered</label>
                  <input type="number" class="form-control" id="qty_delvr" wire:model.live="qty_delvr" disabled>
                </div>
                
              </div>
            </div>
            
            
          </form>
          <p>Anda hanya dapat merubah quantity Alokasi barang </p>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-primary" wire:click="upd_qty_received({{ $id }}, {{ $goods_id }}, {{ $qty_recvd }})" data-bs-dismiss="modal">Ya</button>
        </div>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal" id="ModalInfo" tabindex="-1" aria-labelledby="Modal2Label">
    <div class="modal-dialog">
      <div class="modal-content">
        @if ($gr_status = 3)
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInfo">Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        @endif
        <div class="modal-body">
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-info"></i> Tiara Kencana
                  {{-- <small class="float-right">Date: 2/10/2014</small> --}}
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col invoice-col">
                <table>
                  <colgroup>
                    <col>
                  </colgroup>
                  <tr>
                    <td>Document#</td>
                    <td>{{ $this->req_id }}</td>
                  </tr>
                  <tr>
                  <tr>
                    <td>Document Date</td>
                    <td>{{ $this->created_date }}</td>
                  </tr>
                  <tr>
                    <td>Created by</td>
                    <td>{{ $this->created_by }}</td>
                  </tr>
                  <tr>
                    <td>Current Status</td>
                    <td>{{ $this->doc_status }}</td>
                  </tr>
                  <tr>
                    <td>Current Status Resp.</td>
                    <td>{{ $this->task_username }}</td>
                  </tr>
                </table>
              </div>
              <!-- /.col -->
              {{-- <div class="col invoice-col">
                To
                <address>
                  <strong>John Doe</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (555) 539-1037<br>
                  Email: john.doe@example.com
                </address>
              </div> --}}
              <!-- /.col -->
              {{-- <div class="col-sm-4 invoice-col">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
                <b>Payment Due:</b> 2/22/2014<br>
                <b>Account:</b> 968-34567
              </div> --}}
              <!-- /.col -->
            </div>
          </div>
          {{-- <form action="">
            <div class="mb-3">
              <label for="">Name</label>
              <input type="hidden" class="form-control" id="id" wire:model="id" disabled>
              <input type="text" class="form-control" id="name" wire:model="name" disabled>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="">Type</label>
                  <input type="text" class="form-control" id="goods_type" wire:model="goods_type" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Request</label>
                  <input type="number" class="form-control" id="qty_req" wire:model.live="qty_req" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Alocation</label>
                  <input type="number" class="form-control" id="qty_delvr" wire:model.live="qty_delvr">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="">Unit</label>
                  <input type="text" class="form-control" id="unit" wire:model="unit" disabled>
                </div>
                <div class="mb-3">
                  <label for="">Qty Available</label>
                  <input type="number" class="form-control" id="qty_onhand" wire:model.live="qty_onhand" disabled>
                </div>
                
              </div>
            </div>
            
            
          </form>
          <p>Anda hanya dapat merubah quantity Alokasi barang </p>
           --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Exit</button>
        </div>
      </div>
    </div>
  </div>


{{-- @endsection --}}
</div>
