<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteTriggerForMediaAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_delete_media_account AFTER DELETE ON `social_media` FOR EACH ROW 
                        BEGIN
                            INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value)
                            VALUES (OLD.user_id, 'remove', 'removed the social media account', concat('removed the social media account ',OLD.media_account), NOW(), 'social media account', OLD.media_account);
                        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_delete_media_account`');
    }
}
