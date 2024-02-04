<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_rules', function (Blueprint $table) {
            $table->id();
            $table->string('discount_code'); //10_PERCENT_OVER_1000 , BUY_2_LOW_PRICE_PERCENT_20 , BUY_5_GET_1
            $table->string('discount_type'); //percentage , total , lower_price 
            $table->tinyInteger('priority'); //10
            $table->tinyInteger('is_active');  //1
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->integer('rule'); //1000
            $table->integer('rule_rate'); //10
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rules');
    }
}
