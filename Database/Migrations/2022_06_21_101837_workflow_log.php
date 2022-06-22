<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkflowLog extends Migration
{
    public function up()
    {
        Schema::create('workflow_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('flow_id')->nullable();
            $table->unsignedBigInteger('workflow_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('data')->nullable();
            $table->text('message')->nullable();
            $table->enum('conditions', ['wait', 'ok', 'nok', 'error'])->default('wait');
            $table->enum('actions', ['wait', 'ok', 'nok', 'error'])->default('wait');
            $table->enum('status', ['wait', 'ok', 'nok', 'error'])->default('wait');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflow_logs');
    }
}
