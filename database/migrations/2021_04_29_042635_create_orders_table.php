<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->date('order_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('created_way');
            $table->integer('invoice_number')->nullable();
            $table->integer('print_count')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('district_code')->nullable();
            $table->string('phone');
            $table->string('payment_method');
            $table->integer('txn_num')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('coupon')->nullable();
            $table->string('shipping_title');
            $table->integer('shipping_cost');
            $table->integer('discount')->nullable();
            $table->integer('discount_percent')->default(0);
            $table->integer('fees')->nullable();
            $table->integer('total')->nullable();
            $table->string('notes')->nullable();
            $table->string('status');
            $table->string('user');
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
