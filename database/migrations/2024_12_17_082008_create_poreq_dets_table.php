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
        Schema::create('poreq_dets', function (Blueprint $table) {
            $table->id();
            $table->integer('pr_id')->nullable();
            $table->integer('user_id');
            $table->tinyInteger('pr_status')->default(0)->comment('0: started, 1:');
            $table->integer('goods_id');
            $table->float('qty_req')->default(0);
            $table->string('unit');
            $table->float('qty_delvr')->default(0);
            $table->float('qty_recvd')->default(0);
            $table->float('qty_rmn')->default(0);
            $table->float('goods_price')->default(0);
            $table->float('total_price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poreq_dets');
    }
};
