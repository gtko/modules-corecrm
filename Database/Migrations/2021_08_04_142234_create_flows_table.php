<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlowsTable extends Migration
{
    public function up()
    {
        Schema::create('flows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('flowable');
            $table->unsignedBigInteger('event_id')->index();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flows');
        Schema::dropIfExists('events');
    }
}
