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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(0)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('translation_lang', 10);
            $table->unsignedInteger('translation_of');
            $table->string('name', 50);
            $table->string('slug', 150)->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
