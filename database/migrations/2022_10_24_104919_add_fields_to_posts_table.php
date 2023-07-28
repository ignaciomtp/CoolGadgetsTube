<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('icon', 10)->nullable();
            $table->integer('related_1')->nullable();
            $table->integer('related_2')->nullable();
            $table->integer('related_3')->nullable();
            $table->integer('related_4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('related_1');
            $table->dropColumn('related_2');
            $table->dropColumn('related_3');
            $table->dropColumn('related_4');
        });
    }
}
