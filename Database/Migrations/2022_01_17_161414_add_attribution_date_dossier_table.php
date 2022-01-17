<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributionDateDossierTable extends Migration
{
    public function up()
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->timestamp('attribution')->nullable();
        });
    }

    public function down()
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn('attribution');
        });
    }
}
