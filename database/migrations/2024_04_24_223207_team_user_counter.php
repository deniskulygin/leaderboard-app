<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_user_counters', function (Blueprint $table) {
            $table->id();
            $table->char('unique_id', 40)->unique()->nullable(false);
            $table->unsignedBigInteger('team_user_id')->index()->nullable(false);
            $table->unsignedBigInteger('count')->index()->default(0);
            $table->unsignedInteger('created_at')->nullable(false);
            $table->unsignedInteger('updated_at')->nullable();
            $table->unique('team_user_id');
            $table->foreign('team_user_id')->references('id')->on('team_users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        //
    }
};
