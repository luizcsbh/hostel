<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNameColumnInTypeOfRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_of_rooms', function (Blueprint $table) {
            // Alterando a coluna 'name' para ser unique e ter 255 caracteres
            $table->string('name', 255)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_of_rooms', function (Blueprint $table) {
            // Revertendo a alteração (removendo a unique e voltando para o tamanho original)
            $table->string('name')->change(); // Ajuste conforme o estado anterior da coluna
            $table->dropUnique(['name']);
        });
    }
}
