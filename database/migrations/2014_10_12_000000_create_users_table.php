<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('deviceToken', 256)->nullable();
            $table->string('fbID')->nullable();
            $table->string('googleID')->nullable();
            $table->string('appleID')->nullable();
            $table->time('prayTime')->nullable();
            $table->boolean('enablePush')->default(1);
            $table->boolean('enableEmail')->default(1);
            $table->string('bibleLanguageCode')->default('ENG');
            $table->string('bibleLanguageName')->default('English');
            $table->string('bibleVersionCode')->nullable();
            $table->string('bibleVersionName')->nullable();
            $table->string('damID')->nullable();
            $table->integer('religionID')->nullable();
            $table->boolean('paid')->default(false);
            $table->dateTime('lastPray')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_active')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
