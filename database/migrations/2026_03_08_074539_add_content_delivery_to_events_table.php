<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->tinyInteger('content_delivery')
                  ->after('description')
                  ->comment('1=same day, 2=2-5 days, 3=5-7 days, 4=more than 7 days');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('content_delivery');
        });
    }
};
