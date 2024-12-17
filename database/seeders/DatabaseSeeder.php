<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DeptSeed::class);
        $this->call(GoodsSeed::class);
        $this->call(UserSeed::class);
        $this->call(StatusSeed::class);
    }
}
