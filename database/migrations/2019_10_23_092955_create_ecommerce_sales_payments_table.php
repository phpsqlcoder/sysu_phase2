<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcommerceSalesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_sales_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_header_id');
            $table->string('payment_type',150);
            $table->decimal('amount',16,4);
            $table->string('status',100);
            $table->date('payment_date')->default(date('Y-m-d'));
            $table->string('receipt_number',150);
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_sales_payments');
    }
}
