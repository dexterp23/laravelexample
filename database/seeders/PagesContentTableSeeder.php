<?php

use Illuminate\Database\Seeder;
use App\Models\PagesContent;
use Illuminate\Support\Facades\Hash;

class PagesContentTableSeeder extends Seeder
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
                'page_tag' => 'login_page'
            ]
        ];

        foreach ($data as $v) {
            PagesContent::create($v);
        }
    }
}
