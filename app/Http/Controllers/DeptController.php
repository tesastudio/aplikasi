<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dept;

class DeptController extends Controller
{
    public function list(){
        // $data['getrecord'] = Dept::getrecord();
        $data['depts'] = Dept::getrecord();
        $data['header_title'] = 'Dept List';
        return view('admin.dept.list',$data);
    }
}
