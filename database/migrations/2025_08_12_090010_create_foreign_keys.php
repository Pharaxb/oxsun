<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('operator_id')->references('id')->on('operators')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->foreign('operator_id')->references('id')->on('operators')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->foreign('min_age_id')->references('id')->on('ages')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->foreign('max_age_id')->references('id')->on('ages')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('cities', function(Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('districts', function(Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ad_user', function(Blueprint $table) {
            $table->foreign('ad_id')->references('id')->on('ads')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('ad_user', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('transactions', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('sms_tokens', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->foreign('district_id')->references('id')->on('districts')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_operator_id_foreign');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->dropForeign('ads_user_id_foreign');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->dropForeign('ads_operator_id_foreign');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->dropForeign('ads_min_age_id_foreign');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->dropForeign('ads_max_age_id_foreign');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->dropForeign('ads_status_id_foreign');
        });
        Schema::table('ads', function(Blueprint $table) {
            $table->dropForeign('ads_admin_id_foreign');
        });
        Schema::table('cities', function(Blueprint $table) {
            $table->dropForeign('cities_province_id_foreign');
        });
        Schema::table('districts', function(Blueprint $table) {
            $table->dropForeign('districts_city_id_foreign');
        });
        Schema::table('ad_user', function(Blueprint $table) {
            $table->dropForeign('ad_user_ad_id_foreign');
        });
        Schema::table('ad_user', function(Blueprint $table) {
            $table->dropForeign('ad_user_user_id_foreign');
        });
        Schema::table('transactions', function(Blueprint $table) {
            $table->dropForeign('transactions_user_id_foreign');
        });
        Schema::table('sms_tokens', function(Blueprint $table) {
            $table->dropForeign('sms_tokens_user_id_foreign');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->dropForeign('user_locations_user_id_foreign');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->dropForeign('user_locations_province_id_foreign');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->dropForeign('user_locations_city_id_foreign');
        });
        Schema::table('user_locations', function(Blueprint $table) {
            $table->dropForeign('user_locations_district_id_foreign');
        });
    }
};
