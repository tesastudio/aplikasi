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
use DB;

class EditGoodsRequest extends Component
{
    public $header_title;
    public $req_id;
    public $id;

    public $username;
    // public $user_id;
    public $deptname;
    public $dept_id;
    public $need_date;
    public $remark;
    public $gr_status;
    public $updateData;
    public $count_item;

    public $name;
    public $goods_id;
    public $qty_req;
    public $qty_delvr;
    public $qty_recvd;
    public $qty_onhand;
    public $goods_type;
    public $unit;    
    public $doc_status;
    public $approval_id;
    public $created_id;
    public $comment;
    public $lastcomment;
    public $ifapprove;
    public $ifreject;
    public $nextapproval;
    public $nextapproval_name;
    public $nextreject;
    public $task_userid;
    public $task_username;
    public $created_date;

    public function render()
    {
        $goodsreq = GoodsReq::where('id','=', $this->req_id)->first();
        $this->gr_status = $goodsreq->gr_status ?? 0;
        $this->dept_id = $goodsreq->dept_id ?? 0;
        $this->user_id = $goodsreq->user_id ?? 0;
        $this->lastcomment = $goodsreq->comment ?? '';
        // $this->task_userid = $goodsreq->task_userid;
        $this->task_username = User::where('id','=',$goodsreq->task_userid)->value('name');
        $this->created_date = $goodsreq->created_at;
        $this->created_by = User::where('id','=',$goodsreq->user_id)->value('name');
        $dept = Dept::where('id','=',$this->dept_id)->first();

        $goodsreqdet = GoodsReqDet::join('goods','goods.id','=','goods_req_dets.goods_id')
        ->where('goods_req_dets.req_id','=',$this->req_id)
        
        // ->where('goods_req_dets.user_id','=',Auth::user()->id)
        
        // ->where('req_status','=',0)
        // ->where('req_id','=',null)
        ->orderBy('goods_id')
        ->get(['goods_req_dets.id','goods_req_dets.goods_id', 'goods.name','goods.goods_type','goods_req_dets.qty_req','goods_req_dets.unit',
        'goods.qty_onhand','goods_req_dets.qty_rmn', 'goods_req_dets.qty_delvr','goods_req_dets.qty_recvd']);
        $tracedoc = Tracing::where('type','=','Req-ATK')->where('doc_id','=',$this->req_id)->orderBy('created_at','desc')->get();
        // dd($trace_doc);
        // dd($goodsreqdet);
        // dd($dept_id);
        // dd($dept);
        // dd($goodsreq->gr_status);
        $approval = Status::where('type','=','Req-ATK')
            ->where('status_id','=',$this->gr_status)
            ->first();
        // dd($goodsreq->dept_id, $approval);
        if ($approval->approve == 'admin-ga') {
            $this->nextapproval = User::where('users.acting','=',$approval->approve)
                ->value('users.id');
        } else {
            $this->nextapproval = User::where('users.acting','=',$approval->approve)
                ->where('users.dept_id','=',$goodsreq->dept_id)->value('users.id');
        }
        
        // dd($this->nextapproval);
        $this->nextapproval_name = User::where('id','=',$this->nextapproval)->value('users.name');
        $this->nextreject = User::where('users.acting','=',$approval->reject)->value('users.id');
        // if($approval->approve == 'depthead'){
        //     $this->nextapproval = $goodsreq->depthead_id;
        // }
        // if($approval->reject == 'creator'){
        //     $this->nextreject = $goodsreq->user_id;
        // }
        // if($approval->approve == 'creator'){
        //     $this->nextapproval = $goodsreq->user_id;
        // }
      
        // $this->approval_id = $goodsreq->next_appr_id ?? $this->user_id;
        $this->deptname = $dept->deptname ?? 'Not Avail';
        $this->username = User::where('id','=',$this->user_id)->value('name');
        $this->remark = $goodsreq->remark ?? '';
        $this->need_date = $goodsreq->need_date ?? null;
        $this->doc_status = Status::where('type','=','Req-ATK')->where('status_id','=',$this->gr_status)->value('description');
        $this->created_id = $this->user_id;
        $this->lastcomment = $goodsreq->comment ?? '';
        // $this->doc_status = Status::where('type','=','Req-ATK')->where('status_id','=',$goodsreq->gr_status)->first()->value('description');
        // dd($this->approval_id, $user_id, Auth::user()->id);
        $header_title = 'Goods Request';
        return view('livewire.goodsreq.edit-goods-request',compact('header_title','goodsreq','goodsreqdet','dept', 'tracedoc'))->extends('layouts.backend.blankpage');
    }
    public function edit_req($item){
        $this->id = $item['id'];
        $this->goods_id = $item['goods_id'];
        $this->name = $item['name'];
        $this->goods_type = $item['goods_type'];
        $this->qty_req = $item['qty_req'];
        $this->unit = $item['unit'];

    }
    public function upd_qty_req($req_det_id, $qty){
        $goodsreqdetdata = GoodsReqDet::find($req_det_id);
        $goodsreqdetdata->qty_req = $qty;
        $goodsreqdetdata->qty_rmn = $qty;
        $goodsreqdetdata->save();
    }

