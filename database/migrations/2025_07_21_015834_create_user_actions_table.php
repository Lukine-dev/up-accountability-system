<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActionsTable extends Migration
{
    public function up()
    {
            Schema::create('user_actions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('action'); // e.g., Created, Updated, Deleted, Exported
                $table->string('model'); // e.g., Staff, Application
                $table->unsignedBigInteger('model_id')->nullable(); // ID of the record
                $table->text('description')->nullable(); // What was changed
                $table->timestamps();
            });
    }

    public function down()
    {
        Schema::dropIfExists('user_actions');
    }
}