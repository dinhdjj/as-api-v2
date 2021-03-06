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
            $table->id();
            $table->unsignedBigInteger('balance')->default(0);
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('avatar_path');
            $table->string('login')->unique(); # Like username of user
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->foreignId('creator_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updater_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('userables', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->morphs('userable');
            $table->timestamps();

            $table->primary(['user_id', 'userable_id', 'userable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userables');
        Schema::dropIfExists('users');
    }
}
