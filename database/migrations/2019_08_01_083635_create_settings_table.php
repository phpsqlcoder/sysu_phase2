<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id');
            $table->text('api_key')->nullable();
            $table->string('website_name', 150);
            $table->text('website_favicon');
            $table->text('company_logo');
            $table->text('company_favicon');
            $table->string('company_name', 150);
            $table->text('company_about');
            $table->text('company_address');
            $table->text('google_analytics')->nullable();
            $table->text('google_map')->nullable();
            $table->text('google_recaptcha_sitekey')->nullable();
            $table->text('google_recaptcha_secret')->nullable();
            $table->string('data_privacy_title', 150);
            $table->string('data_privacy_popup_content', 150);
            $table->text('data_privacy_content');
            $table->string('mobile_no')->nullable();
            $table->string('fax_no')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('email')->nullable();
            $table->text('social_media_accounts')->nullable();
            $table->string('copyright')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
