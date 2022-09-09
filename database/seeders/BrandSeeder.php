<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id'         => 1,
                'slug'       => 'brand-1',
                'name'       => 'Brand 1',
                'status'     => 1,
                'popular'    => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 2,
                'slug'       => 'brand-2',
                'name'       => 'Brand 2',
                'status'     => 1,
                'popular'    => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 3,
                'slug'       => 'brand-3',
                'name'       => 'Brand 3',
                'status'     => 1,
                'popular'    => 1,
                'created_at' => Carbon::now()
            ]
        ];

        DB::table('brands')->insert($data);
    }
}
