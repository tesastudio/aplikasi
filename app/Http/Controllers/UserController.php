<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function list(){
        // $data['getrecord'] = Dept::getrecord();
        $data['users'] = User::getrecord();
        $data['header_title'] = 'Employee List';
        return view('admin.employee.list',$data);
    }
}
