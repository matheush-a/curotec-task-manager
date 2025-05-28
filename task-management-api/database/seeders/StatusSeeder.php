<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            ['name' => 'Pending'],
            ['name' => 'In Progress'],
            ['name' => 'Completed'],
            ['name' => 'On Hold'],
        ];

        foreach ($status as $s) {
            DB::table('status')->insert($s);
        }
    }
}
