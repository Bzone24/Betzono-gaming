<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_user_id')->nullable()->after('remember_token');
            $table->string('api_login_url')->nullable()->after('api_user_id');
            $table->string('user_type')->nullable()->after('api_login_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['api_user_id', 'api_login_url', 'user_type']);
        });
    }
};
