<?php

namespace Database\Seeders;

use App\Models\Dept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DeptSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dept::create([
            'deptname' => 'IT',
            'depthead' => 2
        ]);

        Dept::create([
            'deptname' => 'GA',
            'depthead' => 6
        ]);

        Dept::create([
            'deptname' => 'HR',
            'depthead' => 6
        ]);
        Dept::create([
            'deptname' => 'PR',
            'depthead' => 7
        ]);
        Dept::create([
            'deptname' => 'GM',
            'depthead' => 10
        ]);
    }
}
