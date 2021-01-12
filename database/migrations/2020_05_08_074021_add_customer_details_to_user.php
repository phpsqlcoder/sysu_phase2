<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerDetailsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {          
            $table->string('mobile', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address_street', 250)->nullable();
            $table->string('address_city', 250)->nullable();
            $table->string('address_province', 150)->nullable();
            $table->string('address_zip', 10)->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
