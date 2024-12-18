<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GoodsReqDet;
use App\Models\Goods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Auth;

class GoodsReqDet extends Model
{
    use HasFactory;
    protected $guarded = [];

    static public function getrecord(){
        $return = GoodsReqDet::join('goods','goods.id','=','goods_req_dets.goods_id')
            ->where('user_id','=',Auth::user()->id)
            ->where('req_status','=',0)
            ->orderBy('goods_id')
            ->get(['goods_req_dets.id','goods.name','goods.goods_type']);
        return $return;
    }
}
