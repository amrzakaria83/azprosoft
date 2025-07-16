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
        Schema::create('pur_requests', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code')->nullable();
            $table->json('table_name_id')->nullable()->comment('0 =  all_pur_imports - 1 = store_pur_requests - 2 = unknowen');
            $table->text('pro_prod_id')->nullable();
            $table->text('note')->nullable();
            $table->text('quantity')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 =  Pending - 1 = Requested - 2 = Arrived at the pharmacy -
             3 = Cancelled - 4 = Executed - 5 = Cancel the execution - 6 = import purshase - 7 = done');
            $table->tinyInteger('status_pur')->default(0)->nullable()->comment('0 =  Pending - 1 = done - 2 = some_done - 3 = cancell_all');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_requests');
    }
};
