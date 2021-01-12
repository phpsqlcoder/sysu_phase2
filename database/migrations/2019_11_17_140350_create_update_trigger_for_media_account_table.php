<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForMediaAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_media_account AFTER UPDATE ON `social_media` FOR EACH ROW 
        BEGIN
            
            IF ((OLD.name <=> NEW.name) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the social media account type', concat('updated the social media type ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'social media account', OLD.name, NEW.name, OLD.id);

            END IF;

            IF ((OLD.media_account <=> NEW.media_account) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the social media account', concat('updated the social media acount ',NEW.media_account,' from ',OLD.media_account,' to ',NEW.media_account), NOW(), 'social media account', OLD.media_account, NEW.media_account, OLD.id);
                
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
        DB::unprepared('DROP TRIGGER `tr_update_media_account`');
    }
}
