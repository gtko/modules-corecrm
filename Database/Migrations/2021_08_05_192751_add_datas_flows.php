<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatasFlows extends Migration
{
    public function up()
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->json('datas')->nullable();
        });
    }

    public function down()
    {
        Schema::table('flows', function (Blueprint $table) {
            $table->dropColumn('datas');
        });
    }
}
