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
        Schema::create('goodsdelivers', function (Blueprint $table) {
            $table->id();
            $table->integer('req_id');
            $table->integer('dlvr_id');
            $table->integer('goods_id');
            $table->float('qty_dlvr')->default(0);
            $table->date('plan_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goodsdelivers');
    }
};
