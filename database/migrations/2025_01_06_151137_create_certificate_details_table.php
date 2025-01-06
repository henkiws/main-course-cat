<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_certificate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_certificate');
            $table->integer('fk_cbt_test');
            $table->text('score_text');
            $table->double('score_number');
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
        Schema::dropIfExists('user_certificate_details');
    }
}
