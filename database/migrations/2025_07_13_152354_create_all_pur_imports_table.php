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
        Schema::create('all_pur_imports', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code');
            $table->string('product_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('balance_req')->nullable();
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = not active ");
            $table->tinyInteger('status_request')->default(0)->comment('0 = waitting - 1 = pur_drug_requests');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_pur_imports');
    }
};
