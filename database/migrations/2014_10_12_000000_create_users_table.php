<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('first');
            $table->string('last');
            $table->string('email')->unique();
            $table->text('pic')->nullable();
            $table->date('birth_date');
            $table->boolean('active')->default(1);
            $table->text('works_as')->nullable();
            $table->string('phone')->nullable();
            $table->string('level')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('details')->nullable();
            $table->text('tags')->nullable();
            $table->text('address')->nullable();
            $table->text('slug');
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
