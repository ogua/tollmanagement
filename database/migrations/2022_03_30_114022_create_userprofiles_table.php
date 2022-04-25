<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('pic')->nullable();
            $table->string('title')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('othernames')->nullable();
            $table->string('fullname')->nullable();
            $table->string('gender')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('license')->nullable();
            $table->string('status')->default('0');
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
        Schema::dropIfExists('userprofiles');
    }
}
