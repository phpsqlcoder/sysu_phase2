<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewActivityLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_activity_logs AS SELECT l.*, u.email, u.firstname, u.lastname, r.name as role_name from cms_activity_logs AS l 
                            LEFT JOIN users AS u ON u.id = l.created_by
                            LEFT JOIN role AS r ON r.id = u.role_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW view_activity_logs');
    }
}
