<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecursosMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos_media', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->unsignedBigInteger('id_comentario');
            $table->unsignedBigInteger('id_persona');

            $table->foreign('id_comentario')->references('id')->on('comentarios')->onDelete('cascade');
            $table->foreign('id_persona')->references('id')->on('personas');
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
        Schema::dropIfExists('recursos_media');
    }
}
