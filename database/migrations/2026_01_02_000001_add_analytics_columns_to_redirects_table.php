<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->string('ip', 45)->nullable()->after('link_id');
            $table->text('user_agent')->nullable()->after('ip');
            $table->text('referer')->nullable()->after('user_agent');
            $table->string('referrer_host')->nullable()->after('referer');
            $table->string('country_code', 2)->nullable()->after('referrer_host');
            $table->string('device_type', 20)->nullable()->after('country_code');
        });
    }

    public function down(): void
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->dropColumn([
                'ip',
                'user_agent',
                'referer',
                'referrer_host',
                'country_code',
                'device_type',
            ]);
        });
    }
};
