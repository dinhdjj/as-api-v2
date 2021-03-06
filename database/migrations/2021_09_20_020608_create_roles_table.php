<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('key')->primary();
            $table->string('name');
            $table->string('description');
            $table->string('color'); // Use for front-end decorate for main color

            $table->foreignId('creator_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updater_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignUuid('role_key')
                ->constrained('roles', 'key')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignUuid('permission_key')
                ->constrained('permissions', 'key')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();

            $table->primary(['role_key', 'permission_key']);
        });

        Schema::create('rolables', function (Blueprint $table) {
            $table->foreignUuid('role_key')
                ->constrained('roles', 'key')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->morphs('rolable');
            $table->timestamps();

            $table->primary(['role_key', 'rolable_id', 'rolable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('rolables');
        Schema::dropIfExists('roles');
    }
}
