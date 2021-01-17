<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Category2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Category::insert([
            ['parent'=>'1','name'=>'Pemrograman',],
            ['parent'=>'1','name'=>'Hardware',],
            ['parent'=>'1','name'=>'Networking',],
            ['parent'=>'5','name'=>'Pemrograman Go',],
            ['parent'=>'5','name'=>'Pemrograman PHP',],
            ['parent'=>'5','name'=>'Pemrograman NodeJs',],
            ['parent'=>'5','name'=>'Pemrograman Python',],
            ['parent'=>'5','name'=>'Pemrograman Java',],
            ['parent'=>'5','name'=>'Pemrograman C#',],
            ['parent'=>'4','name'=>'Psikologi Anak',],
            ['parent'=>'4','name'=>'Analisa Kesehatan',],
            ['parent'=>'2','name'=>'Ekonomi Mikro',],
            ['parent'=>'2','name'=>'Ekonomi Makro',],
            ['parent'=>'3','name'=>'Masyrakat Perkotaan',],
            ['parent'=>'3','name'=>'Anak Remaja',],
            ['parent'=>'16','name'=>'Ekonomi Kreatif',],
        ]);
    }
}
