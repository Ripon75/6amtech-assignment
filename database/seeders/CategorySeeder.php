<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class CategorySeeder extends Seeder
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
                'slug'       => 'category-1',
                'name'       => 'Category 1',
                'status'     => 1,
                'popular'    => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 2,
                'slug'       => 'category-2',
                'name'       => 'Category 2',
                'status'     => 1,
                'popular'    => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 3,
                'slug'       => 'category-3',
                'name'       => 'Category 3',
                'status'     => 1,
                'popular'    => 1,
                'created_at' => Carbon::now()
            ]
        ];

        DB::table('categories')->insert($data);
    }
}
