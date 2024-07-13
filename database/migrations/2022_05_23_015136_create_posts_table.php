<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->longText('cover_image')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->longText('body');
            $table->boolean('is_in_vault')->required()->default(false);
            $table->text('meta_description')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
