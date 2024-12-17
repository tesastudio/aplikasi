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
        Schema::create('goods_reqs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('dept_id');
            $table->integer('depthead_id')->nullable();
            $table->integer('task_userid')->nullable();
            $table->date('need_date');
            $table->string('remark');
            $table->tinyInteger('gr_status')->default(0)->comment('0: started, 1:');
            // $table->integer('next_appr_id')->default(0)->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_reqs');
    }
};
