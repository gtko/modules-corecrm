<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FollowDossier extends Migration
{
    public function up()
    {
        Schema::create('dossier_user', function (Blueprint $table) {
            $table->unsignedBigInteger('dossier_id')->index();
            $table->unsignedBigInteger('user_id')->index();
        });
    }

    public function down()
    {
        Schema::drop('dossier_user');
    }
}
