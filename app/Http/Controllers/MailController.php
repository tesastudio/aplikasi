<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Models\GoodsReq;
use App\Models\Poreq;
use DB;


class MailController extends Controller
{
    public function sendEmail($id){
        $goodsreq = GoodsReq::join('depts','depts.id','=','goods_reqs.dept_id')
            ->join('users','users.id','=','goods_reqs.task_userid')
            ->where('goods_reqs.id','=', $id)->first();
        
        // dd($goodsreq);
        $body = 'Mohon approvalnya untuk Permintaan Barang ATK ini <br>';
        $body = $body . $goodsreq->remark . '<br><br>';
        $body = $body . $goodsreq->comment . '<br>';
        $body = $body . '<a href="'. config('app.url').'/editgoodsrequest/'. $id . '">Click me</a><br> ';
        $detail = [
            'title' => 'Need approval for ATK Requested by: '. $goodsreq->deptname,
            'body' =>  $body
        ];
        // dd($goodsreq);
        Mail::to($goodsreq->email)->send(new TestMail($detail));
        // dd('mailcontroller');
        return redirect()->back()->with('success','Sending email to '. $goodsreq->email . ' already successfully');
    }
    public function sendEmailPurchase($id){
        // dd('sendMailPurchase',$id);
        $poreq = Poreq::join('depts','depts.id','=','poreqs.dept_id')
            ->join('users','users.id','=','poreqs.task_userid')
            ->where('poreqs.id','=', $id)->first();
        
        // dd($poreq);
        $body = 'Mohon approvalnya untuk Permintaan Barang ATK ini <br>';
        $body = $body . $poreq->remark . '<br><br>';
        $body = $body . $poreq->comment . '<br>';
        $body = $body . '<a href="'. config('app.url').'/editporequest/'. $id . '">Click me</a><br> ';
        $detail = [
            'title' => 'Need approval for ATK Requested by: '. $poreq->deptname,
            'body' =>  $body
        ];
        // dd($poreq);
        Mail::to($poreq->email)->send(new TestMail($detail));
        // dd('mailcontroller');
        return redirect()->back()->with('success','Sending email to '. $poreq->email . ' already successfully');
    }
}
