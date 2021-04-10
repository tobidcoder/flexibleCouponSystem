<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique();
            $table->decimal('min_price',20,2)->default(0);
            $table->bigInteger('min_items')->default(0);
            $table->enum('discount_type',['fixed','percentage','both','greater']);
            $table->decimal('discount_amount',20,2)->default(0);
            $table->integer('discount_percentage')->default(0);
            $table->string('currency_symbol',5);
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
        Schema::dropIfExists('coupons');
    }
}
