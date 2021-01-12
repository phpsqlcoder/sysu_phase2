<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_role_update AFTER UPDATE ON `role` FOR EACH ROW 
                        BEGIN
                            IF ((OLD.name <=> NEW.name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value) VALUES(NEW.created_by, 'update', 'updated the role name', concat('updated the role name of ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'role', OLD.name, NEW.name);
                            END IF;

                            IF ((OLD.description <=> NEW.description) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value) VALUES(NEW.created_by, 'update', 'updated the role description', concat('updated the role description of ',OLD.name,' from ',OLD.description,' to ',NEW.description), NOW(), 'role', OLD.description, NEW.description);
                            END IF;
                        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_role_update`');
    }
}
