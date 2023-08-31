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
        Schema::create('album_technology', function (Blueprint $table) {

            $table->unsignedBigInteger('album_id');
            $table->foreign('album_id')->references('id')->on('albums')->onUpdate('cascade')->cascadeOnDelete();;

            $table->unsignedBigInteger('technology_id');
            $table->foreign('technology_id')->references('id')->on('technologies')->onUpdate('cascade')->cascadeOnDelete();;

            $table->primary(['album_id', 'technology_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_technology');
    }
};
