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
        Schema::create('pur_trans', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code')->nullable();
            $table->unsignedBigInteger('id_in_pur_requests')->nullable();
            $table->text('pro_prod_id')->nullable();
            $table->text('pro_vendor_id')->nullable();
            $table->text('note')->nullable();
            $table->text('quantity')->nullable();
            $table->tinyInteger('type_action')->default(0)->comment('0 = done_pur - 1 = unavilable - 2 = cancell_pur - 3 = some_pur - 4 = udatequnt');
            $table->text('quantity_befor')->nullable();
            $table->text('quantity_after')->nullable();
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = not active ");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_trans');
    }
};
