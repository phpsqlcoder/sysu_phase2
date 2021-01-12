<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteTriggerForRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_role_delete AFTER DELETE ON `role` FOR EACH ROW 
                        BEGIN
                            INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value)
                            VALUES (OLD.created_by, 'delete', 'deleted a role', concat('deleted the role ',OLD.name), NOW(), 'role', OLD.name);
                        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_role_delete`');
    }
}
