<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableForSongTagsAndSongs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_song_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('song_tag_id');
            $table->unsignedBigInteger('song_id');
            $table->foreign('song_tag_id')->references('id')->on('song_tags')->onDelete('cascade');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
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
        Schema::dropIfExists('song_song_tag');
    }
}
