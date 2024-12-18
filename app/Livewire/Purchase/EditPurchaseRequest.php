<?php

namespace App\Livewire\Purchase;

use Livewire\Component;

use App\Models\Poreq;
use App\Models\PoreqDet;
use App\Models\User;
use App\Models\Dept;
use App\Models\Goods;
use App\Models\Tracing;
use App\Models\Status;
use DB;
use Auth;

class EditPurchaseRequest extends Component
{
    public $header_title;
    public $pr_id;
    public $id;

    public $username;
    // public $user_id;
    public $deptname;
    public $dept_id;
    public $need_date;
    public $remark;
    public $pr_status;
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
    public $total;
    
    public function render()
    {
        $poreq = Poreq::where('id','=', $this->pr_id)->first();
        $this->pr_status = $poreq->pr_status ?? 0;
        $this->dept_id = $poreq->dept_id ?? 0;
        $this->user_id = $poreq->user_id ?? 0;
        $this->lastcomment = $poreq->comment ?? '';
        // $this->task_userid = $poreq->task_userid;
        $this->task_username = User::where('id','=',$poreq->task_userid)->value('name');
        $this->created_date = $poreq->created_at;
        $this->created_by = User::where('id','=',$poreq->user_id)->value('name');
        $dept = Dept::where('id','=',$this->dept_id)->first();

        $poreqdet = PoreqDet::join('goods','goods.id','=','poreq_dets.goods_id')
        ->where('poreq_dets.pr_id','=',$this->pr_id)
        
        // ->where('poreq_dets.user_id','=',Auth::user()->id)
        
        // ->where('req_status','=',0)
        ->orderBy('goods_id')
        ->get(['poreq_dets.id','poreq_dets.goods_id', 'goods.name','goods.goods_type','poreq_dets.qty_req','poreq_dets.unit',
        'goods.qty_onhand','goods.qty_buffer','poreq_dets.goods_price', 'poreq_dets.qty_rmn', 'poreq_dets.qty_delvr','poreq_dets.qty_recvd']);
        // $total = poreqdet::where('poreq_dets.pr_id','=',$this->pr_id)
        //     -> sum(function($t){return $t->goods_price * $t->qty_req});
        // dd($total);
        $tracedoc = Tracing::where('type','=','Pur-ATK')->where('doc_id','=',$this->pr_id)->orderBy('created_at','desc')->get();
        // dd($trace_doc);
        // dd($poreqdet);
        // dd($dept_id);
        // dd($dept);
        $approval = Status::where('type','=','Pur-ATK')
            ->where('status_id','=',$this->pr_status)
            ->first();
        // dd($poreq->dept_id, $approval);
        if ($approval->approve == 'admin-ga') {
            // dd('admin-ga');
            $this->nextapproval = User::where('users.acting','=',$approval->approve)
                ->value('users.id');
        } 
        else if($approval->approve == 'gm'){
            // dd('gm');
            $this->nextapproval = User::where('users.acting','=',$approval->approve)
                ->value('users.id');
        }
        else if($approval->approve == 'admin-purchase'){
            $this->nextapproval = User::where('users.acting','=',$approval->approve)
                ->value('users.id');
        }
        else {
            // dd('else');
            $this->nextapproval = User::where('users.acting','=',$approval->approve)
                ->where('users.dept_id','=',$poreq->dept_id)->value('users.id');
        }
        
        
        
        // dd($this->nextapproval);
        $this->nextapproval_name = User::where('id','=',$this->nextapproval)->value('users.name');
        $this->nextreject = User::where('users.acting','=',$approval->reject)->value('users.id');
        // if($approval->approve == 'depthead'){
        //     $this->nextapproval = $poreq->depthead_id;
        // }
        // if($approval->reject == 'creator'){
        //     $this->nextreject = $poreq->user_id;
        // }
        // if($approval->approve == 'creator'){
        //     $this->nextapproval = $poreq->user_id;
        // }
      
        // $this->approval_id = $poreq->next_appr_id ?? $this->user_id;
        $this->deptname = $dept->deptname ?? 'Not Avail';
        $this->username = User::where('id','=',$this->user_id)->value('name');
        $this->remark = $poreq->remark ?? '';
        $this->need_date = $poreq->need_date ?? null;
        $this->doc_status = Status::where('type','=','Pur-ATK')->where('status_id','=',$this->pr_status)->value('description');
        $this->created_id = $this->user_id;
        $this->lastcomment = $poreq->comment ?? '';
        $header_title = 'Purchase Request';
        return view('livewire.purchase.edit-purchase-request', compact('header_title','poreq','poreqdet','dept','tracedoc'))->extends('layouts.backend.blankpage');
    }

    public function send_approval(){
        $data = poreq::find($this->pr_id);
        if ($data->pr_status <= 1) {
            $dept = Dept::where('id','=',Auth::User()->dept_id)->first();
            $data['task_userid'] = $dept->depthead;
            $data['pr_status'] = 2;
            $data['task_userid'] = $this->nextapproval;
        } 
        $data['comment'] = $this->comment;
        $data->save();
        $result = $this->create_tracing($data['pr_status'],'Send Email');

        return redirect()->to('send-mail-purchase/' . $this->pr_id);
    }

    public function create_tracing($status, $action){
        $trace = [
            'type' => 'Pur-ATK',
            'doc_id' => $this->pr_id,
            'userid' => Auth::User()->id,
            'username' => Auth::User()->name,
            'email' => Auth::User()->email,
            'status_id' => $status,
            'action' => $action,
            'comment' => $this->comment
        ];
        tracing::create($trace);
        return 'success';
    }

    public function approval(){

        $data = Poreq::find($this->pr_id);
        $data['comment'] = $this->comment;
        $data['task_userid'] = $this->nextapproval;
        if($data['pr_status'] == 1){
            $data['pr_status'] = 2;
        }
        if($data['pr_status'] == 2){
            $data['pr_status'] = 3;
        }
        // dd($data);
        // dd('approval', $this->nextapproval, $data);
        // $data['qty_req'] = $qty;
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['pr_status'],'Approval');

        return redirect()->to('send-mail-purchase/' . $this->pr_id);
        // dd($this->id);

    }

    public function deliver(){
        $data = Poreq::find($this->pr_id);
        $data['comment'] = $this->comment;
        $data['task_userid'] = $this->nextapproval;
        if($data['pr_status'] == 1){
            $data['pr_status'] = 2;
        }
        if($data['pr_status'] == 2){
            $data['pr_status'] = 3; 
        }
        if($data['pr_status'] == 3){
            $data['pr_status'] = 4;
        }
        // dd($data);
        $data->save();
        $result = $this->create_tracing($data['pr_status'],'Approved');
        return redirect()->to('send-mail-purchase/' . $this->pr_id);
        // dd($data);
    }
}
