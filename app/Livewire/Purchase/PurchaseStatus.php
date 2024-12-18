<?php

namespace App\Livewire\Purchase;

use Livewire\Component;
use App\Models\Poreq;
use App\Models\PoreqDet;
use Auth;

class PurchaseStatus extends Component
{
    public $id;
    // public $header_title;
    public function render()
    {
        $poreq = Poreq::join('users','users.id','=','poreqs.user_id')
            ->join('depts','depts.id','=','poreqs.dept_id')
            ->join('users as task', 'task.id','=','poreqs.task_userid')
            ->join('statuses as status', function($join){
                $join->on('status.status_id','=','poreqs.pr_status')
                ->where('status.type','=','Req-ATK');
            })
            ->get(['poreqs.id','poreqs.user_id','users.name','poreqs.dept_id','depts.deptname',
                'poreqs.need_date','poreqs.pr_status','poreqs.remark','task.name as taskname',
                'status.description as status_desc']);
        // $poreqdet = PoreqDet::join('goods','goods.id','=','poreq_dets.goods_id')
        //     ->where('user_id','=',Auth::user()->id)
        //     ->where('pr_status','>=',1)
        //     ->where('req_id','=',$this->id)
        //     ->orderBy('goods_id')
        //     ->get(['poreq_dets.id','goods.name','goods.goods_type','poreq_dets.qty_req','poreq_dets.unit']);
        // dd($this->id);
        // $id = 10;
        $header_title = 'Purchase Request List';
        // return view('livewire.goods-req.form-goods-req', compact('header_title', 'count_item', 'user','dept', 'goodsreqdet'))->extends('layouts.backend.blankpage');
        return view('livewire.purchase.purchase-status', compact('header_title','poreq'))->extends('layouts.backend.blankpage');
    }
    public function select($id){
        return redirect()->to('editpurchaserequest/' . $id);
        // $this->header_title = 'testing';
        // dd($header_title);
        // return $header_title;
    }
}
