<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('doc_id');
            $table->integer('userid');
            $table->string('username');
            $table->string('email');
            $table->integer('status_id');
            $table->string('action');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracings');
    }
};
