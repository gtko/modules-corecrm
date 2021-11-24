<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowsTable extends Migration
{
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->json('events')->nullable();
            $table->json('conditions')->nullable();
            $table->json('actions')->nullable();

            $table->boolean('active')->index()->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflows');
    }
}
