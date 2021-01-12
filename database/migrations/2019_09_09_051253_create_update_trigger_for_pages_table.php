<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_pages_update AFTER UPDATE ON `pages` FOR EACH ROW 
                        BEGIN

                        DECLARE album_id_old VARCHAR(200);
                        DECLARE album_id_new VARCHAR(200);

                        IF(NEW.parent_page_id > 0) THEN

                            IF ((OLD.parent_page_id <=> NEW.parent_page_id) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the parent id of the page', concat('updated the parent page id of ',OLD.name,' from ',OLD.parent_page_id,' to ',NEW.parent_page_id), NOW(), 'pages', OLD.parent_page_id, NEW.parent_page_id, OLD.id);
                            END IF;
                            
                        END IF;

                            IF ((OLD.image_url <=> NEW.image_url) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the page banner type', CASE WHEN OLD.image_url = '' THEN concat('updated the page banner type of ',OLD.name,' from slider to image') ELSE concat('updated the page banner type of ',OLD.name,' from image to slider') END, NOW(), 'pages', CASE WHEN OLD.image_url = '' THEN 'slider' ELSE 'image' END, CASE WHEN NEW.image_url = '' THEN 'slider' ELSE 'image' END, OLD.id);
                            END IF;

                            IF ((OLD.name <=> NEW.name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the page name', concat('updated the page title of ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'pages', OLD.name, NEW.name, OLD.id);
                            END IF;

                            IF ((OLD.label <=> NEW.label) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the page label', concat('updated the page label of ',OLD.name,' from ',OLD.label,' to ',NEW.label), NOW(), 'pages', OLD.label, NEW.label, OLD.id);
                            END IF;

                            IF ((OLD.contents <=> NEW.contents) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the page content', 'updated the page content from ', NOW(), 'pages', OLD.contents, NEW.contents, OLD.id);
                            END IF;

                            IF ((OLD.status <=> NEW.status) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the page status', concat('updated the page status of ',OLD.name,' from ',OLD.status,' to ',NEW.status), NOW(), 'pages', OLD.status, NEW.status, OLD.id);
                            END IF;
                            
                            IF ((OLD.page_type <=> NEW.page_type) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the page type', concat('updated the page banner type of ',OLD.name,' from ',OLD.page_type,' to ',NEW.page_type), NOW(), 'pages', OLD.page_type, NEW.page_type, OLD.id);
                            END IF;

                            IF ((OLD.meta_title <=> NEW.meta_title) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.meta_title IS NULL THEN 'insert' WHEN NEW.meta_title IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.meta_title IS NULL THEN 'added a page meta title' WHEN NEW.meta_title IS NULL THEN 'removed the page meta title' ELSE 'updated the page meta title' END, CASE WHEN OLD.meta_title IS NULL THEN concat('added ',NEW.meta_title,' to meta title of ',OLD.name) WHEN NEW.meta_title IS NULL THEN concat('removed ',OLD.meta_title,' from meta title of ',OLD.name) ELSE concat('updated the meta title of ',OLD.name,' from ',OLD.meta_title,' to ',NEW.meta_title) END, NOW(), 'pages', OLD.meta_title, NEW.meta_title, OLD.id);
                            END IF;

                            IF ((OLD.meta_keyword <=> NEW.meta_keyword) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.meta_keyword IS NULL THEN 'insert' WHEN NEW.meta_keyword IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.meta_keyword IS NULL THEN 'added the page meta keyword' WHEN NEW.meta_keyword IS NULL THEN 'removed the page meta keyword' ELSE 'updated the page meta keyword' END, CASE WHEN OLD.meta_keyword IS NULL THEN concat('added ',NEW.meta_keyword,' to meta keyword of ',OLD.name) WHEN NEW.meta_keyword IS NULL THEN concat('removed ',OLD.meta_keyword,' from meta keyword of ',OLD.name) ELSE concat('updated the meta keyword of ',OLD.name,' from ',OLD.meta_keyword,' to ',NEW.meta_keyword) END, NOW(), 'pages', OLD.meta_keyword, NEW.meta_keyword, OLD.id);
                            END IF;

                            IF ((OLD.meta_description <=> NEW.meta_description) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.meta_description IS NULL THEN 'insert' WHEN NEW.meta_description IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.meta_description IS NULL THEN 'added the page meta description' WHEN NEW.meta_description IS NULL THEN 'removed the page meta description' ELSE 'updated the page meta description' END, CASE WHEN OLD.meta_description IS NULL THEN concat('added ',NEW.meta_description,' to meta description of ',OLD.name) WHEN NEW.meta_description IS NULL THEN concat('removed ',OLD.meta_description,' from meta description of ',OLD.name) ELSE concat('updated the meta description of ',OLD.name,' from ',OLD.meta_description,' to ',NEW.meta_description) END, NOW(), 'pages', OLD.meta_description, NEW.meta_description, OLD.id);
                            END IF;

                            IF ((OLD.template <=> NEW.template) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the page template', concat('updated the template of ',OLD.name,' from ',OLD.template,' to ',NEW.template), NOW(), 'pages', OLD.template, NEW.template, OLD.id);
                            END IF;

                            IF ((OLD.deleted_at <=> NEW.deleted_at) = 0) THEN 
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'delete' ELSE 'restore' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'deleted a page' ELSE 'restore a page' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN concat('deleted the page ',OLD.name) ELSE concat('restores the page ', OLD.name) END, NOW(), 'pages', OLD.name, '', OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_pages_update`');
    }
}
