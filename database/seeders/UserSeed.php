<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'dept_id' => 0,
            'password' => bcrypt('1'),
            'acting' => 'admin'
        ]);

        user::create([
            'name' => 'Jekson',
            'email' => 'jekson@tiarakencana.com',
            'dept_id' => 1,
            'password' => bcrypt('1'),
            'acting' => 'depthead'
        ]);

        user::create([
            'name' => 'Ikhsan',
            'email' => 'testing@tiarakencana.com',
            'dept_id' => 1,
            'password' => bcrypt('1'),
            'acting' => 'dept-atk'
        ]);

        user::create([
            'name' => 'Admin GA',
            'email' => 'testing1@tiarakencana.com',
            'dept_id' => 2,
            'password' => bcrypt('1'),
            'acting' => 'admin-ga'
        ]);

        user::create([
            'name' => 'Admin IT',
            'email' => 'admin_it@mail.com',
            'dept_id' => 1,
            'password' => bcrypt('1'),
            'acting' => 'admin'
        ]);
        user::create([
            'name' => 'GA Manager',
            'email' => 'testing2@tiarakencana.com',
            'dept_id' => 2,
            'password' => bcrypt('1'),
            'acting' => 'depthead,admin-atk'
        ]);
        user::create([
            'name' => 'HR Manager',
            'email' => 'it.tiara@tiarakencana.com',
            'dept_id' => 3,
            'password' => bcrypt('1'),
            'acting' => 'depthead'
        ]);
        user::create([
            'name' => 'Purchase Manager',
            'email' => 'testing4@tiarakencana.com',
            'dept_id' => 4,
            'password' => bcrypt('1'),
            'acting' => 'depthead'
        ]);
        user::create([
            'name' => 'Purchase Admin',
            'email' => 'testing3@tiarakencana.com',
            'dept_id' => 4,
            'password' => bcrypt('1'),
            'acting' => 'depthead'
        ]);
        user::create([
            'name' => 'General Manager',
            'email' => 'test1@tiarakencana.com',
            'dept_id' => 0,
            'password' => bcrypt('1'),
            'acting' => 'gm'
        ]);
    }
}
