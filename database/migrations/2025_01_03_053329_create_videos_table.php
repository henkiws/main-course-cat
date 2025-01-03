<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_videos', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fk_chapter');
            $table->text('link');
            $table->string('title');
            $table->text('description');
            $table->datetime('date_class');
            $table->string('tutor');
            $table->smallInteger('position')->default(0);
            $table->smallInteger('active')->default(1);
            $table->smallInteger('created_by');
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
        Schema::dropIfExists('chapter_videos');
    }
}
