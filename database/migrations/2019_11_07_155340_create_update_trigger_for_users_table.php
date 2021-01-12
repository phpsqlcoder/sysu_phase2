<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_users AFTER UPDATE ON `users` FOR EACH ROW 
                        BEGIN
                        
                        DECLARE role_old VARCHAR(200);
                        DECLARE role_new VARCHAR(200);
                        

                            IF ((OLD.role_id <=> NEW.role_id) = 0) THEN 

                                SET role_old = (SELECT name FROM role WHERE id = OLD.role_id);
                                SET role_new = (SELECT name FROM role WHERE id = NEW.role_id);

                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the user`s role', concat('updated the role of ',OLD.name,' from ',role_old,' to ',role_new), NOW(), 'users', role_old, role_new, OLD.id);
                            END IF;

                            IF ((OLD.firstname <=> NEW.firstname) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the user`s firstname', concat('updated the firstname of ',OLD.name,' from ',OLD.firstname,' to ',NEW.firstname), NOW(), 'users', OLD.firstname, NEW.firstname, OLD.id);
                            END IF;

                            IF ((OLD.lastname <=> NEW.lastname) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the user`s lastname', concat('updated the lastname of ',OLD.name,' from ',OLD.lastname,' to ',NEW.lastname), NOW(), 'users', OLD.lastname, NEW.lastname, OLD.id);
                            END IF;

                            IF ((OLD.email <=> NEW.email) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the user`s email', concat('updated the email of ',OLD.name,' from ',OLD.email,' to ',NEW.email), NOW(), 'users', OLD.email, NEW.email, OLD.id);
                            END IF;

                            IF ((OLD.password <=> NEW.password) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated his/her password', concat('updated the password of ',OLD.firstname,' ',OLD.lastname), NOW(), 'users', OLD.password, NEW.password, OLD.id);
                            END IF;

                            IF ((OLD.avatar <=> NEW.avatar) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table) VALUES(NEW.user_id, CASE WHEN OLD.avatar IS NULL THEN 'upload' ELSE 'update' END, CASE WHEN OLD.avatar IS NULL THEN 'upload a new avatar' ELSE 'updated his/her avatar ' END, CASE WHEN OLD.avatar IS NULL THEN 'uploaded new avatar' ELSE 'updated the avatar' END, NOW(), 'users');
                            END IF;

                            IF ((OLD.is_active <=> NEW.is_active) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', CASE WHEN NEW.is_active = 1 THEN 'activated a user' ELSE 'deactivated a user' END, CASE WHEN NEW.is_active = 1 THEN concat('activate the user name ',OLD.name) ELSE concat('deactivate the user name ', OLD.name) END, NOW(), 'users', OLD.is_active, NEW.is_active, OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_users`');
    }
}
