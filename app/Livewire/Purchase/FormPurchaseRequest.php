<?php

namespace App\Livewire\Purchase;

use Livewire\Component;
use App\Models\Dept;
use App\Models\Poreq;
use App\Models\PoreqDet;
use App\Models\Status;
use App\Models\Tracing;
use Auth;

class FormPurchaseRequest extends Component
{
    public $id;
    public $username;
    public $user_id;
    public $deptname;
    public $dept_id;
    public $depthead_id;
    
    public $name;
    public $goods_type;
    public $qty_req;
    public $unit;
    public $need_date;
    public $remark;
    public $task_userid;
    public $pr_status;
    public $pr_id;


    
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
        $poreqdet = PoreqDet::join('goods','goods.id','=','poreq_dets.goods_id')
            ->where('user_id','=',Auth::user()->id)
            ->where('pr_status','=',0)
            ->where('pr_id','=',null)
            ->orderBy('goods_id')
            ->get(['poreq_dets.id','goods.name','goods.goods_type','poreq_dets.qty_req','poreq_dets.unit',
                    'goods_price','total_price']);
        // $count_item = count($goodsreqdet);
        $header_title = 'PO Request Form';
        // return view('livewire.goodsreq.form-goods-req', compact('header_title', 'count_item', 'user','dept', 'goodsreqdet'))->extends('layouts.backend.blankpage');

        return view('livewire.purchase.form-purchase-request', compact('header_title','poreqdet','user','dept'))->extends('layouts.backend.blankpage');
    }

    public function edit_req($item){
        // dd($item);
        $this->id = $item['id'];
        $this->name = $item['name'];
        $this->goods_type = $item['goods_type'];
        $this->qty_req = $item['qty_req'];
        $this->unit = $item['unit'];

    }

    public function upd_qty_req($id, $qty){
        $data = PoreqDet::find($id);
        $data->qty_req = $qty;
        $data->qty_rmn = $qty;
        $data->total_price = $qty * $data->goods_price;
        $data->save();
    }

    public function cancel(){
        // dd('cancel');
        return redirect()->to('purchaserequest');
    }

    public function store(){
        // dd($this->remark, $this->need_date);
        // dd(Status::where('status_id','=',1)->first()->value('description'));
        $dept = Dept::where('id','=',Auth::User()->dept_id)->first();
        $this->task_userid = $dept->depthead;
        $this->pr_status = 2;
        $approval = Status::where('type','=','Pur-ATK')
            ->where('status_id','=',$this->pr_status + 1)
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
            'pr_status' => 'nullable',
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
        // dd($rules);
        $validated = $this->validate($rules, $pesan); 
        $pr_id = PoReq::create($validated)->id;
        // $table->string('type');
        //     $table->integer('doc_id');
        //     $table->integer('userid');
        //     $table->string('username');
        //     $table->integer('status_id');
        //     $table->string('comment')->nullable();
        $trace = [
            'type' => 'Pur-ATK',
            'doc_id' => $pr_id,
            'userid' => Auth::User()->id,
            'username' => Auth::User()->name,
            'email' => Auth::User()->email,
            'status_id' => 1,
            'comment' => $this->remark,
            'action' => Status::where('type','=','Pur-ATK')->where('status_id','=',1)->first()->value('description')
        ];
        // dd($trace);
        tracing::create($trace);
        //  dd($this->goodsreqdet);
        PoreqDet::where('user_id',$this->user_id)
            ->where('pr_status','=',0)
            ->update(['pr_id'=>$pr_id, 'pr_status'=>1]);
        // $result = $this->create_tracing($data['gr_status'],'Send Email');
        return redirect()->to('send-mail-purchase/' . $pr_id);
            // editgoodsrequest/{id}
        return redirect()->to('editpurchaserequest/' . $pr_id);
        // session()->flash('message','Data berhasil dimasukkan');

        
    }
}
