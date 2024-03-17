<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('username')->unique()->after('email');
            $table->string('first_name')->after('email');
            $table->string('last_name')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
