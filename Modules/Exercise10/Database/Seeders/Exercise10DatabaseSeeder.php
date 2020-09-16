<?php

namespace Modules\Exercise10\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Exercise10\Models\CardLevel;
use Carbon\Carbon;

class Exercise10DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $type = config('exercise10.card_type');
        $data = [
            [
                'type' => $type['sliver'],
                'amount_limit' => '3000',
                'bonus' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['sliver'],
                'amount_limit' => '5000',
                'bonus' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['sliver'],
                'amount_limit' => '10000',
                'bonus' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['gold'],
                'amount_limit' => '3000',
                'bonus' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['gold'],
                'amount_limit' => '5000',
                'bonus' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['gold'],
                'amount_limit' => '10000',
                'bonus' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['black'],
                'amount_limit' => '3000',
                'bonus' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['black'],
                'amount_limit' => '5000',
                'bonus' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => $type['black'],
                'amount_limit' => '10000',
                'bonus' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        CardLevel::insert($data);
    }
}
