<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->bigIncrements('id');

            
            $table->unsignedBigInteger('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos');
            

            $table->unsignedBigInteger('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('marcas');

            $table->unsignedBigInteger('talla_id')->unsigned();
            $table->foreign('talla_id')->references('id')->on('tallas');

            $table->string('name');

            $table->integer('stock')->nullable();
            
            $table->timestamps();
        });
        /*
        Schema::table('modelos', function (Blueprint $table) {
            // foreign
            $table->foreign('tipo_id')->references('id')->on('tipos');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('talla_id')->references('id')->on('tallas');
        });*/
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelos');
    }
}
