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
        Schema::create('site_updates', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('from')->required();
            $table->string('subject')->required()->unique();
            $table->string('slug')->required();
            $table->text('content');
            $table->string('status')->required()->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_updates');
    }
};
