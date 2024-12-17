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
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('goods_type');
            $table->integer('dept_id')->nullable();
            $table->tinyInteger('is_asset')->default(0)->comment('0:no 1:yes');;
            $table->string('unit')->nullable();
            $table->float('qty_onhand')->nullable();
            $table->float('qty_buffer')->nullable();
            $table->float('qty_onorder')->nullable();
            $table->float('qty_delivery')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
};
