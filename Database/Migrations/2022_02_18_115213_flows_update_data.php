<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FlowsUpdateData extends Migration
{
    public function up()
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->json('override_data')->nullable();
        });
    }

    public function down()
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->dropColumn('override_data');
        });
    }
}
