<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsReq extends Model
{
    use HasFactory;
    protected $guarded = [];

    static public function getrecord(){
        $return = GoodsReq::Where('user_id','')
            ->orderBy('name')->get();
        return $return;
    }
}
