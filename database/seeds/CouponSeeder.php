<?php

use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     *
     */
    public function run()
    {
        //
        \Illuminate\Support\Facades\DB::table('coupons')->truncate();

        \Illuminate\Support\Facades\DB::table('coupons')->insert([
            [
                'name' => 'FIXED10',
                'min_price' => 50,
                'min_items' => 1,
                'discount_type' => 'fixed',
                'discount_amount' => 10,
                'discount_percentage' => 0,
                'currency_symbol' => '$',
                'created_at' => \Illuminate\Support\Carbon::today(),
                'updated_at' => \Illuminate\Support\Carbon::today(),
            ],
            [
                'name' => 'PERCENT10',
                'min_price' => 100,
                'min_items' => 2,
                'discount_type' => 'percentage',
                'discount_amount' => 0,
                'discount_percentage' => 10,
                'currency_symbol' => '$',
                'created_at' => \Illuminate\Support\Carbon::today(),
                'updated_at' => \Illuminate\Support\Carbon::today(),
            ],
            [
                'name' => 'MIXED10',
                'min_price' => 200,
                'min_items' => 3,
                'discount_type' => 'greater',
                'discount_amount' => 10,
                'discount_percentage' => 10,
                'currency_symbol' => '$',
                'created_at' => \Illuminate\Support\Carbon::today(),
                'updated_at' => \Illuminate\Support\Carbon::today(),
            ],
            [
                'name' => 'REJECTED10',
                'min_price' => 1000,
                'min_items' => 0,
                'discount_type' => 'both',
                'discount_amount' => 10,
                'discount_percentage' => 10,
                'currency_symbol' => '$',
                'created_at' => \Illuminate\Support\Carbon::today(),
                'updated_at' => \Illuminate\Support\Carbon::today(),
          ]
        ]);
    }
}
