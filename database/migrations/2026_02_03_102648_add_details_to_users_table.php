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
            $table->string('firstname')->nullable()->after('name');
            $table->string('lastname')->nullable()->after('firstname');
            
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->text('content')->change();
            $table->string('image')->nullable()->after('content');
            $table->string('status')->default('published')->after('image'); // published, flagged, pending
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['firstname', 'lastname', 'slug', 'is_admin']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('content')->change();
            $table->dropColumn(['image', 'status']);
        });
    }
};
