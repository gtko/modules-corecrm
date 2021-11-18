<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipelinesTable extends Migration
{
    public function up()
    {
        Schema::create('pipelines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->dropColumn('weight');
            $table->unsignedBigInteger('pipeline_id')->index();
            $table->integer('order')->index();
            $table->enum('type', ['new', 'win', 'lost', 'custom'])->default('custom')->index();
        });

    }

    public function down()
    {
        Schema::dropIfExists('pipelines');

        Schema::table('statuses', function (Blueprint $table) {
            $table->dropColumn('pipeline_id');
            $table->dropColumn('order');
            $table->integer('weight')->default(0);
        });
    }
}
