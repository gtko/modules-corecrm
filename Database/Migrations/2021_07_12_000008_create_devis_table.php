<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_id');
            $table->unsignedBigInteger('commercial_id');
            $table->json('data');
            $table->boolean('tva_applicable')->default(true);
            $table->unsignedBigInteger('fournisseur_id')->nullable();

            $table->index('tva_applicable');
            $table->index('fournisseur_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis');
    }
}
