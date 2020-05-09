<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rawCate = ["Things to Do","Restuarant","Accommodation","Shopping",];
        for ($i=0; $i < 4; $i++) { 
            DB::table('categories')->insert([
            'category' => $rawCate[$i],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
}
