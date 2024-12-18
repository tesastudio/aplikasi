<?php

namespace App\Models;

use App\Models\Goods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goods extends Model
{
    use HasFactory;
    protected $guarded = [];

    static public function getrecord(){
        $return = Goods::orderBy('name');
        if(!empty(Request::get('goodsname')) ){
            $return = $return->where('name','like','%'.Request::get('goodsname').'%');
        }
        if(!empty(Request::get('goodstype')) ){
            $return = $return->where('goods_type','like','%'.Request::get('goodstype').'%');
        }
        $return = $return->orderBy('goods.name','asc')
            ->paginate(15);
        return $return;
    }
}
