<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForAccessPermssionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_access_permission AFTER UPDATE ON `role_permission` FOR EACH ROW 
        BEGIN
            
            DECLARE role_name VARCHAR(200);
            DECLARE perm_name VARCHAR(200);
            
            IF ((OLD.isAllowed <=> NEW.isAllowed) = 0) THEN 

                SET role_name = (SELECT name FROM role WHERE id = NEW.role_id);
                SET perm_name = (SELECT description FROM permission WHERE id = NEW.permission_id);

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.isAllowed = 0 THEN 'insert_access' ELSE 'remove_access' END, CASE WHEN OLD.isAllowed = 0 THEN 'set an access permission in a role' ELSE 'removed an access permission in a role' END, CASE WHEN OLD.isAllowed = 0 THEN concat('permission name ',perm_name,' was set to ',role_name,' role') ELSE concat('permission name ',perm_name,' was removed in ',role_name,' role') END, NOW(), 'Access Right', OLD.isAllowed, NEW.isAllowed, OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_access_permission`');
    }
}
