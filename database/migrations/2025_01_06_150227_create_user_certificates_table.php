<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user');
            $table->integer('fk_certificate');
            $table->string('ref');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->datetime('expired_date')->nullable();
            $table->datetime('certificate_date')->nullable();
            $table->smallInteger('status')->default(0);
            $table->integer('created_by');
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
        Schema::dropIfExists('user_certificates');
    }
}
