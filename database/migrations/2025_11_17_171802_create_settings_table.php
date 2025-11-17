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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->text('about')->nullable();
            $table->string('profile_image')->nullable();

            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();

            $table->string('resume_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
