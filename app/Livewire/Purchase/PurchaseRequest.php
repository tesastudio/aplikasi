<?php

namespace App\Livewire\Purchase;

use Livewire\Component;
use App\Models\Goods;
use App\Models\PoreqDet;
use Auth;

class PurchaseRequest extends Component
{
    public $search = '';

    public $id;
    public $name;
    public $goods_type;
    public $qty_req;
    public $unit;

    public function render()
    {
        if(Auth::user()== null){
            return redirect()->route('login');
        }
        $header_title = 'Purchase Request';
        $goods = Goods::query()
            ->where('name','like','%'.$this->search.'%')
            ->orWhere('goods_type','like','%'.$this->search.'%')
            ->paginate(15);
        $poreqdet = PoreqDet::join('goods','goods.id','=','poreq_dets.goods_id')
            ->where('user_id','=',Auth::user()->id)
            ->where('pr_status','=',0)
            ->where('pr_id','=',null)
            ->orderBy('goods_id')
            ->get(['poreq_dets.id','goods.name','goods.goods_type','poreq_dets.qty_req','poreq_dets.unit']);
        
        return view('livewire.purchase.purchase-request', compact('header_title','goods','poreqdet'))->extends('layouts.backend.blankpage');
    }
    public function select($id){
        // dd("klik ", $this->canfind($id));
        if ($this->canfind($id) != null) {
            // dd('canfind produk', $this->canfind($id));
            return redirect()->with('error','Product is already chosen ');
        } else {
            
            $datagoods = Goods::find($id);
            $data = [
                'user_id' => Auth::user()->id,
                'pr_status' => 0,
                'goods_id' => $id,
                'qty_req' => 0,
                'unit' => $datagoods->unit,
                'goods_price' => $datagoods->price,
               
            ];
            // dd($data);
            PoreqDet::create($data);
        }
    }
    public function unselect($id){
        PoreqDet::find($id)->delete();
    }
    public function edit_qty_prdet($item){
        // dd($item);
        $this->id = $item['id'];
        $this->name = $item['name'];
        $this->goods_type = $item['goods_type'];
        $this->qty_req = $item['qty_req'];
        $this->unit = $item['unit'];
    }
    public function upd_qty_prdet($req_det_id, $qty){
        $data = PoreqDet::find($req_det_id);
        $data->qty_req = $qty;
        $data->qty_rmn = $qty;
        // dd($data);
        $data->total_price = $qty * $data->goods_price;
        $data->save();
    }
    public function process_po(){
        return redirect()->route('formpurchaserequest');
    }
    public function clearall(){
        $data = Poreqdet::where('user_id','=',Auth::user()->id)
            ->where('pr_status','=',0)->delete();
    }
    public function canfind($goodsid){
        // dd('canfind');
        $avail = PoreqDet::where('goods_id','=',$goodsid)
            ->where('user_id','=',Auth::user()->id)
            ->where('pr_status','=',0)
            ->where('pr_id','=',null)
            ->value('goods_id');
        // dd($avail);
        return($avail);
    }
}
