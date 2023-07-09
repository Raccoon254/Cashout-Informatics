<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['user', 'admin'])->default('user'); // 'type' column with 'user' as default
            $table->enum('status', ['activated', 'not_activated'])->default('not_activated'); // 'status' column with 'not_activated' as default
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']); // drop 'type' and 'status' columns
        });
    }
}
