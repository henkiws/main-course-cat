<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMainGroupTable extends Migration
{
    public function up()
    {
        Schema::table('groups', function($table) {
            $table->integer('fk_cbt_group')->default(0)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function($table) {
            $table->dropColumn('fk_cbt_group');
        });
    }
}
