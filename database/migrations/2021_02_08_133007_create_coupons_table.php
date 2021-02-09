<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name',150);
            $table->text('description');
            $table->text('terms_and_conditions')->nullable();
            $table->string('activation_type',150)->nullable();
            $table->string('customer_scope')->nullable();
            $table->string('scope_customer_name',150)->nullable();
            $table->string('location',150)->nullable();
            $table->decimal('amount',16,2)->nullable();
            $table->integer('percentage')->nullable();
            $table->string('gift_name',150)->nullable();
            $table->integer('free_product_id')->nullable();
            $table->integer('upgrade_product_id')->nullable();
            $table->string('status',150);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('event_name',150)->nullable();
            $table->date('event_date')->nullable();
            $table->integer('repeat_annually')->nullable();
            $table->text('purchase_product_id')->nullable();
            $table->text('purchase_product_cat_id')->nullable();
            $table->text('purchase_product_brand')->nullable();
            $table->decimal('purchase_amount',16,2)->nullable();
            $table->string('purchase_amount_type',150)->nullable();
            $table->decimal('purchase_qty',16,2)->nullable();
            $table->string('purchase_qty_type',150)->nullable();
            $table->string('activity_type',150)->nullable();
            $table->string('org_name',150)->nullable();
            $table->integer('inactive_no')->nullable();
            $table->string('inactive_type',150)->nullable();
            $table->integer('customer_limit')->nullable();
            $table->string('usage_limit',150)->nullable();
            $table->integer('usage_limit_no')->nullable();
            $table->integer('transaction_limit')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('coupons');
    }
}
