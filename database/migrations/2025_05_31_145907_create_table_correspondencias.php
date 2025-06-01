<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('correspondencias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email_usuario');
            $table->foreign('email_usuario')
                ->references('email')
                ->on('usuarios')
                ->onDelete('cascade');
            $table->string('caixa_postal');
            $table->string('unidade');
            $table->string('status');
            $table->dateTime('data_recebimento');
            $table->string('correspondencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_correspondencias');
    }
};
