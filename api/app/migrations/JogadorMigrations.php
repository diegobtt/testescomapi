<?php

namespace app\migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
class JogadorMigrations {

    public function up (){
        Capsule::schema()->create('jogador', function($table) {
            $table->increments("id");
            $table->string("nome");
            $table->string("posicao")->nullable();
            $table->unsignedInteger("id_time"); // unsigned integer para chave estrangeira
            $table->timestamps();

            // Definindo a chave estrangeira
            $table->foreign("id_time")
                  ->references("id")
                  ->on("times")
                  ->onDelete("cascade");
        });
    }

    public function down (){
        Capsule::schema()->table('jogadors', function ($table) {
            $table->dropForeign(['id_time']);
        });
        
        Capsule::schema()->drop("jogadors");
    }
}