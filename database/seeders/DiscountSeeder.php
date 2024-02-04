<?php

namespace Database\Seeders;

use App\Http\Resources\Discount;
use App\Models\DiscountRule;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas =  [
            [
                "discount_code"=>"10_PERCENT_OVER_1000",
                "discount_type"=>"percentage",
                "priority"=>9,
                "is_active"=>1,
                "category_id"=>0,
                "product_id"=>0,
                "rule"=>1000,
                "rule_rate"=>10
            ],
            [
                "discount_code"=>"BUY_5_GET_1",
                "discount_type"=>"per_unit",
                "priority"=>10,
                "is_active"=>1,
                "category_id"=>2,
                "product_id"=>0,
                "rule"=>6,
                "rule_rate"=>1
            ],
            [
                "discount_code"=>"BUY_2_LOW_PRICE_PERCENT_20",
                "discount_type"=>"low_price_percentage",
                "priority"=>10,
                "is_active"=>1,
                "category_id"=>1,
                "product_id"=>0,
                "rule"=>2,
                "rule_rate"=>20
            ]
        ];

        foreach ($datas as $data) {
            $discount = new DiscountRule();
            $discount->create($data);
        }
    }
}
