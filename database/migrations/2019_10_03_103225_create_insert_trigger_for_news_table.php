<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsertTriggerForNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_insert_news AFTER INSERT ON `articles` FOR EACH ROW 
                        BEGIN
                            INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, new_value)
                            Values (new.user_id, 'insert', 'created a new article', concat('created the news ',NEW.name), NOW(), 'articles', NEW.name);    
                        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_insert_news`');
    }
}
