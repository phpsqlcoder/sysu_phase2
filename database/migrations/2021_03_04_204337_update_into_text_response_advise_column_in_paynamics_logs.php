<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIntoTextResponseAdviseColumnInPaynamicsLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paynamics_logs', function (Blueprint $table) {
            $table->text('response_message')->nullable()->change();
            $table->text('response_advise')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paynamics_logs', function (Blueprint $table) {
            //
        });
    }
}
