<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'status_id' => 1,
            'type' => 'Req-ATK',
            'description' => 'Created',
            'approve' => 'depthead',
            'reject' => 'dept-atk'
            
        ]);
        Status::create([
            'status_id' => 2,
            'type' => 'Req-ATK',
            'description' => 'Approval',
            'approve' => 'admin-ga',
            'reject' => 'dept-atk'
            
        ]);
        Status::create([
            'status_id' => 3,
            'type' => 'Req-ATK',
            'description' => 'Deliver',
            'approve' => 'dept-atk',
            'reject' => 'dept-atk'
        ]);
        Status::create([
            'status_id' => 4,
            'type' => 'Req-ATK',
            'description' => 'Received',
            'approve' => 'admin-ga',
            'reject' => 'admin-ga'
        ]);
        Status::create([
            'status_id' => 5,
            'type' => 'Req-ATK',
            'description' => 'Closed',
            'approve' => '',
            'reject' => ''
        ]);




        Status::create([
            'status_id' => 0,
            'type' => 'Pur-ATK',
            'description' => 'Create',
            'approve' => 'depthead',
            'reject' => ''
        ]);
        Status::create([
            'status_id' => 1,
            'type' => 'Pur-ATK',
            'description' => 'Acknowledge',
            'approve' => 'depthead',
            'reject' => ''
            
        ]);
        Status::create([
            'status_id' => 2,
            'type' => 'Pur-ATK',
            'description' => 'Approved',
            'approve' => 'gm',
            'reject' => 'admin-ga'
            
        ]);
        Status::create([
            'status_id' => 3,
            'type' => 'Pur-ATK',
            'description' => 'Purchase',
            'approve' => 'admin-purchase',
            'reject' => 'admin-ga'
            
        ]);
        Status::create([
            'status_id' => 4,
            'type' => 'Pur-ATK',
            'description' => 'Purchase',
            'approve' => 'admin-purchase',
            'reject' => 'admin-ga'
            
        ]);
    }
}
