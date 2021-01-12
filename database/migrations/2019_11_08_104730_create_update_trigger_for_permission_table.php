<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_permission AFTER UPDATE ON `permission` FOR EACH ROW 
                        BEGIN
                            IF ((OLD.name <=> NEW.name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the permission name', concat('updated the permission route of ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'permission', OLD.name, NEW.name, OLD.id);
                            END IF;

                            IF ((OLD.module <=> NEW.module) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the permission`s module', concat('updated the permisson module of ',OLD.name,' from ',OLD.module,' to ',NEW.module), NOW(), 'permission', OLD.module, NEW.module, OLD.id);
                            END IF;

                            IF ((OLD.is_view_page <=> NEW.is_view_page) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN NEW.is_view_page > 0 THEN 'update' ELSE 'removed' END, CASE WHEN NEW.is_view_page > 0 THEN 'updated the permission into a view/listing page' ELSE 'removed the view/listing page category of the permission' END, CASE WHEN NEW.is_view_page > 0 THEN concat(OLD.description,' was set to a view/listing page') ELSE concat('removed the view/listing page category of permission ',OLD.description) END, NOW(), 'permission', CASE WHEN OLD.is_view_page > 0 THEN 'disable' ELSE 'enable' END, CASE WHEN NEW.is_view_page > 0 THEN 'disable' ELSE 'enable' END, OLD.id);
                            END IF;
                                
                            IF ((OLD.description <=> NEW.description) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the permission description', concat('updated the permission description of ',NEW.description,' from ',OLD.description,' to ',NEW.description), NOW(), 'permission', OLD.description, NEW.description, OLD.id);
                            END IF;

                            IF ((OLD.deleted_at <=> NEW.deleted_at) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'delete' ELSE 'restore' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'deleted a pemission' ELSE 'restore a permssion' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN concat('deleted the permission ',OLD.description) ELSE concat('restores the permission ', OLD.description) END, NOW(), 'permission', OLD.description, '', OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_permission`');
    }
}
