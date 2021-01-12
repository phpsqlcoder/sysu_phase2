<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTriggerForSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_update_settings AFTER UPDATE ON `settings` FOR EACH ROW 
                        BEGIN

                        DECLARE new_social VARCHAR(200);
                        DECLARE old_social VARCHAR(200);

                            IF ((OLD.website_name <=> NEW.website_name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the website name', concat('updated the website name from ',OLD.website_name,' to ',NEW.website_name), NOW(), 'settings', OLD.website_name, NEW.website_name, OLD.id);
                            END IF;

                            IF ((OLD.company_name <=> NEW.company_name) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company name', concat('updated the company name from ',OLD.company_name,' to ',NEW.company_name), NOW(), 'settings', OLD.company_name, NEW.company_name, OLD.id);
                            END IF;

                            IF ((OLD.company_about <=> NEW.company_about) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company`s content', concat('updated the company content from ',OLD.company_about,' to ',NEW.company_about), NOW(), 'settings', OLD.company_about, NEW.company_about, OLD.id);
                            END IF;

                            IF ((OLD.company_address <=> NEW.company_address) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company address', concat('updated the company address from ',OLD.company_address,' to ',NEW.company_address), NOW(), 'settings', OLD.company_address, NEW.company_address, OLD.id);
                            END IF;

                            IF ((OLD.google_map <=> NEW.google_map) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the company`s google map location', 'updated the company google map location from', NOW(), 'settings', OLD.google_map, NEW.google_map, OLD.id);
                            END IF;

                            IF ((OLD.google_recaptcha_sitekey <=> NEW.google_recaptcha_sitekey) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the recaptcha key', 'updated the recaptcha key from', NOW(), 'settings', OLD.google_recaptcha_sitekey, NEW.google_recaptcha_sitekey, OLD.id);
                            END IF;

                            IF ((OLD.google_recaptcha_secret <=> NEW.google_recaptcha_secret) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the google recaptcha secret', 'updated the recaptcha secret from', NOW(), 'settings', OLD.google_recaptcha_secret, NEW.google_recaptcha_secret, OLD.id);
                            END IF;

                            IF ((OLD.data_privacy_title <=> NEW.data_privacy_title) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the data privacy title', concat('updated the data privacy title from ',OLD.data_privacy_title,' to ',NEW.data_privacy_title), NOW(), 'settings', OLD.data_privacy_title, NEW.data_privacy_title, OLD.id);
                            END IF;

                            IF ((OLD.data_privacy_popup_content <=> NEW.data_privacy_popup_content) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the data privacy popup content', 'updated the data privacy popup content from', NOW(), 'settings', OLD.data_privacy_popup_content, NEW.data_privacy_popup_content, OLD.id);
                            END IF;

                            IF ((OLD.data_privacy_content <=> NEW.data_privacy_content) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update_content', 'updated the data privacy content', 'updated the data privacy content from', NOW(), 'settings', OLD.data_privacy_content, NEW.data_privacy_content, OLD.id);
                            END IF;

                            IF ((OLD.mobile_no <=> NEW.mobile_no) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company`s mobile number', concat('updated the company mobile number from ',OLD.mobile_no,' to ',NEW.mobile_no), NOW(), 'settings', OLD.mobile_no, NEW.mobile_no, OLD.id);
                            END IF;

                            IF ((OLD.fax_no <=> NEW.fax_no) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company`s fax number', concat('updated the company fax number from ',OLD.fax_no,' to ',NEW.fax_no), NOW(), 'settings', OLD.fax_no, NEW.fax_no, OLD.id);
                            END IF;

                            IF ((OLD.tel_no <=> NEW.tel_no) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company`s telephone number', concat('updated the company telephone number from ',OLD.tel_no,' to ',NEW.tel_no), NOW(), 'settings', OLD.tel_no, NEW.tel_no, OLD.id);
                            END IF;

                            IF ((OLD.email <=> NEW.email) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, 'update', 'updated the company`s email address', concat('updated the company email from ',OLD.email,' to ',NEW.email), NOW(), 'settings', OLD.email, NEW.email, OLD.id);
                            END IF;

                            IF ((OLD.copyright <=> NEW.copyright) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.copyright = '' THEN 'insert' ELSE 'update' END, CASE WHEN OLD.copyright = '' THEN 'added a copyright year' ELSE 'updated the copyright year' END, CASE WHEN OLD.copyright = '' THEN 'added a copyright year' ELSE concat('updated the copyright from ',OLD.copyright,' to ',NEW.copyright) END, NOW(), 'settings', OLD.copyright, NEW.copyright, OLD.id);
                            END IF;

                            IF ((OLD.website_favicon <=> NEW.website_favicon) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.website_favicon = '' THEN 'upload' WHEN NEW.website_favicon = '' THEN 'remove' ELSE 'update' END, CASE WHEN OLD.website_favicon = '' THEN 'uploaded new website favicon' WHEN NEW.website_favicon = '' THEN 'removed the website favicon' ELSE 'updated the website favicon' END, CASE WHEN OLD.website_favicon = '' THEN 'uploaded a new website favicon' WHEN NEW.website_favicon = '' THEN 'removed the website favicon' ELSE 'updated the website favicon' END, NOW(), 'settings', OLD.website_favicon, NEW.website_favicon, OLD.id);
                            END IF;

                            IF ((OLD.company_logo <=> NEW.company_logo) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.company_logo = '' THEN 'upload' WHEN NEW.company_logo = '' THEN 'remove' ELSE 'update' END, CASE WHEN OLD.company_logo = '' THEN 'uploaded new company logo' WHEN NEW.company_logo = '' THEN 'removed the company logo' ELSE 'updated the company logo' END, CASE WHEN OLD.company_logo = '' THEN 'uploaded a new company logo' WHEN NEW.company_logo = '' THEN 'removed the company logo' ELSE 'updated the company logo' END, NOW(), 'settings', OLD.website_favicon, NEW.website_favicon, OLD.id);
                            END IF;

                            IF ((OLD.company_favicon <=> NEW.company_favicon) = 0) THEN  
                                INSERT INTO cms_activity_logs (created_by, activity_type, dashboard_activity, activity_desc, activity_date, db_table, old_value, new_value, reference) VALUES(NEW.user_id, CASE WHEN OLD.company_favicon = '' THEN 'upload' WHEN NEW.company_favicon = '' THEN 'remove' ELSE 'update' END, CASE WHEN OLD.company_favicon = '' THEN 'uploaded new company favicon' WHEN NEW.company_favicon = '' THEN 'removed the company favicon' ELSE 'updated company favicon' END, CASE WHEN OLD.company_favicon = '' THEN 'uploaded a new company favicon' WHEN NEW.company_favicon = '' THEN 'removed the company favicon' ELSE 'updated the company favicon' END, NOW(), 'settings', OLD.company_favicon, NEW.company_favicon, OLD.id);
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
        DB::unprepared('DROP TRIGGER `tr_update_settings`');
    }
}
