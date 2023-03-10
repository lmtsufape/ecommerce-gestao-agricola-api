<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //$table->foreignId('banco_id')->nullable(false)->constrained('bancos');
            $table->decimal('distancia_feira', 6, 3);
            $table->decimal('distancia_semana', 6, 3,);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtors');
    }
};
