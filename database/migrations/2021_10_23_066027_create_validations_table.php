<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validatorable_id')
                ->nullable()
                ->constrained('validatorables', 'id')
                ->onDelete('set null');
            $table->morphs('validationable');

            $table->foreignId('approver_id')->nullable()->constrained('users', 'id')->onDelete('cascade');
            $table->boolean('is_approving')->default(false);

            $table->text('description')->nullable(); // More info
            $table->json('updated_values')->nullable(); // Data used to update fields of validationable

            $table->boolean('is_error')->default(false); // if any error in approving

            $table->foreignId('creator_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updater_id')->nullable()->constrained('users', 'id')->onDelete('set null');
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
        Schema::dropIfExists('validations');
    }
}
