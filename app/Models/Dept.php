<?php

namespace App\Models;


use App\Models\Dept;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dept extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    // protected $table = 'depts';
    static public function getrecord(){
        $return = Dept::orderBy('deptname')->get();
        return $return;
    }
}
