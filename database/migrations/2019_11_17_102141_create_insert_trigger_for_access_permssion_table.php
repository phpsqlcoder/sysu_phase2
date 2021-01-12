<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsertTriggerForAccessPermssionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_insert_access_permission AFTER INSERT ON `role_permission` FOR EACH ROW 
                        BEGIN

                            DECLARE role_name VARCHAR(200);
                            DECLARE perm_name VARCHAR(200);

                            IF(NEW.isAllowed = 1) THEN
                                SET role_name = (SELECT name FROM role WHERE id = NEW.role_id);
                                SET perm_name = (SELECT description FROM permission WHERE id = NEW.permission_id);
                            
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, new_value)
                                Values (new.user_id, 'insert_access', 'updated the access permission', concat('permission name ',perm_name,' was set to ',role_name,' role'), NOW(), 'Access Rights', NEW.id); 
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
        DB::unprepared('DROP TRIGGER `tr_insert_access_permission`');
    }
}
