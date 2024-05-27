<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Lists;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lists = Lists::all();

        foreach ($lists as $list) {
            Card::factory()
                ->count(5)
                ->for($list, 'list')
                ->for($list->author, 'author')
                ->create();
        }
    }
}