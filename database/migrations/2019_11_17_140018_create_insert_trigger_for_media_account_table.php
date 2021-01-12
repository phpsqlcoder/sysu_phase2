<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsertTriggerForMediaAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_insert_media_account AFTER INSERT ON `social_media` FOR EACH ROW 
                        BEGIN
                            INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, new_value)
                            Values (new.user_id, 'insert', 'added new social media account', concat('added new social media account ',NEW.media_account), NOW(), 'social media account', NEW.media_account);    
                        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_insert_media_account`');
    }
}
