<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 80);
            $table->string('image', 30);
            $table->string('description_short');
            $table->text('description_long');
            $table->integer('interlink_1')->nullable();
            $table->integer('interlink_2')->nullable();
            $table->integer('interlink_3')->nullable();
            $table->integer('interlink_4')->nullable();
            $table->boolean('menu')->default(false);
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
        Schema::dropIfExists('categories');
    }
}
