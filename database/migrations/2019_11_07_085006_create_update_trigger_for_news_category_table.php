<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForNewsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_news_category AFTER UPDATE ON `article_categories` FOR EACH ROW 
                        BEGIN
                            IF ((OLD.name <=> NEW.name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the news category name', concat('updated the news category name of ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'news category', OLD.name, NEW.name, OLD.id);
                            END IF;

                            IF ((OLD.deleted_at <=> NEW.deleted_at) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'delete' ELSE 'restore' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'deleted a news category' ELSE 'restores the news category' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN concat('deleted the news category ',OLD.name) ELSE concat('restores the news category ', OLD.name) END, NOW(), 'news category', OLD.name, '', OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_news_category`');
    }
}
