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
        Schema::create('pur_waitings', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code')->nullable();
            $table->unsignedBigInteger('pur_requests_id')->nullable();
            $table->foreign('pur_requests_id')
                ->references('id')->on('pur_requests')->onDelete('cascade')->comment('pur_requests_id');
            $table->text('quantity')->nullable();
            $table->unsignedBigInteger('pur_trans_id')->nullable();
            $table->foreign('pur_trans_id')
                ->references('id')->on('pur_trans')->onDelete('cascade')->comment('pur_trans_id');
            $table->unsignedBigInteger('id_in_purchase_details')->nullable();
            $table->tinyInteger('status_pur')->default(0)->nullable()->comment('0 =  waiting - 1 = done - 2 = some_done - 3 = cancell_all');
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = not active ");
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_waitings');
    }
};
