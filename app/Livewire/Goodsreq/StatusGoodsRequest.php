<?php

namespace App\Livewire\Goodsreq;

use Livewire\Component;
use App\Models\GoodsReq;
use App\Models\GoodsReqDet;
use Auth;

class StatusGoodsRequest extends Component
{
    public $id;
    public $header_title;

   
    public function render()
    {
        $goodsreq = GoodsReq::join('users','users.id','=','goods_reqs.user_id')
            ->join('depts','depts.id','=','goods_reqs.dept_id')
            ->join('users as task', 'task.id','=','goods_reqs.task_userid')
            ->join('statuses as status', function($join){
                $join->on('status.status_id','=','goods_reqs.gr_status')
                ->where('status.type','=','Req-ATK');
            })
            ->get(['goods_reqs.id','goods_reqs.user_id','users.name','goods_reqs.dept_id','depts.deptname',
                'goods_reqs.need_date','goods_reqs.gr_status','goods_reqs.remark','task.name as taskname',
                'status.description as status_desc']);
        $goodsreqdet = GoodsReqDet::join('goods','goods.id','=','goods_req_dets.goods_id')
            ->where('user_id','=',Auth::user()->id)
            ->where('req_status','>=',1)
            ->where('req_id','=',$this->id)
            ->orderBy('goods_id')
            ->get(['goods_req_dets.id','goods.name','goods.goods_type','goods_req_dets.qty_req','goods_req_dets.unit']);
        // dd($this->id);
        // $id = 10;
        $header_title = 'Goods Request List';
        // return view('livewire.goods-req.form-goods-req', compact('header_title', 'count_item', 'user','dept', 'goodsreqdet'))->extends('layouts.backend.blankpage');
        return view('livewire.goodsreq.status-goods-request', compact('header_title','goodsreq','goodsreqdet'))->extends('layouts.backend.blankpage');
    }

    public function select($id){
        return redirect()->to('editgoodsrequest/' . $id);
        // $this->header_title = 'testing';
        // dd($header_title);
        // return $header_title;
    }
}
