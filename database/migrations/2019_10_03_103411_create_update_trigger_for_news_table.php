<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_news AFTER UPDATE ON `articles` FOR EACH ROW 
                        BEGIN
                        DECLARE cat_id_old VARCHAR(200);
                        DECLARE cat_id_new VARCHAR(200);

                        IF(NEW.category_id <> 0) THEN

                            IF ((OLD.category_id <=> NEW.category_id) = 0) THEN 
                                SET cat_id_old = (SELECT name FROM article_categories WHERE id = OLD.category_id);
                                SET cat_id_new = (SELECT name FROM article_categories WHERE id = NEW.category_id);

                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.category_id IS NULL THEN 'added' WHEN NEW.category_id <> 0 THEN 'update' ELSE 'remove'END, CASE WHEN OLD.category_id IS NULL THEN 'added a news category type' WHEN NEW.category_id <> 0 THEN 'updated the news category' ELSE 'removed the news category type' END, CASE WHEN OLD.category_id IS NULL THEN concat('added ',cat_id_new,' to the category of ',OLD.name) WHEN NEW.category_id <> 0 THEN concat('updated the news category of ',OLD.name,' from ', cat_id_old, ' to ',cat_id_new) ELSE concat('removed ',cat_id_old,' to the category of ',OLD.name) END, NOW(), 'articles', cat_id_old, cat_id_new, OLD.id);
                            END IF;

                        END IF;

                            IF ((OLD.name <=> NEW.name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the news name', concat('updated the article name of ',NEW.name,' from ',OLD.name,' to ',NEW.name), NOW(), 'articles', OLD.name, NEW.name, OLD.id);
                            END IF;

                            IF ((OLD.deleted_at <=> NEW.deleted_at) = 0) THEN 
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'delete' ELSE 'restore' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN 'deleted a news' ELSE 'restore a news' END, CASE WHEN NEW.deleted_at IS NOT NULL THEN concat('deleted the news ',OLD.name) ELSE concat('restores the news ', OLD.name) END, NOW(), 'articles', OLD.name, '', OLD.id);
                            END IF;

                            IF ((OLD.date <=> NEW.date) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the news date', concat('updated the date of ',OLD.name,' from ',OLD.date,' to ',NEW.date), NOW(), 'articles', OLD.date, NEW.date, OLD.id);
                            END IF;

                            IF ((OLD.image_url <=> NEW.image_url) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'upload', 'uploaded a new banner', concat('uploaded new banner of ',OLD.name), NOW(), 'articles', OLD.image_url, NEW.image_url, OLD.id);
                            END IF;

                            IF ((OLD.contents <=> NEW.contents) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the news content', 'updated the content from ', NOW(), 'articles', OLD.contents, NEW.contents, OLD.id);
                            END IF;

                            IF ((OLD.teaser <=> NEW.teaser) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.teaser IS NULL THEN 'insert' WHEN NEW.teaser IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.teaser IS NULL THEN 'added a news teaser' WHEN NEW.teaser IS NULL THEN 'removed the news teaser' ELSE 'updated the news teaser' END, CASE WHEN OLD.teaser IS NULL THEN concat('added ',NEW.teaser,' to teaser of ',OLD.name) WHEN NEW.teaser IS NULL THEN concat('removed ',OLD.teaser,' from teaser of ',OLD.name) ELSE concat('updated the teaser of ',OLD.name,' from ',OLD.teaser,' to ',NEW.teaser) END, NOW(), 'articles', OLD.teaser, NEW.teaser, OLD.id);
                            END IF;
                            
                            IF ((OLD.status <=> NEW.status) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the news status', concat('updated the status of ',OLD.name,' from ',OLD.status,' to ',NEW.status), NOW(), 'articles', OLD.status, NEW.status, OLD.id);
                            END IF;

                            IF ((OLD.is_featured <=> NEW.is_featured) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', concat('updated the news type into ',CASE WHEN NEW.is_featured = 1 THEN 'featured' ELSE 'unfeatured' END), concat('updated the news ',OLD.name,' into ',CASE WHEN NEW.is_featured = 1 THEN 'featured' ELSE 'unfeatured' END), NOW(), 'articles', OLD.is_featured, NEW.is_featured, OLD.id);
                            END IF;

                            IF ((OLD.meta_title <=> NEW.meta_title) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.meta_title IS NULL THEN 'insert' WHEN NEW.meta_title IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.meta_title IS NULL THEN 'added a news meta title' WHEN NEW.meta_title IS NULL THEN 'removed the news meta title' ELSE 'updated the news meta title' END, CASE WHEN OLD.meta_title IS NULL THEN concat('added ',NEW.meta_title,' to meta title of ',OLD.name) WHEN NEW.meta_title IS NULL THEN concat('removed ',OLD.meta_title,' from meta title of ',OLD.name) ELSE concat('updated the meta title of ',OLD.name,' from ',OLD.meta_title,' to ',NEW.meta_title) END, NOW(), 'articles', OLD.meta_title, NEW.meta_title, OLD.id);
                            END IF;

                            IF ((OLD.meta_keyword <=> NEW.meta_keyword) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.meta_keyword IS NULL THEN 'insert' WHEN NEW.meta_keyword IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.meta_keyword IS NULL THEN 'added a news meta keyword' WHEN NEW.meta_keyword IS NULL THEN 'removed the news meta keyword' ELSE 'updated the news meta keyword' END, CASE WHEN OLD.meta_keyword IS NULL THEN concat('added ',NEW.meta_keyword,' to meta keyword of ',OLD.name) WHEN NEW.meta_keyword IS NULL THEN concat('removed ',OLD.meta_keyword,' from meta keyword of ',OLD.name) ELSE concat('updated the meta keyword of ',OLD.name,' from ',OLD.meta_keyword,' to ',NEW.meta_keyword) END, NOW(), 'articles', OLD.meta_keyword, NEW.meta_keyword, OLD.id);
                            END IF;

                            IF ((OLD.meta_description <=> NEW.meta_description) = 0)  THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.meta_description IS NULL THEN 'insert' WHEN NEW.meta_description IS NULL THEN 'removed' ELSE 'update' END, CASE WHEN OLD.meta_description IS NULL THEN 'added a news meta description' WHEN NEW.meta_description IS NULL THEN 'removed the news meta description' ELSE 'updated the news meta description' END, CASE WHEN OLD.meta_description IS NULL THEN concat('added ',NEW.meta_description,' to meta description of ',OLD.name) WHEN NEW.meta_description IS NULL THEN concat('removed ',OLD.meta_description,' from meta description of ',OLD.name) ELSE concat('updated the meta description of ',OLD.name,' from ',OLD.meta_description,' to ',NEW.meta_description) END, NOW(), 'articles', OLD.meta_description, NEW.meta_description, OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_news`');
    }
}
