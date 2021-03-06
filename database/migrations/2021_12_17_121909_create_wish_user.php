<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('context');
            $table->string('accessToken', 1000)->nullable();
            $table->string('refreshToken')->nullable();
            $table->string('accessTokenExpiration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wish_users');
    }
}
