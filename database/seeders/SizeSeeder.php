<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = ['S','M','L','XL','XXL'];
        if (!empty($sizes)){
            foreach ($sizes as $size) {
                $save = new Size();
                $save->size = $size;
                $save->save();
            }
        }
    }
}
