<?php

namespace App\Livewire\Goodsreq;

use Livewire\Component;
use App\Models\Goods;
use App\Models\GoodsReqDet;
use Auth;
use Livewire\WithPagination;
use DB;

class GoodsRequest extends Component
{
    use WithPagination;
    // public $header_title;
    public $search = '';
    public $qty_req;
    public $id;
    public $name;
    public $goods_type;
    public $unit;
    public $data;

    protected $paginationTheme = 'bootstrap';
    // $this->id = $item['id'];
    // $this->name = $item['name'];
    // $this->goods_type = $item['goods_type'];
    // $this->qty_req = $item['qty_req'];
    // $this->unit = $item['unit'];
    
    
    public function render()
    {
        // $data['header_title'] = 'Goods Request';
        // $data['goods'] = goods::getrecord();
        // dd(Auth::user());
        if(Auth::user()== null){
            return redirect()->route('login');
        }
        $header_title = 'Goods Requesition';
        // $goods = goods::getrecord();

        $goods = Goods::query()
            ->where('name','like','%'.$this->search.'%')
            ->orWhere('goods_type','like','%'.$this->search.'%')
            ->paginate(15);
        $goodsreqdet = GoodsReqDet::join('goods','goods.id','=','goods_req_dets.goods_id')
            ->where('user_id','=',Auth::user()->id)
            ->where('req_status','=',0)
            ->where('req_id','=',null)
            ->orderBy('goods_id')
            ->get(['goods_req_dets.id','goods.name','goods.goods_type','goods_req_dets.qty_req','goods_req_dets.unit']);
        return view('livewire.goodsreq.goods-request', compact('header_title','goods','goodsreqdet'))->extends('layouts.backend.blankpage');
    }

    public function select($id){
        
        $datagoods = Goods::find($id);
        $data = [
            'user_id' => Auth::user()->id,
            'req_status' => 0,
            'goods_id' => $id,
            'qty_req' => 0,
            'unit' => $datagoods->unit
        ];
        // dd($data);
        GoodsReqDet::create($data);
    }

    public function unselect($id){
        $data = GoodsReqDet::find($id)->delete();
    }
    public function clearall(){
        $data = GoodsReqDet::where('user_id','=',Auth::user()->id)
            ->where('req_status','=',0)->delete();
    }
    public function submit(){
        return redirect()->route('formgoodsrequest');
    }
  
    public function edit_req($item){
        $this->id = $item['id'];
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
    
}
