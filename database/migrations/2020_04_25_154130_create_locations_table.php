<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('viewer')->default(0);
            $table->string('name');
            $table->string('category');
            $table->string('sub_category');
            $table->string('location_coord');
            $table->string('thumbnail');
            $table->string('website');
            $table->string('tel');
            $table->string('email');
            $table->string('can_do');
            $table->text('about')->default('No data yet!');
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
        Schema::dropIfExists('locations');
    }
}
