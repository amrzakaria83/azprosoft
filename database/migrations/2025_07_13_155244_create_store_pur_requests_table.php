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
        Schema::create('store_pur_requests', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code')->nullable();
            $table->text('pro_start_id')->nullable();
            $table->text('pro_prod_id')->nullable();
            $table->text('name_cust')->nullable();
            $table->text('phone_cust')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 =  Pending - 1 = Requested - 2 = Arrived at the pharmacy - 
            3 = Cancelled - 4 = Executed - 5 = Cancel the execution ');
            $table->unsignedBigInteger('quantity')->default(1);
            $table->tinyInteger('type_request')->default(0)->comment('0 = cash - 1 = phone - 2 = whatsapp - 3 = page - 4 = instagram ');
            $table->string('balance_req')->nullable();
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
        Schema::dropIfExists('store_pur_requests');
    }
};
