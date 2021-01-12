<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_album AFTER UPDATE ON `albums` FOR EACH ROW 
                        BEGIN

                        DECLARE trans_in_old VARCHAR(200);
                        DECLARE trans_in_new VARCHAR(200);

                        DECLARE trans_out_old VARCHAR(200);
                        DECLARE trans_out_new VARCHAR(200);

                            IF ((OLD.name <=> NEW.name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the album name', concat('updated the album name of ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'albums',  OLD.name, NEW.name, OLD.id);
                            END IF;

                            IF ((OLD.transition_in <=> NEW.transition_in) = 0) THEN
                            
                                SET trans_in_old = (SELECT name FROM options WHERE id = OLD.transition_in);
                                SET trans_in_new = (SELECT name FROM options WHERE id = NEW.transition_in);
 
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the album transition-in type', concat('updated the transition-in of ',OLD.name,' from ',trans_in_old,' to ',trans_in_new), NOW(), 'albums', 'trans_in_old', 'trans_in_new', OLD.id);
                            END IF;

                            IF ((OLD.transition_out <=> NEW.transition_out) = 0) THEN  

                                SET trans_out_old = (SELECT name FROM options WHERE id = OLD.transition_out);
                                SET trans_out_new = (SELECT name FROM options WHERE id = NEW.transition_out);

                                INSERT INTO cms_activity_logs (created_by, activity_type, activity_desc, dashboard_activity, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the album transition-out type', concat('updated the transition-out of ',OLD.name,' from ',trans_out_old,' to ',trans_out_new), NOW(), 'albums', 'trans_out_old', 'trans_out_new', OLD.id);
                            END IF;

                            IF ((OLD.transition <=> NEW.transition) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the album duration', concat('updated the transition duration of ',OLD.name,' from ',OLD.transition,' to ',NEW.transition, ' seconds'), NOW(), 'albums', OLD.transition, NEW.transition, OLD.id);
                            END IF;

                            IF ((OLD.type <=> NEW.type) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the album type', concat('updated the album type of ',OLD.name,' from ',OLD.type,' to ',NEW.type), NOW(), 'albums',  OLD.type, NEW.type, OLD.id);
                            END IF;

                            IF NEW.deleted_at IS NOT NULL THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'delete', 'deleted an album', concat('deleted the album ',OLD.name), NOW(), 'albums', OLD.name, '', OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_album`');
    }
}
