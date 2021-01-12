<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_banners AFTER UPDATE ON `banners` FOR EACH ROW 
        BEGIN
            
            IF ((OLD.title <=> NEW.title) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.title IS NULL THEN 'insert' WHEN NEW.title IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.title IS NULL THEN 'added a banner title' WHEN NEW.title IS NULL THEN 'removed a banner title' ELSE 'updated the banner title' END , CASE WHEN OLD.title IS NULL THEN concat('added the banner title ',NEW.title) WHEN NEW.title IS NULL THEN concat('removed a banner title ',OLD.title) ELSE concat('updated the banner title ',NEW.title,' from ',OLD.title,' to ',NEW.title) END, NOW(), 'banners', OLD.title, NEW.title, OLD.id);

            END IF;

            IF ((OLD.description <=> NEW.description) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.description IS NULL THEN 'insert' WHEN NEW.description IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.description IS NULL THEN 'added a banner description' WHEN NEW.description IS NULL THEN 'removed a banner description' ELSE 'updated the banner description' END , CASE WHEN OLD.description IS NULL THEN concat('added the banner description ',NEW.description) WHEN NEW.description IS NULL THEN concat('removed a banner description ',OLD.description) ELSE concat('updated the banner description ',NEW.description,' from ',OLD.description,' to ',NEW.description) END, NOW(), 'banners', OLD.description, NEW.description, OLD.id);

            END IF;

            IF ((OLD.alt <=> NEW.alt) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.alt IS NULL THEN 'insert' WHEN NEW.alt IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.alt IS NULL THEN 'added a banner alt' WHEN NEW.alt IS NULL THEN 'removed a banner alt' ELSE 'updated the banner alt' END , CASE WHEN OLD.alt IS NULL THEN concat('added the banner alt ',NEW.alt) WHEN NEW.alt IS NULL THEN concat('removed a banner alt ',OLD.alt) ELSE concat('updated the banner alt ',NEW.alt,' from ',OLD.alt,' to ',NEW.alt) END, NOW(), 'banners', OLD.alt, NEW.alt, OLD.id);

            END IF;

            IF ((OLD.button_text <=> NEW.button_text) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.button_text IS NULL THEN 'insert' WHEN NEW.button_text IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.button_text IS NULL THEN 'added a button text in a banner' WHEN NEW.button_text IS NULL THEN 'removed a button text of a banner' ELSE 'updated the button text of the banner' END , CASE WHEN OLD.button_text IS NULL THEN concat('added the button text ',NEW.button_text,' of ',OLD.title) WHEN NEW.button_text IS NULL THEN concat('removed the button text ',OLD.button_text,' of ',OLD.title) ELSE concat('updated the button text ',NEW.button_text,' from ',OLD.button_text,' to ',NEW.button_text) END, NOW(), 'banners', OLD.button_text, NEW.button_text, OLD.id);

            END IF;

            IF ((OLD.url <=> NEW.url) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.url IS NULL THEN 'insert' WHEN NEW.url IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.url IS NULL THEN 'added a banner url' WHEN NEW.url IS NULL THEN 'removed a banner url' ELSE 'updated the banner url' END , CASE WHEN OLD.url IS NULL THEN concat('added a banner url ',NEW.url,' of ',OLD.title) WHEN NEW.url IS NULL THEN concat('removed the banner url ',OLD.url,' of ',OLD.title) ELSE concat('updated the banner url ',NEW.url,' from ',OLD.url,' to ',NEW.url) END, NOW(), 'banners', OLD.url, NEW.url, OLD.id);

            END IF;

            IF ((OLD.order <=> NEW.order) = 0) THEN 

                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the banner order', concat('updated the banner order of ',OLD.title,' from ',OLD.order,' to ',NEW.order), NOW(), 'banners', OLD.order, NEW.order, OLD.id);

            END IF;

            IF ((OLD.deleted_at <=> NEW.deleted_at) = 0) THEN  
                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'delete', 'deleted a banner', concat('deleted the banner ',OLD.title), NOW(), 'banners', OLD.title, '', OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_banners`');
    }
}
