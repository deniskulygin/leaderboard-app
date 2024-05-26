<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->char('unique_id', 40)->unique()->nullable(false);
            $table->string('name', 40)->nullable(false);
            $table->unsignedInteger('created_at')->nullable(false);
            $table->unsignedInteger('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        //
    }
};
