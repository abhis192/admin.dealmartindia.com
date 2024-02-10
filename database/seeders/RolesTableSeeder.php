<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfRoles = \DB::table('roles')->count();

        if($numberOfRoles == 0)
        {
            DB::table('roles')->insert([
                'name' => 'Admin',
                'slug' => 'admin',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
            DB::table('roles')->insert([
                'name' => 'Seller',
                'slug' => 'seller',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
            DB::table('roles')->insert([
                'name' => 'Customer',
                'slug' => 'customer',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }
    }
}
