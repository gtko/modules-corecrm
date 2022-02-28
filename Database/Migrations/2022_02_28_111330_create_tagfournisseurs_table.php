<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagfournisseursTable extends Migration
{
    public function up()
    {
        Schema::create('tagfournisseurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        }); 

        Schema::create('fournisseur_tagfournisseur', function (Blueprint $table) {
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('tagfournisseur_id');
        });

    }

    public function down()
    {
        Schema::dropIfExists('tagfournisseurs');
        Schema::dropIfExists('fournisseur_tagfournisseur');
    }
}