    public function edit_alloc($item){
        $this->id = $item['id'];
        $this->goods_id = $item['goods_id'];
        $this->name = $item['name'];
        $this->goods_type = $item['goods_type'];
        $this->qty_req = $item['qty_req'];
        $this->unit = $item['unit'];
        $this->qty_onhand = $item['qty_onhand'];
        $this->qty_delvr = $item['qty_delvr'];

    }
    // upd_qty_delvr{{ $id }}, {{ $qty_delvr }}
    public function upd_qty_delvr($req_det_id, $goods_id, $qty){
        // dd($req_det_id, $qty);
        $goodsdata = Goods::find($goods_id);
        $goodsreqdetdata = GoodsReqDet::find($req_det_id);
        $goodsreqdetdata->qty_delvr = $qty;
        // $goodsreqdetdata->qty_rmn -= $qty;
        $goodsdata->qty_delivery += $qty;
        $goodsdata->qty_onhand -= $qty;
        $goodsreqdetdata->save();
        $goodsdata->save();


        // dd($goodsreqdetdata);
        // DB::table('goods_req_dets')
        //     ->where('id', $req_det_id)
        //     ->update(['qty_delvr' => $qty]);
        // DB::table('goods')
        //     ->where('id', $goods_id)
        //     ->increment(['qty_delivery' => $qty])
        //     ->decrement(['qty_onhand' => $qty]);
    }

    public function send_approval(){
        $data = GoodsReq::find($this->req_id);
        if ($data->gr_status <= 1) {
            // dd($data->gr_status);
            $dept = Dept::where('id','=',Auth::User()->dept_id)->first();
            $data['task_userid'] = $dept->depthead;
            $data['gr_status'] = 2;
            // $data['next_appr_id'] = $this->nextapproval;
            $data['task_userid'] = $this->nextapproval;
        } 
        $data['comment'] = $this->comment;
        // dd($data);
        // else {
        //     dd($data->gr_status, $data->next_appr_id);
        //     $data['gr_status'] = 0;
        //     $data['next_appr_id'] = Auth::user()->id;
        //     $data['task_userid'] = Auth::user()->id;
        // }
        
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['gr_status'],'Send Email');

        return redirect()->to('send-mail/' . $this->req_id);
        // dd($this->id);

    }
    public function approval(){

        $data = GoodsReq::find($this->req_id);
        $data['comment'] = $this->comment;
        $data['task_userid'] = $this->nextapproval;
        if($data['gr_status'] == 1){
            $data['gr_status'] = 2;
        }
        if($data['gr_status'] == 2){
            $data['gr_status'] = 3;
        }
        // dd($data);
        // dd('approval', $this->nextapproval, $data);
        // $data['qty_req'] = $qty;
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['gr_status'],'Approval');

        return redirect()->to('send-mail/' . $this->req_id);
        // dd($this->id);

    }
    public function create_tracing($status, $action){
        // dd('create tracing',$status);
        $trace = [
            'type' => 'Req-ATK',
            'doc_id' => $this->req_id,
            'userid' => Auth::User()->id,
            'username' => Auth::User()->name,
            'email' => Auth::User()->email,
            'status_id' => $status,
            'action' => $action,
            'comment' => $this->comment
        ];
        Tracing::create($trace);
        return 'success';
    }
    public function rejection(){
        // dd('rejection');
        // dd($this->req_id, $this->comment);
        $data = GoodsReq::find($this->req_id);
        $data['comment'] = $this->comment;
        // dd($this->gr_status);
        $approval = Status::where('type','=','Req-ATK')
        ->where('status_id','=',$this->gr_status )
        ->first();
        // dd($approval);
        // $this->next_appr_id = User::where('acting','=',$approval->reject)->where('dept_id','=',$data['dept_id'])->value('id');
        // $data['next_appr_id'] = $data['user_id'];
        $data['gr_status'] = 1;
        $data['task_userid'] = $data['user_id'];
        // dd($approval->reject, $data['next_appr_id']);
        // $data['qty_req'] = $qty;
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['gr_status'],'reject');
        return redirect()->to('send-mail/' . $this->req_id);
        // dd($this->id);

    }
    public function rejected($comment){
        dd("rejected", $comment);
    }

    public function deliver(){
        $data = GoodsReq::find($this->req_id);
        $data['comment'] = $this->comment;
        $data['task_userid'] = $this->nextapproval;
        if($data['gr_status'] == 1){
            $data['gr_status'] = 2;
        }
        if($data['gr_status'] == 2){
            $data['gr_status'] = 3; 
        }
        if($data['gr_status'] == 3){
            $data['gr_status'] = 4;
        }
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['gr_status'],'deliver');
        return redirect()->to('send-mail/' . $this->req_id);
        // dd($data);
    }

    public function edit_received($item){
        $this->id = $item['id'];
        $this->goods_id = $item['goods_id'];
        $this->name = $item['name'];
        $this->goods_type = $item['goods_type'];
        $this->qty_req = $item['qty_req'];
        $this->qty_delvr = $item['qty_delvr'];
        $this->qty_recvd = $item['qty_recvd'];
        $this->unit = $item['unit'];
    }
    public function upd_qty_received($req_det_id, $goods_id, $qty){
        $goodsdata = Goods::find($goods_id);
        $goodsreqdetdata = GoodsReqDet::find($req_det_id);
        $goodsreqdetdata->qty_delvr -= $qty;
        $goodsreqdetdata->qty_recvd += $qty;
        $goodsreqdetdata->qty_rmn -= $qty;

        $goodsdata->qty_delivery -= $qty;
        $goodsreqdetdata->save();
        $goodsdata->save();
    }

    public function received(){
        $data = GoodsReq::find($this->req_id);
        $data['comment'] = $this->comment;
        $data['task_userid'] = $this->nextapproval;
        if($data['gr_status'] == 4){
            $data['gr_status'] = 3;
        }
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['gr_status'],'received');
        return redirect()->to('send-mail/' . $this->req_id);
        // dd($data);
    }

    public function informatioin(){
        dd($goodsreq);
    }
}
