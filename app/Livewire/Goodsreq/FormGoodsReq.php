<?php

namespace App\Livewire\Goodsreq;

use Livewire\Component;

use App\Models\Dept;
use App\Models\Goods;
use App\Models\GoodsReq;
use App\Models\GoodsReqDet;
use App\Models\Status;
use App\Models\Tracing;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class FormGoodsReq extends Component
{
     // public $user;
    // public $dept;
    public $req_id;
    public $username;
    public $user_id;
    public $deptname;
    public $dept_id;
    public $need_date;
    public $remark;
    public $gr_status;
    public $updateData;
    public $count_item;
    public $depthead_id;
    public $task_userid;
    // public $next_appr_id;

    public $id;
    public $name;
    public $qty_req;
    public $goods_type;
    public $unit;    
    public function render()
    {
        $user = Auth::user();
        $dept = Dept::where('id','=',$user->dept_id)->first();
        $this->username = $user->name;
        $this->user_id = $user->id;
        $this->deptname = $dept->deptname;
        $this->dept_id = $dept->id;
        $this->depthead_id = $dept->depthead;
       
        // dd($this->task_userid, $this->gr_status, $this->next_appr_id);
        
        // join('users','dept_id','=','depts.id')
        //     ->where('users','id','=','$user.id')->get(['depts.deptname']);
        $goodsreqdet = GoodsReqDet::join('goods','goods.id','=','goods_req_dets.goods_id')
            ->where('user_id','=',Auth::user()->id)
            ->where('req_status','=',0)
            ->where('req_id','=',null)
            ->orderBy('goods_id')
            ->get(['goods_req_dets.id','goods.name','goods.goods_type','goods_req_dets.qty_req','goods_req_dets.unit']);
        $count_item = count($goodsreqdet);
        $header_title = 'Goods Request Form';
        return view('livewire.goodsreq.form-goods-req', compact('header_title', 'count_item', 'user','dept', 'goodsreqdet'))->extends('layouts.backend.blankpage');
    }
    public function edit_req($item){
        $this->id = $item['id'];
        $this->name = $item['name'];
        $this->goods_type = $item['goods_type'];
        $this->qty_req = $item['qty_req'];
        $this->unit = $item['unit'];

    }

    public function upd_qty_req($id, $qty){
        $goodsreqdetdata = GoodsReqDet::find($id);
        $goodsreqdetdata->qty_req = $qty;
        $goodsreqdetdata->qty_rmn = $qty;
        $goodsreqdetdata->save();
    }

    public function cancel(){
        // dd('cancel');
        return redirect()->to('goodsrequest');
    }

    public function store(Request $request){
        // dd($this->remark, $this->need_date);
        // dd(Status::where('status_id','=',1)->first()->value('description'));
        $dept = Dept::where('id','=',Auth::User()->dept_id)->first();
        $this->task_userid = $dept->depthead;
        $this->gr_status = 2;
        $approval = Status::where('type','=','Req-ATK')
            ->where('status_id','=',$this->gr_status + 1)
            ->first();
        // dd($approval);
        // $this->next_appr_id = User::where('acting','=',$approval->approve)->value('id');
        // dd($approval->approve, $this->next_appr_id, $this->gr_status);
        $rules = [
            'need_date' => 'required',
            'remark' => 'required',
            'user_id' => 'required',
            'dept_id' => 'required',
            'depthead_id' => 'nullable',
            'task_userid' => 'nullable',
            'gr_status' => 'nullable',
            // 'next_appr_id' => 'nullable'
        ];
        $pesan = [
            'need_date.required'=>'Tanggal wajib diisi',
            'remark.required'=>'Notes wajib diisi',
            'user_id.required' => 'User harus diisi',
            'dept_id.required' => 'Dept harus diisi',
            // 'gr_status' => 'Status harus diisie'
        ];
        // $this->user_id
        $validated = $this->validate($rules, $pesan); 
        // dd($validated);
        $req_id = GoodsReq::create($validated)->id;
        // $table->string('type');
        //     $table->integer('doc_id');
        //     $table->integer('userid');
        //     $table->string('username');
        //     $table->integer('status_id');
        //     $table->string('comment')->nullable();
        $trace = [
            'type' => 'Req-ATK',
            'doc_id' => $req_id,
            'userid' => Auth::User()->id,
            'username' => Auth::User()->name,
            'email' => Auth::User()->email,
            'status_id' => 1,
            'comment' => $this->remark,
            'action' => Status::where('type','=','Req-ATK')->where('status_id','=',1)->first()->value('description')
        ];
        Tracing::create($trace);
        //  dd($this->goodsreqdet);
        GoodsReqDet::where('user_id',$this->user_id)
            ->where('req_status','=',0)
            ->update(['req_id'=>$req_id, 'req_status'=>1]);
        // $result = $this->create_tracing($data['gr_status'],'Send Email');
        
        return redirect()->to('send-mail/' . $req_id);
            // editgoodsrequest/{id}
        return redirect()->to('editgoodsrequest/' . $req_id);
        // session()->flash('message','Data berhasil dimasukkan');

        
    }
    
}
