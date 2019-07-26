<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('modelo_id')->unsigned();
            $table->foreign('modelo_id')->references('id')->on('modelos');

            $table->unsignedBigInteger('venta_id')->unsigned();
            $table->foreign('venta_id')->references('id')->on('ventas');

            $table->integer('quantity');
            $table->double('price', 5, 2);


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
        Schema::dropIfExists('detalle_ventas');
    }
}
