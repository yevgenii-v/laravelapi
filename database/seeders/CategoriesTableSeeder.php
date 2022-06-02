<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];

        $cName = 'No category';
        $categories[] = [
            'name' => $cName,
        ];

        for ($i = 1; $i <= 10; $i++) {
            $cName = 'Category #'.$i;

            $categories[] = [
                'name' => $cName,
            ];
        }

        DB::table('categories')->insert($categories);

        unset($cName, $categories);

        for ($i = 11; $i <= 40; $i++) {
            $cName = 'Category #'.$i;

            $categories[] = [
                'name' => $cName,
                'parent_id' => rand(1, 11),
            ];
        }

        DB::table('categories')->insert($categories);


    }
}
